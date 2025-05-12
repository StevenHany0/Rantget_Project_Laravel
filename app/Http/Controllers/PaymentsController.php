<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller
{


    public function showMonths($contractId)
{
    $contract = Contract::with('tenant')->findOrFail($contractId);

    $startDate = Carbon::parse($contract->start_date);
    $endDate = Carbon::parse($contract->end_date);
    $currentDate = Carbon::now();

    $months = [];

    while ($startDate->lte($endDate)) {
        $year = $startDate->year;
        $month = $startDate->month;
        $monthName = $startDate->format('F Y');

        // التحقق من الدفع
        $payment = Payment::where('contract_id', $contractId)
            ->whereYear('payment_date', $year)
            ->whereMonth('payment_date', $month)
            ->first();

        // تحديد الحالة حسب الدفع
        if ($payment) {
            $status = 'paid'; // ✅ مدفوع
        } elseif ($startDate->lt($currentDate)) {
            $status = 'late'; // 🔴 متأخر
        } else {
            $status = 'unpaid'; // ⚪ لم يحن موعده بعد
        }

        $months[] = [
            'number' => $month,
            'year' => $year,
            'name' => $monthName,
            'status' => $status
        ];

        $startDate->addMonth();
    }

    return view('payments.months', compact('contract', 'months',));
}


    public function create($contractId, $month, $year)
    {
        $contract = Contract::with('tenant', 'property')->findOrFail($contractId);

        // التحقق مما إذا كان الدفع قد تم لهذا الشهر
        $isPaid = Payment::where('contract_id', $contractId)
                        ->whereYear('payment_date', $year)
                        ->whereMonth('payment_date', $month)
                        ->exists();

        if ($isPaid) {
            return redirect()->route('payments.months', ['contractId' => $contractId])
                            ->with('error', 'This month is already paid.');
        }

        return view('payments.create', compact('contract', 'month', 'year'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contract_id' => 'required|exists:contracts,id',
            'amount' => 'required|numeric|min:1',
            'card_number' => 'required|digits:16',
            'expiry_date' => ['required', 'regex:/^\d{2}\/\d{2}$/'],
            'cvv' => 'required|digits:3',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // التأكد من أن الدفع لهذا الشهر لم يتم بالفعل
        $exists = Payment::where('contract_id', $request->contract_id)
            ->whereYear('payment_date', $request->year)
            ->whereMonth('payment_date', $request->month)
            ->exists();

        if ($exists) {
            return redirect()->route('payments.months', ['contractId' => $request->contract_id])
                ->with('error', 'Payment for this month has already been made.');
        }

        // ✅ Fake Visa Validation (اختبار فقط)
        $validVisaCards = [
            '4111111111111111',
            '4000056655665556',
            '4012888888881881'
        ];

        if (!in_array($request->card_number, $validVisaCards)) {
            return redirect()->back()->with('error', 'Invalid Visa card number. Please try again.')->withInput();
        }

        // ✅ إنشاء سجل الدفع مباشرةً مع الحالة "paid"
        Payment::create([
            'contract_id' => $request->contract_id,
            'amount' => $request->amount,
            'payment_method' => 'Visa',
            'card_number' => substr($request->card_number, -4), // حفظ آخر 4 أرقام فقط
            'payment_date' => Carbon::create($request->year, $request->month, 1),
            'status' => 'paid' // ✅ تعيين الحالة مباشرةً كـ "paid"
        ]);

        return redirect()->route('payments.months', ['contractId' => $request->contract_id])
            ->with('success', 'Payment Successful! Your Visa card was processed.');
    }

    // PaymentController.php
    public function showPayments($renter_id)
    {
        $renter = User::where('role', 'tenant')->get();

        $contract = $renter->contract; // التأكد من جلب العقد الخاص بالمستأجر

        $months = collect();
        $current = Carbon::parse($contract->start_date);
        $end = Carbon::parse($contract->end_date);

        while ($current->lte($end)) {
            $month = $current->format('Y-m');
            $payment = Payment::where('contract_id', $contract->id)->where('month', $month)->first();

            $months->push([
                'month' => $month,  // 🔹 هنا نتأكد أن المفتاح 'month' موجود
                'name' => $current->translatedFormat('F Y'),
                'status' => $payment?->status ?? 'unpaid',
                'payment_date' => $payment?->payment_date,
                'number' => $current->month,
                'year' => $current->year,
            ]);

            $current->addMonth();
        }

        return view('payments.months', compact('months', 'contract'));
    }

}




<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Contract;
use App\Models\Property;
use App\Models\User;
use App\Models\Payment;

class RenterController extends Controller
{
    public function index()
    {
        $renter = Auth::user();

        $rentedproperties = Property::whereHas('contracts', function ($query) use ($renter) {
            $query->where('tenant_id', $renter->id);
        })->get();

        return view('dashboard.renter', compact('rentedproperties'));
    }

    public function show()
    {
        $renter = auth()->user();
    
        // جلب جميع العقارات التي قام المستخدم الحالي باستئجارها
        $rentedproperties = Property::whereHas('contracts', function ($query) use ($renter) {
            $query->where('tenant_id', $renter->id);
        })->get();
    
        if ($rentedproperties->isEmpty()) {
            return redirect()->route('dashboard.renter')->with('error', 'لا يوجد عقارات مستأجرة.');
        }
    
        $contracts = [];
        $landlords = [];
        $months = [];
    
        foreach ($rentedproperties as $property) {
            // جلب العقد للمستخدم الحالي
            $contract = Contract::where('property_id', $property->id)
                                ->where('tenant_id', auth()->id())
                                ->first();
    
            if (!$contract) {
                return redirect()->route('dashboard.renter')->with('error', 'لا يوجد عقد لهذا العقار.');
            }
    
            $landlords[$property->id] = $property->landlord;
            $contracts[$property->id] = $contract;
    
            // حساب الأشهر لكل عقد
            $startDate = Carbon::parse($contract->start_date)->startOfMonth();
            $endDate = Carbon::parse($contract->end_date)->endOfMonth();
            $currentDate = Carbon::now()->startOfMonth();
    
            $payments = Payment::where('contract_id', $contract->id)
                            ->pluck('payment_date')
                            ->map(fn($date) => Carbon::parse($date)->format('Y-m'));
    
            while ($startDate->lte($endDate)) {
                $monthKey = $startDate->format('Y-m');
                $monthName = $startDate->translatedFormat('F Y');
    
                $status = $payments->contains($monthKey) ? 'paid' : ($startDate->lt($currentDate) ? 'late' : 'unpaid');
    
                $months[$property->id][] = [
                    'number' => $startDate->month,
                    'year' => $startDate->year,
                    'name' => $monthName,
                    'status' => $status
                ];
    
                $startDate->addMonth();
            }
        }
    
        return view('dashboard.rented-properties', compact('rentedproperties', 'contracts', 'landlords', 'months'));
    }
    

    public function rentProperty($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $tenant = Auth::user();

        // التحقق مما إذا كان العقار مستأجرًا بالفعل من قبل نفس المستأجر
        $contractExists = Contract::where('property_id', $propertyId)
            ->where('tenant_id', $tenant->id)
            ->exists();

        if ($contractExists) {
            return back()->with('error', 'العقار مؤجر بالفعل لهذا المستخدم.');
        }

        // إنشاء عقد جديد بين المستأجر والمالك
        Contract::create([
            'property_id' => $property->id,
            'tenant_id' => $tenant->id,
            'landlord_id' => $property->landlord_id,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addYear(),
            'rent_amount' => $property->rent_price
        ]);

        return back()->with('success', 'تم تأجير العقار بنجاح!');
    }

    public function getTenantContract(User $tenant)
    {
        $landlord = auth()->user();

        $contract = Contract::whereHas('property', function ($query) use ($landlord) {
            $query->where('landlord_id', $landlord->id);
        })->where('tenant_id', $tenant->id)->first();

        if (!$contract) {
            return redirect()->back()->with('error', 'لا يوجد عقد لهذا المستأجر.');
        }

        return view('landlord.contract', compact('contract'));
    }

    public function getTenants()
    {
        $landlord = auth()->user();

        $tenants = User::whereHas('contracts', function ($query) use ($landlord) {
            $query->whereHas('property', function ($q) use ($landlord) {
                $q->where('landlord_id', $landlord->id);
            });
        })->get();

        return view('landlord.tenants', compact('tenants'));
    }

    public function showMonths($contractId)
{
    $contract = Contract::with('tenant')->findOrFail($contractId);

    $startDate = Carbon::parse($contract->start_date)->startOfMonth();
    $endDate = Carbon::parse($contract->end_date)->endOfMonth();
    $currentDate = Carbon::now()->startOfMonth();

    // جلب جميع المدفوعات لهذا العقد دفعة واحدة بصيغة Y-m
    $payments = Payment::where('contract_id', $contractId)
                        ->pluck('payment_date')
                        ->map(fn($date) => Carbon::parse($date)->format('Y-m'));

    $months = [];

    while ($startDate->lte($endDate)) {
        $monthKey = $startDate->format('Y-m');
        $monthName = $startDate->translatedFormat('F Y'); // لجعل الأشهر تظهر باللغة العربية إذا كانت مدعومة

        // تحديد حالة الدفع لكل شهر
        if ($payments->contains($monthKey)) {
            $status = 'paid';
        } elseif ($startDate->lt($currentDate)) {
            $status = 'late';
        } else {
            $status = 'unpaid';
        }

        $months[] = [
            'number' => $startDate->month,
            'year' => $startDate->year,
            'name' => $monthName,
            'status' => $status
        ];

        $startDate->addMonth(); // الانتقال إلى الشهر التالي
    }
    dd($months);

    return view('dashboard.months', compact('contract', 'months'));
}}
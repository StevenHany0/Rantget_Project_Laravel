<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\History;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ContractsController extends Controller
{
    public function index()
    {
        $contracts = Contract::all();
        return view('contracts.index', compact('contracts'));
    }
    public function create(Request $request)
    {
        $propertyId = $request->query('property');
        $property = Property::find($propertyId);

        if (!$property) {
            return redirect()->route('contracts.index')->with('error', 'Property not found.');
        }

        $landlords = User::where('role', 'landlord')->get();
        $tenants = User::where('role', 'tenant')->get();

        return view('contracts.create', compact('property', 'landlords', 'tenants'));
    }



    public function store(Request $request)
    {

        // dd($request()->all());

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'landlord_id' => 'required|exists:users,id',
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_amount' => 'required|numeric|min:0',
            'insurance_amount' => 'required|numeric',
            'contract_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'penalty_amount' => 'required|string',                ]);

        $validatedData = $request->all();
        $validatedData['penalty_amount'] = ($validatedData['penalty_amount'] === 'yes') ? 1 : 0;

        if ($request->hasFile('contract_image')) {
            $contractImagePath = $request->file('contract_image')->store('contract_image', 'public');
            $validatedData['contract_image'] = $contractImagePath;
        }
        Contract::create($validatedData);


        return redirect()->route('landlord.contracts.index')->with('success', 'Contract created successfully.');
    }

    public function show(Contract $contract)
    {
        return view('contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $properties = Property::all();
        $landlords = User::where('role', 'landlord')->get();
        $tenants = User::where('role', 'tenant')->get();

        return view('contracts.edit', compact('contract', 'properties', 'landlords', 'tenants'));
    }

    public function update(Request $request, Contract $contract)
{
    $request->validate([
        'property_id' => 'required|exists:properties,id',
        'landlord_id' => 'required|exists:users,id',
        'tenant_id' => 'required|exists:users,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'total_amount' => 'required|numeric|min:0',
        'insurance_amount' => 'required|numeric',
        'contract_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'penalty_amount' => 'required|string',
    ]);

    $oldData = $contract->toArray(); // حفظ البيانات القديمة قبل التحديث
    $validatedData = $request->all();
    $validatedData['penalty_amount'] = ($validatedData['penalty_amount'] === 'yes') ? 1 : 0;

    if ($request->hasFile('contract_image')) {
        $contractImagePath = $request->file('contract_image')->store('contract_image', 'public');
        $validatedData['contract_image'] = $contractImagePath;
    }

    $contract->update($validatedData);

    // تسجيل التحديث في `History`
    History::create([
        'contract_id' => $contract->id,
        'user_id' => auth::id(),
        'action_type' => 'updated',
        'old_data' => json_encode($oldData),
        'new_data' => json_encode($validatedData),
    ]);

    return redirect()->route('contracts.index')->with('success', 'Contract updated successfully.');
}

public function destroy(Contract $contract)
{
    // تحميل بيانات المستأجر لضمان تسجيلها في `histories`
    $contract->load('tenant');

    $oldData = [
        'start_date' => $contract->start_date,
        'end_date' => $contract->end_date,
        'total_amount' => $contract->total_amount,
        'insurance_amount' => $contract->insurance_amount,
        'status' => $contract->status,
        'tenant_name' => $contract->tenant->fullname ?? 'No Tenant',
    ];

    // تسجيل الحذف في `History`
    History::create([

        'contract_id' => $contract->id,
        'user_id' => Auth::id() ?? null, // تجنب الخطأ في حالة عدم وجود مستخدم
        'action_type' => 'deleted',
        'old_data' => json_encode($oldData),
        'new_data' => null,
    ]);

    // تنفيذ الحذف
    $contract->delete();

    return to_route('contracts.index')->with('success', 'Contract deleted successfully and logged in history.');
}
}

@extends('layout.master')

@section('content')


<div class="container mt-5">
    <h1 class="text-center mb-4">Create Contract</h1>
    <div class="card shadow-lg p-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contracts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- @dd(request()->all()) --}}

    @if($property)
    <div class="mb-3">
        {{-- @dd($property->id) --}}
        <label for="property_id" class="form-label fw-bold">Property</label>

        <input type="hidden" name="property_id" value="{{ $property->id }}">

        <input type="text" class="form-control" value="{{ $property->title }}" readonly>
    </div>
@else
    <p class="text-danger">No properties available.</p>
@endif

            <div class="mb-3">
    <label for="landlord_id" class="form-label fw-bold">Landlord</label>
    <input type="hidden" name="landlord_id" value="{{ auth()->user()->id }}">
    <input type="text" class="form-control" value="{{ auth()->user()->fullname }}" readonly>
</div>

        <div class="mb-3">
            <label for="tenant_id" class="form-label fw-bold">Tenant</label>
            <select name="tenant_id" id="tenant_id" class="form-control" required>
                <option value="">Select Tenant</option>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}">{{ $tenant->fullname }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label fw-bold">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label fw-bold">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="total_amount" class="form-label fw-bold">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" required step="0.01">
        </div>

        <div class="mb-3">
            <label for="insurance_amount" class="form-label fw-bold">Insurance Amount</label>
            <input type="number" name="insurance_amount" id="insurance_amount" class="form-control" required step="0.01">
        </div>

        <div class="form-group">
    <label class="fw-bold">Penalty Amount</label>
    <div class="d-flex">
        @if(auth()->user()->isSuperAdmin())
            <input type="radio" id="penalty_yes" name="penalty_amount" value="yes" class="btn-check">
            <label for="penalty_yes" class="btn btn-success">Yes</label>
        @else
            <label class="btn btn-secondary disabled">Yes (Admin Only)</label>
        @endif

        <input type="radio" id="penalty_no" name="penalty_amount" value="no" class="btn-check" checked>
        <label for="penalty_no" class="btn btn-danger">No</label>
    </div>
</div>



        <div class="mb-3">
            <label for="contract_image" class="form-label fw-bold">Contract Image</label>
            <input type="file" name="contract_image" id="contract_image" class="form-control">
            @error('contract_image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-center gap-3 mt-4 mb-3">

            {{-- @dd($property->id); --}}

<a href="{{ route('properties.show', $property->id) }}" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-primary">Create Contract</button>
        </div>

    </form>
    </div>
</div>
@endsection

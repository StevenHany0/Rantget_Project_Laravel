@extends('layout.master')

@section('content')
<div class="container mt-5">
<h1 class="text-center"> {{ $contract->tenant->fullname }}</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Contract Information</h5>
            <hr>

            <p><strong>Property:</strong> {{ $contract->property->title }}</p>
            <p><strong>Landlord:</strong> {{ $contract->landlord->fullname }}</p>
            <p><strong>Start Date:</strong> {{ $contract->start_date }}</p>
            <p><strong>End Date:</strong> {{ $contract->end_date }}</p>
            <p><strong>Total Amount:</strong> {{ $contract->total_amount }} EGP</p>
            <p><strong>Insurance Amount:</strong> {{ $contract->insurance_amount }} EGP</p>
            <div class="mb-3">
                <strong>Contract Image:</strong> <br>
                <img src="{{ asset('storage/' . $contract->contract_image) }}" class="img-fluid" style="max-width: 300px;">
            </div>
            <p><strong>Penalty Amount:</strong> {{ $contract->penalty_amount }} EGP</p>

            <div class="mt-3">
                <a href="{{ route('landlord.contracts.edit', $contract->id) }}" class="btn btn-primary">Edit Contract</a>

                <form action="{{ route('landlord.contracts.destroy', $contract->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to terminate this contract?')">Terminate Contract</button>
                </form>
            </div>

            <div class="mt-4">
                <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Back </a>
            </div>
        </div>
    </div>
</div>
@endsection

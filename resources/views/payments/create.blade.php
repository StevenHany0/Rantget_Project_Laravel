@extends('layout.master')

@section('content')

<div class="container">

<br>
    <div class="card">
        <div class="card-body">
        <h5>Owner: {{ $contract->landlord->fullname ?? 'N/A' }}</h5> 
        <h5>Apartment: {{ $contract->property->title ?? 'N/A' }}</h5> 
        <h5>Owner Phone: {{ $contract->landlord->phone ?? 'N/A' }}</h5>
        <h5>Date: {{ now()->format('d-m-Y') }}</h5> 
            <h5>Amount: <strong>{{ number_format($contract->total_amount / 12, 2) }} EGP</strong></h5>
        </div>
    </div>

    <form action="{{ route('payments.store') }}" method="POST">
    @csrf

    <input type="hidden" name="contract_id" value="{{ $contract->id }}">
    <input type="hidden" name="month" value="{{ $month }}">
    <input type="hidden" name="year" value="{{ $year }}">

    <div class="mb-3">
        <label class="form-label">Card Number</label>
        <input type="text" name="card_number" class="form-control" placeholder="1234 5678 9012 3456" value="{{ old('card_number') }}" required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Expiry Date (MM/YY)</label>
            <input type="text" name="expiry_date" class="form-control" placeholder="12/24" value="{{ old('expiry_date') }}" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">CVV</label>
            <input type="text" name="cvv" class="form-control" placeholder="123" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Amount</label>
        <input type="text" name="amount" class="form-control" value="{{ $contract->total_amount / 12 }}" readonly>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <button type="submit" class="btn btn-success">Pay Now 💳</button>
</form>

</div>

@endsection

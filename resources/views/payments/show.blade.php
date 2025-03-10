@extends('layout.master')

@section('content')
<div class="container">
    <h2>Payment Details</h2>
    <div class="card">
        <div class="card-body">
            <h4>Contract ID: {{ $payment->contract->id }}</h4>
            <h5>Amount: <strong>${{ $payment->amount }}</strong></h5>
            <h5>Payment Date: {{ $payment->payment_date }}</h5>
        </div>
    </div>
    <a href="{{ route('payments.index') }}" class="btn btn-primary">Back to Payments</a>
</div>
@endsection

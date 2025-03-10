  {{-- @extends('layouts.master')

@section('content')

<div class="container">
    <h2>دفع الإيجار لـ {{ $contract->property->name }}</h2>
    <a href="{{ route('contracts.index') }}" class="btn btn-secondary">الرجوع</a>

    <div class="calendar">
        @foreach ($months as $key => $month)
            <a href="{{ route('payments.details', [$contract->id, $key]) }}"
                class="month-box {{ $month['status'] }}">
                {{ $month['month'] }}
            </a>
        @endforeach
    </div>
</div>

<style>
    .calendar { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 20px; }
    .month-box { padding: 10px; text-align: center; border-radius: 5px; text-decoration: none; font-weight: bold; }
    .paid { background-color: green; color: white; }
    .late { background-color: red; color: white; }
    .unpaid { background-color: gray; color: white; }
    .pending { background-color: orange; color: white; }
</style>
@endsection --}}

@extends('layout.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Payments Received</h2>

    @foreach ($payments as $payment)
        <div class="card mb-3">
            <div class="card-body">
                <h5>Tenant: {{ $payment->contract->tenant->name }}</h5>
                <h5>Property: {{ $payment->contract->property->name }}</h5>
                <h5>Amount: <strong>${{ $payment->amount }}</strong></h5>
                <p>Status: <span class="badge bg-{{ $payment->status == 'pending' ? 'warning' : ($payment->status == 'paid' ? 'success' : 'secondary') }}">
                    {{ ucfirst($payment->status) }}
                </span></p>

                @if ($payment->status == 'pending')
                    <form action="{{ route('payments.update-status', $payment->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="paid">
                        <button type="submit" class="btn btn-success">Approve Payment</button>
                    </form>

                    <form action="{{ route('payments.update-status', $payment->id) }}" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="btn btn-danger">Reject Payment</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection


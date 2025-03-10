{{--  
@extends('layout.master')

@section('title', 'edit Payment')

@section('content')

    <div class="container mt-4">
        <h2>Edit Payment</h2>
        <form action="{{ route('payments.update', $payment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="contract_id" class="form-label">Contract</label>
                <select name="contract_id" id="contract_id" class="form-control">
                    @foreach($contracts as $contract)
                        <option value="{{ $contract->id }}" {{ $payment->contract_id == $contract->id ? 'selected' : '' }}>
                            Contract #{{ $contract->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" value="{{ $payment->amount }}" required>
            </div>

            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control">
                    <option value="Bank" {{ $payment->payment_method == 'Bank' ? 'selected' : '' }}>Bank</option>
                    <option value="Card" {{ $payment->payment_method == 'Card' ? 'selected' : '' }}>Card</option>
                </select>
            </div>

            <div class="mb-3" id="card_number_field" style="display: {{ $payment->payment_method == 'Card' ? 'block' : 'none' }}">
                <label for="card_number" class="form-label">Card Number</label>
                <input type="text" name="card_number" id="card_number" class="form-control" value="{{ $payment->card_number }}">
            </div>

            <div class="mb-3">
                <label for="payment_date" class="form-label">Payment Date</label>
                <input type="date" name="payment_date" id="payment_date" class="form-control" value="{{ $payment->payment_date }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="Completed" {{ $payment->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ $payment->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="Failed" {{ $payment->status == 'Failed' ? 'selected' : '' }}>Failed</option>
                    <option value="Pending" {{ $payment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Late" {{ $payment->status == 'Late' ? 'selected' : '' }}>Late</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update Payment</button>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        document.getElementById('payment_method').addEventListener('change', function () {
            var cardField = document.getElementById('card_number_field');
            if (this.value === 'Card') {
                cardField.style.display = 'block';
            } else {
                cardField.style.display = 'none';
            }
        });
    </script>
@endsection
--}}
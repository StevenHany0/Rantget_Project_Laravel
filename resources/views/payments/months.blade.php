@extends('layout.master')

@section('content')
<div class="container">

    <div class="d-grid gap-2 grid-template-columns">
        @foreach ($months as $month)
            <div class="month-box {{ $month['status'] }}">
                <span>{{ $month['name'] }}</span>
                @if ($month['status'] == 'paid')
                    <span class="badge bg-success">✅</span>
                @elseif ($month['status'] == 'late')
                    <span class="badge bg-danger">🔴</span>
                @else
                    <span class="badge bg-secondary">⚪</span>
                @endif
                @if ($month['status'] != 'paid')
                    <a href="{{ route('payments.create', ['contractId' => $contract->id, 'month' => $month['number'], 'year' => $month['year']]) }}"
                       class="btn btn-primary btn-sm mt-2">
                        Pay Now 💳
                    </a>
                @else
                    <button class="btn btn-light btn-sm mt-2" disabled>Paid</button>
                @endif
            </div>
        @endforeach
    </div>
    <a href="{{ route('dashboard.renter') }}" class="btn btn-secondary mt-3">Back</a>

</div>

<style>
    .d-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        padding: 10px;
    }
    .month-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 15px;
        border-radius: 5px;
        color: white;
        font-size: 18px;
        font-weight: bold;
    }
    .paid { background-color: #4CAF50; } /* أخضر */
    .late { background-color: #FF3D00; } /* أحمر */
    .unpaid { background-color: #757575; } /* رمادي */
</style>

@endsection

@extends('layout.master')

@section('content')
<div class="container">

    <div class="d-grid gap-2 grid-template-columns">
        @foreach ($months as $month)
            <div class="month-box {{ $month['status'] }}">
                <span>{{ $month['name'] }}</span>

                {{-- عرض الحالة --}}
                @if ($month['status'] == 'paid')
                    <span class="badge bg-success">✅ مدفوع</span>
                @elseif ($month['status'] == 'late')
                    <span class="badge bg-danger">🔴 متأخر</span>
                @else
                    <span class="badge bg-secondary">⚪ غير مدفوع</span>
                @endif

                {{-- زر الدفع يظهر فقط للمستأجر --}}
                @if (auth()->user()->role === 'tenant')
                    @if ($month['status'] != 'paid')
                        <a href="{{ route('landlord.payments.create', ['contractId' => $contract->id, 'month' => $month['number'], 'year' => $month['year']]) }}"
                           class="btn btn-primary btn-sm mt-2">
                            Pay Now 💳
                        </a>
                    @else
                        <button class="btn btn-light btn-sm mt-2" disabled>Paid</button>
                    @endif
                @endif
            </div>
        @endforeach
    </div>

    <a href="{{ route('renter.dashboard') }}" class="btn btn-secondary mt-3">Back</a>

</div>

<style>
    .d-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
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
        border-radius: 8px;
        color: white;
        font-size: 18px;
        font-weight: bold;
        min-height: 140px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    .paid { background-color: #4CAF50; }
    .late { background-color: #FF3D00; }
    .unpaid { background-color: #757575; }
</style>
@endsection

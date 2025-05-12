@extends('layout.master')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Renters</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($contracts as $contract)
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm border-0 text-center" style="max-width: 220px; padding: 15px; border-radius: 12px;">
                    <a href="{{ route('landlord.contracts.show', $contract->id) }}" class="text-decoration-none text-dark">
                        <div class="card-body p-3">
                            <img src="{{ asset('storage/' . $contract->tenant->image) }}"
                                 alt="Tenant Image"
                                 class="rounded-circle mb-3 img-fluid shadow"
                                 style="width: 90px; height: 90px; object-fit: cover; border: 3px solid #ddd;">

                            <h6 class="card-title mb-1" style="font-size: 1.2rem; font-weight: bold; color: #333;">
                                {{ $contract->tenant->fullname }}
                            </h6>
                        </div>
                    </a>

                    <!-- زر عرض المدفوعات -->
                    <a href="{{ route('landlord.payments.months', ['contractId' => $contract->id]) }}"
                       class="btn btn-warning btn-sm mt-2">
                       <i class="fas fa-eye"></i> عرض المدفوعات
                    </a>

                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

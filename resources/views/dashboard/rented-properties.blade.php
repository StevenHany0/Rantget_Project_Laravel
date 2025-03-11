@extends('layout.master')

@section('content')

<div class="container mt-5">

    @if($rentedProperties->isEmpty())

        <p class="text-center">You have no rented properties.</p>
    @else
        @foreach($rentedProperties as $property)
            <h2 class="text-center mb-4">{{ $property->title }}</h2>

            <div class="card mb-3 shadow-sm" style="max-width: 400px; margin: auto;">
                <div class="card-body text-center">
                    <p class="card-text"><strong>Landlord:</strong>
                        @if (isset($contracts[$property->id]))
                            {{ $contracts[$property->id]->landlord->fullname }}
                        @else
                            Not Available
                        @endif
                    </p>

                    <p class="card-text"><strong>Description:</strong> {{ $property->description }}</p>
                    <p class="card-text"><strong>Price:</strong> {{ number_format($property->price, 2) }} EGP</p>
                    <p class="card-text"><strong>Status:</strong> {{ $property->status ?? 'Not Available' }}</p>

                    <div class="p-2">
                        <img src="{{ asset('storage/' . $property->image) }}"
                             class="img-fluid rounded"
                             style="max-width: 80%; height: auto;"
                             alt="Property Image">
                    </div>

                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <a href="{{ route('dashboard.renter') }}" class="btn btn-secondary">Back</a>

                       @if (isset($contracts[$property->id]))
                            <a href="{{ route('payments.months', ['contractId' => $contracts[$property->id]->id]) }}"
                               class="btn btn-primary">
                                View Payment Status 💳
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

@endsection

@extends('layout.master')

@section('content')

<div class="container mt-5 d-flex flex-column align-items-center text-center">
    <h1>{{ $property->title }}</h1>

    <p style="font-weight: bold;"><strong>Description:</strong> {{ $property->description }}</p>
    <p style="font-weight: bold;"><strong>Location:</strong> {{ $property->location }}</p>
    <p style="font-weight: bold;"><strong>Price:</strong> ${{ number_format($property->price, 2) }}</p>
    <p style="font-weight: bold;"><strong>Status:</strong> {{ ucfirst($property->status) }}</p>

    <h3>Property Image</h3>
    <div>
        @if($property->image)
            <img src="{{ asset('storage/' . $property->image) }}" alt="Property Image" class="img-fluid rounded mb-3">
        @else
            <img src="{{ asset('images/default-property.jpg') }}" alt="Default Property Image" class="img-fluid rounded mb-3">
            <p>No Image Available</p>
        @endif
    </div>

    <div class="d-flex gap-3 mt-3">
        <a href="{{ route('landlord.dashboard', ['id' => Auth::id()]) }}">
        @if($property->status != 'rent')
            <a href="{{ route('landlord.properties.edit', $property->id) }}" class="btn btn-warning">Edit</a>
        @else
            <button class="btn btn-warning" disabled>Edit</button>
        @endif

        @if($property->status === 'available')
        <a href="{{ route('landlord.contracts.create', ['property' => $property->id]) }}" class="btn btn-primary">
            إنشاء عقد لهذا العقار
        </a>
                @elseif($property->status == 'reserved')
            <button class="btn btn-warning" disabled>Reserved - Waiting Confirmation</button>
        @elseif($property->status == 'rent')
            <button class="btn btn-danger" disabled>Currently Rented</button>
        @elseif($property->status == 'unavailable')
            <button class="btn btn-secondary" disabled>Unavailable</button>
        @endif
    </div>

</div>

@endsection

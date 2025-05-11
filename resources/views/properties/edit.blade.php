@extends('layout.master')

@section('title', 'Edit Property')

@section('content')

<div class="container mt-5">
<h2 class="text-center">Edit Property</h2>
<div class="card shadow-lg p-4">

    <form action="{{ route('landlord.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="fw-bold">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $property->title }}" required>
        </div>

        <div class="form-group">
            <label for="description" class="fw-bold">Description</label>
            <textarea name="description" id="description" class="form-control" required>{{ $property->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="location" class="fw-bold">Location</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ $property->location }}" required>
        </div>

        <div class="form-group">
            <label for="price" class="fw-bold">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $property->price }}" required>
        </div>

        <div class="form-group">
            <label for="status" class="fw-bold">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="available" {{ $property->status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="reserved" {{ $property->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                <option value="unavailable" {{ $property->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                <option value="rent" {{ $property->status == 'rent' ? 'selected' : '' }}>For Rent</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image" class="fw-bold">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($property->image)
                <p class="fw-bold">Current Image: <img src="{{ asset('storage/' . $property->image) }}" alt="Current Image" class="img-fluid" style="max-width: 100px;"></p>
            @endif
        </div>
        <div class="d-flex gap-2 mt-3">
    <a href="{{ route('properties.show', $property->id) }}" class="btn btn-secondary">Back</a>
    <button type="submit" class="btn btn-primary">Update</button>
</div>
    </form>
</div>
</div>

</div>

@endsection
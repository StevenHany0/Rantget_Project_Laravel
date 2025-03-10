@extends('layout.master')

@section('title', 'Create Property')

@section('content')
<div class="container mt-5">
<h2 class="text-center mb-4">Add New Property</h2>

    <div class="card shadow-lg p-4">
        <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- تخزين معرف المستخدم بشكل مخفي -->
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

            <div class="form-group mb-3">
                <label for="title" class="fw-bold"><i class="fas fa-home"></i> Property Name:</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="description" class="fw-bold"><i class="fas fa-align-left"></i> Description:</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="image" class="fw-bold"><i class="fas fa-image"></i> Property Image:</label>
                <input type="file" name="image" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="location" class="fw-bold"><i class="fas fa-map-marker-alt"></i> Location:</label>
                <input type="text" name="location" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="price" class="fw-bold"><i class="fas fa-dollar-sign"></i> Price:</label>
                <input type="number" name="price" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="status" class="fw-bold"><i class="fas fa-info-circle"></i> Status:</label>
                <select name="status" class="form-control" required>
                    <option value="available">Available</option>
                    <option value="rent">Rent</option>
                    <option value="reserved">Reserved</option>
                    <option value="unavailable">Unavailable</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success w-100">
                <i class="fas fa-plus"></i> Add Property
            </button>
        </form>
    </div>
</div>
@endsection

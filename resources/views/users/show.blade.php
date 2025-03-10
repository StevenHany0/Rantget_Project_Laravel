@extends('layout.master')


@section('title', 'Show  User')

@section('content')
    <div class="container mt-5">
        <h1>User Details</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Back to Users Link -->
        <div class="mb-3">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
        </div>

        <!-- User Details Card -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User Information</h5>
                <hr>

                <!-- ID Identify -->
                <div class="mb-3">
                    <strong>ID Identify:</strong>
                    <p>{{ $user->id_identify }}</p>
                </div>

                <!-- Full Name -->
                <div class="mb-3">
                    <strong>Full Name:</strong>
                    <p>{{ $user->fullname }}</p>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <strong>Email:</strong>
                    <p>{{ $user->email }}</p>
                </div>

                <!-- Age -->
                <div class="mb-3">
                    <strong>Age:</strong>
                    <p>{{ $user->age }}</p>
                </div>

                <!-- Phone -->
                <div class="mb-3">
                    <strong>Phone:</strong>
                    <p>{{ $user->phone }}</p>
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <strong>Role:</strong>
                    <p>{{ ucfirst($user->role) }}</p>
                </div>

                <!-- ID Identify Image -->
                <div class="mb-3">
                    <strong>ID Identify Image:</strong>
                    <br>
                    <img  height="50" width="50"  src="{{ asset('storage/' . $user->id_identify_image) }}" alt="ID Identify Image" class="img-fluid" style="max-width: 300px;">
                </div>

                <!-- Profile Image -->
                <div class="mb-3">
                    <strong>Profile Image:</strong>
                    <br>
                    <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image" class="img-fluid" style="max-width: 300px;" height="50" width="50">
                </div>

                <!-- Created At -->
                <div class="mb-3">
                    <strong>Created At:</strong>
                    <p>{{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                </div>

                <!-- Updated At -->
                <div class="mb-3">
                    <strong>Updated At:</strong>
                    <p>{{ $user->updated_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

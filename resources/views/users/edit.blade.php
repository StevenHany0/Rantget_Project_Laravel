@extends('layout.master')

@section('title', 'Edit User')

@section('content')
    <div class="container mt-5">
        <h1>Edit User</h1>

        <!-- Form -->
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- ID Identify -->
            <div class="mb-3">
                <label for="id_identify" class="form-label">ID Identify</label>
                <input type="text" name="id_identify" id="id_identify" class="form-control" value="{{ $user->id_identify }}" required maxlength="14">
            </div>

            <!-- ID Identify Image -->
            <div class="mb-3">
                <label for="id_identify_image" class="form-label">ID Identify Image</label>
                <input type="file" name="id_identify_image" id="id_identify_image" class="form-control">
                <small>Current: {{ $user->id_identify_image }}</small>
            </div>

            <!-- Full Name -->
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" name="fullname" id="fullname" class="form-control" value="{{ $user->fullname }}" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
                <small>Leave blank to keep the current password.</small>
            </div>

            <!-- Age -->
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" name="age" id="age" class="form-control" value="{{ $user->age }}" required min="18">
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}" required maxlength="11">
            </div>

            <!-- Profile Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Profile Image</label>
                <input type="file" name="image" id="image" class="form-control">
                <small>Current: {{ $user->image }}</small>
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="tenant" {{ $user->role === 'tenant' ? 'selected' : '' }}>Tenant</option>
                    <option value="landlord" {{ $user->role === 'landlord' ? 'selected' : '' }}>Landlord</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
@endsection

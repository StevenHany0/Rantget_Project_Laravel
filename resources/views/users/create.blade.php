@extends('layout.master')

@section('title', 'Create User')

@section('content')
    <div class="container mt-5">
        <h1>Create User</h1>

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

        <!-- Form -->
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- ID Identify -->
            <div class="mb-3">
                <label for="id_identify" class="form-label">ID Identify</label>
                <input type="text" name="id_identify" id="id_identify" class="form-control" required maxlength="14" value="{{ old('id_identify') }}">
                @error('id_identify')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="id_identify_image" class="form-label">ID Identify Image</label>
                <input type="file" name="id_identify_image" id="id_identify_image" class="form-control" required>
                @error('id_identify_image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Full Name -->
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" name="fullname" id="fullname" class="form-control" required value="{{ old('fullname') }}">
                @error('fullname')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required minlength="8">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" name="age" id="age" class="form-control" required min="18" value="{{ old('age') }}">
                @error('age')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" required maxlength="11" value="{{ old('phone') }}">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control" required>
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="tenant" {{ old('role') === 'tenant' ? 'selected' : '' }}>Tenant</option>
                    <option value="landlord" {{ old('role') === 'landlord' ? 'selected' : '' }}>Landlord</option>
                </select>
                @error('role')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary">Create User</button>
        </form>
    </div>
@endsection

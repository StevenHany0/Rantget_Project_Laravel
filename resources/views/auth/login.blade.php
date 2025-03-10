@extends('layout.master')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">Login</h2>

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <!-- Register Link -->
        <div class="text-center mt-3 fw-bold">
            <p>Don't have an account?</p>
            <a href="{{ route('register') }}" class="btn btn-outline-secondary w-100 fw-bold">Register</a>
        </div>
    </div>
</div>
@endsection
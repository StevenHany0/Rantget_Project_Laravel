@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Admin Dashboard</h2>

    @if(auth()->check())
        <p>Welcome, {{ auth()->user()->fullname }}!</p>
    @else
        <p>You are not logged in.</p>
    @endif

    <ul>
        <li><a href="{{ route('admin.users') }}">Manage Users</a></li>
    </ul>
</div>
@endsection

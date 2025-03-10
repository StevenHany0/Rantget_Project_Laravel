@extends('layout.master')

@section('title', 'Users List')

@section('content')

    <div class="container mt-5">
        <h1>All Users</h1>


        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Create User Button -->
        <div class="mb-3">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Create New User</a>
        </div>

        <!-- Users Table -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>ID Identify</th>
                    <th>ID Identify Image</th>
                    <th>Profile Image</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->age }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->id_identify }}</td>
                        <td>
                            @if($user->id_identify_image)
                                <img src="{{ asset('storage/' . $user->id_identify_image) }}" alt="ID Identify Image" class="img-fluid" style="max-width: 100px;">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            @if($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image" class="img-fluid" style="max-width: 100px;">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

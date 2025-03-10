<!-- @dd($users);
@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Manage Users</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->fullname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                <td>
                    <form action="{{ route('admin.updateRole', $user->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <label>
                            <input type="checkbox" name="is_admin" {{ $user->is_admin ? 'checked' : '' }} onchange="this.form.submit()">
                            Make Admin
                        </label>
                    </form>

                    <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection -->

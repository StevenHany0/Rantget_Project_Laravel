@extends('layout.master')
@section('my-body')
<form class="form-container" action="/auth/register" method="post">
    @csrf
    <fieldset>
        <legend>Register..</legend>
        <br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{old('name')}}">
        @error('name')
            <div style="color: red;">{{ $message }}</div>
        @enderror

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">{{old('email')}}</input>
        @error('email')
            <div style="color: red;">{{ $message }}</div>
        @enderror

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        @error('password')
            <div style="color: red;">{{ $message }}</div>
        @enderror

        <button class="btn btn-success">Sign Up</button>
    </fieldset>
</form>
@endsection
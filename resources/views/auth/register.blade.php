@extends('layouts.app')

@section('content')

<div class="container">
    <div class="login-form">
        <div class="main-div">
            <div class="panel">
                <h3>Register</h3>
            </div>
            <form action="{{ Route('register.submit') }}" method="post">
                @csrf
                <div class="form-group mt-3">
                    <label for="name">Username</label>
                    <input type="text" name="name" placeholder="Enter username" value="{{ old('name') }}" class="form-control">
                    @error('name')
                        <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Enter email address" value="{{ old('email') }}" class="form-control">
                    @error('email')
                        <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Enter password" value="{{ old('password') }}" class="form-control">
                    @error('password')
                        <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="re-enter password" value="{{ old('password_confirmation') }}" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary mt-3">Register</button>
            </form>
        </div>
    </div>
</div>

@endsection
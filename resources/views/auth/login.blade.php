@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Login</h3>
    @if (session()->has('status'))
        <h4 class="text-danger">{{ session('status') }}</h4>
    @endif

    <form action="{{ Route('login.submit') }}" method="post">
        @csrf

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

        <button type="submit" class="btn btn-primary mt-3">Login</button>
        
    </form>
</div>

@endsection
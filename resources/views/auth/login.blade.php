@extends('layouts.guest')

@section('title', 'Login')

@section('header')
    <h2>Welcome Back</h2>
    <p>Sign in to your active fitness account</p>
@endsection

@section('content')
    <form action="{{ route('login') }}" method="POST" id="login-form">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" name="remember" id="remember" style="cursor: pointer;">
            <label for="remember" class="form-label" style="margin-bottom: 0; cursor: pointer; user-select: none;">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary btn-block" id="login-submit">Sign In</button>
    </form>

    <div class="auth-footer">
        Don't have an account? <a href="{{ route('register') }}" id="link-register">Create Account</a>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Log In')
@section('description', 'Log in to your Lookalike Studio account.')

@section('content')
    <section class="page-hero">
        <div class="container">
            <span class="eyebrow">Welcome Back</span>
            <h1>Log In to Your Account</h1>
            <p class="lead">Enter your credentials to access your dashboard.</p>
        </div>
    </section>

    <section class="section">
        <div class="container auth-wrap">
            <div class="contact-form-card auth-card">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="contact-form">
                    @csrf

                    <div class="form-row">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        @error('password') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row form-row-inline">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember">
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Log In</button>
                </form>

                <p class="auth-switch">Don't have an account? <a href="{{ route('register') }}">Create one</a></p>
            </div>
        </div>
    </section>
@endsection

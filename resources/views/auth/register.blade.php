@extends('layouts.app')

@section('title', 'Register')
@section('description', 'Create a Lookalike Studio account to start your project.')

@section('content')
    <section class="page-hero">
        <div class="container">
            <span class="eyebrow">Create Account</span>
            <h1>Join Lookalike Studio</h1>
            <p class="lead">Create an account to track your project and get in touch faster.</p>
        </div>
    </section>

    <section class="section">
        <div class="container auth-wrap">
            <div class="contact-form-card auth-card">
                @if ($errors->any() && ! $errors->has('email'))
                    <div class="alert alert-error">Please fix the errors below and try again.</div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="contact-form">
                    @csrf

                    <div class="form-row">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        @error('password') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                </form>

                <p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
            </div>
        </div>
    </section>
@endsection

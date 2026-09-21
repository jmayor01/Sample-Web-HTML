@extends('layouts.app')

@section('title', 'Dashboard')
@section('description', 'Your Lookalike Studio account dashboard.')

@section('content')
    <section class="page-hero">
        <div class="container">
            <span class="eyebrow">Your Account</span>
            <h1>Welcome, {{ $user->name }}</h1>
            <p class="lead">You're logged in as {{ $user->email }}.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="contact-form-card">
                <h2>Account Details</h2>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Member since:</strong> {{ $user->created_at->format('F j, Y') }}</p>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline">Log Out</button>
                </form>
            </div>
        </div>
    </section>
@endsection

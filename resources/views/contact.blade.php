@extends('layouts.app')

@section('title', 'Contact')
@section('description', 'Get in touch with Lookalike Studio to start your branding, website, or marketing project.')

@section('content')
    <section class="page-hero">
        <div class="container">
            <span class="eyebrow">Contact</span>
            <h1>Let's talk about your project</h1>
            <p class="lead">Fill out the form below or reach us directly — we typically reply within one business day.</p>
        </div>
    </section>

    <section class="section">
        <div class="container two-col contact-wrap">
            <div class="contact-info">
                <h2>Get in Touch</h2>
                <div class="info-item">
                    <h4>Email</h4>
                    <a href="mailto:hello@lookalikestudio.test">hello@lookalikestudio.test</a>
                </div>
                <div class="info-item">
                    <h4>Phone</h4>
                    <a href="tel:+15555550123">+1 (555) 555-0123</a>
                </div>
                <div class="info-item">
                    <h4>Studio Address</h4>
                    <p>123 Market Street, Suite 400<br>San Francisco, CA 94103</p>
                </div>
                <div class="info-item">
                    <h4>Hours</h4>
                    <p>Monday - Friday, 9am - 5pm PT</p>
                </div>
            </div>

            <div class="contact-form-card">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('contact.submit') }}" class="contact-form">
                    @csrf

                    <div class="form-row">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required>
                        @error('subject') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                        @error('message') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                </form>
            </div>
        </div>
    </section>
@endsection

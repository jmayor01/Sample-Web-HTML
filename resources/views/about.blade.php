@extends('layouts.app')

@section('title', 'About')
@section('description', 'Learn about Lookalike Studio, our story, our mission, and the team behind the brands we build.')

@section('content')
    <section class="page-hero">
        <div class="container">
            <span class="eyebrow">About Us</span>
            <h1>We started Lookalike Studio to fix a simple problem</h1>
            <p class="lead">Too many small businesses have a great product but a brand that doesn't match it — different logos on the sign, the website, and the invoices. We help businesses look as good as they really are.</p>
        </div>
    </section>

    <section class="section">
        <div class="container two-col">
            <div>
                <h2>Our Story</h2>
                <p>Lookalike Studio was founded in 2018 by a small team of designers and developers who kept seeing the same thing: businesses investing in great products and service, then losing customers' trust with an inconsistent, dated, or DIY brand presence.</p>
                <p>Since then, we've partnered with over 120 businesses — from neighborhood cafés to regional service companies — to build brand identities and websites that finally look "like them" everywhere customers find them.</p>
            </div>
            <div>
                <h2>Our Mission</h2>
                <p>To give every growing business a professional, consistent, and memorable presence — without the agency price tag or the months-long timelines.</p>
                <p>We believe a strong brand isn't a luxury. It's how customers decide, in seconds, whether to trust you.</p>
            </div>
        </div>
    </section>

    <section class="section alt">
        <div class="container">
            <div class="section-heading">
                <span class="eyebrow">Our Values</span>
                <h2>What guides our work</h2>
            </div>
            <div class="grid grid-3">
                <div class="value-card">
                    <h3>Craft</h3>
                    <p>We sweat the details, from kerning to color contrast, because small things add up to trust.</p>
                </div>
                <div class="value-card">
                    <h3>Clarity</h3>
                    <p>No jargon, no surprises. You'll always know where your project stands and what's next.</p>
                </div>
                <div class="value-card">
                    <h3>Partnership</h3>
                    <p>We treat every project like our own business is on the line, because your success is ours too.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-heading">
                <span class="eyebrow">Our Team</span>
                <h2>The people behind the pixels</h2>
            </div>
            <div class="grid grid-3">
                <div class="team-card">
                    <div class="avatar">AM</div>
                    <h3>Alex Morgan</h3>
                    <p class="muted">Founder &amp; Creative Director</p>
                </div>
                <div class="team-card">
                    <div class="avatar">JP</div>
                    <h3>Jordan Park</h3>
                    <p class="muted">Lead Web Developer</p>
                </div>
                <div class="team-card">
                    <div class="avatar">SR</div>
                    <h3>Sam Rivera</h3>
                    <p class="muted">Brand Strategist</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-band">
        <div class="container cta-wrap">
            <div>
                <h2>Let's build something that looks like you.</h2>
                <p>We'd love to hear about your business and what you're working on.</p>
            </div>
            <a href="{{ route('contact') }}" class="btn btn-light">Contact Us</a>
        </div>
    </section>
@endsection

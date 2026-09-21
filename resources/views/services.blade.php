@extends('layouts.app')

@section('title', 'Services')
@section('description', 'Explore Lookalike Studio\'s branding, web design, and marketing collateral services and pricing packages.')

@section('content')
    <section class="page-hero">
        <div class="container">
            <span class="eyebrow">Services</span>
            <h1>Everything you need to look, feel, and sound consistent</h1>
            <p class="lead">Pick a single service or bundle them together into a complete brand refresh.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="grid grid-3">
                <div class="service-card">
                    <div class="feature-icon">🎨</div>
                    <h3>Brand Identity</h3>
                    <p>Logo design, color palette, typography, and a brand style guide your whole team can follow.</p>
                    <ul class="check-list">
                        <li>Logo &amp; icon design</li>
                        <li>Color &amp; type system</li>
                        <li>Brand guidelines document</li>
                    </ul>
                </div>
                <div class="service-card featured">
                    <span class="badge">Most Popular</span>
                    <div class="feature-icon">💻</div>
                    <h3>Website Design</h3>
                    <p>A responsive, fast-loading brochure or e-commerce website built on your new brand identity.</p>
                    <ul class="check-list">
                        <li>Up to 6 custom pages</li>
                        <li>Mobile &amp; tablet optimized</li>
                        <li>Contact &amp; lead forms</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="feature-icon">📣</div>
                    <h3>Marketing Collateral</h3>
                    <p>Print and digital materials that carry your brand into the real world and social feeds.</p>
                    <ul class="check-list">
                        <li>Business cards &amp; signage</li>
                        <li>Brochures &amp; flyers</li>
                        <li>Social media templates</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section alt">
        <div class="container">
            <div class="section-heading">
                <span class="eyebrow">Packages</span>
                <h2>Simple, transparent pricing</h2>
            </div>
            <div class="grid grid-3">
                <div class="price-card">
                    <h3>Starter</h3>
                    <p class="price">$1,200</p>
                    <p class="muted">Perfect for a fresh logo and basic brand kit.</p>
                    <ul class="check-list">
                        <li>Logo design (2 concepts)</li>
                        <li>Color &amp; font palette</li>
                        <li>Business card design</li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn btn-outline btn-block">Get Started</a>
                </div>
                <div class="price-card featured">
                    <span class="badge">Best Value</span>
                    <h3>Growth</h3>
                    <p class="price">$3,500</p>
                    <p class="muted">Full brand identity plus a custom website.</p>
                    <ul class="check-list">
                        <li>Everything in Starter</li>
                        <li>5-page responsive website</li>
                        <li>Brand guidelines document</li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn btn-primary btn-block">Get Started</a>
                </div>
                <div class="price-card">
                    <h3>Complete</h3>
                    <p class="price">$6,900</p>
                    <p class="muted">A full brand system across every channel.</p>
                    <ul class="check-list">
                        <li>Everything in Growth</li>
                        <li>Marketing collateral suite</li>
                        <li>3 months of design support</li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn btn-outline btn-block">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-band">
        <div class="container cta-wrap">
            <div>
                <h2>Not sure which package fits?</h2>
                <p>Tell us about your business and we'll recommend the right starting point.</p>
            </div>
            <a href="{{ route('contact') }}" class="btn btn-light">Talk to Us</a>
        </div>
    </section>
@endsection

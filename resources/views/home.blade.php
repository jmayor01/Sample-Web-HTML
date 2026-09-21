@extends('layouts.app')

@section('title', 'Home')
@section('description', 'Lookalike Studio helps growing businesses build a consistent, memorable brand across every touchpoint.')

@section('content')
    <section class="hero">
        <div class="container hero-wrap">
            <div class="hero-copy">
                <span class="eyebrow">Branding &amp; Design Studio</span>
                <h1>A brand your customers will always recognize.</h1>
                <p class="lead">Lookalike Studio partners with small and growing businesses to craft cohesive brand identities, websites, and marketing materials — so every touchpoint looks and feels unmistakably you.</p>
                <div class="hero-actions">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Start a Project</a>
                    <a href="{{ route('services') }}" class="btn btn-outline">View Services</a>
                </div>
            </div>
            <div class="hero-art" data-parallax aria-hidden="true">
                <div class="hero-card card-1" data-parallax-item data-depth="26">Brand Identity</div>
                <div class="hero-card card-2" data-parallax-item data-depth="46">Web Design</div>
                <div class="hero-card card-3" data-parallax-item data-depth="34">Marketing Collateral</div>
            </div>
        </div>
    </section>

    <script>
        (function () {
            var field = document.querySelector('[data-parallax]');
            if (!field) return;

            var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var hasFinePointer = window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches;
            if (reduceMotion || !hasFinePointer) return;

            var items = Array.prototype.slice.call(field.querySelectorAll('[data-parallax-item]')).map(function (el) {
                return { el: el, depth: parseFloat(el.getAttribute('data-depth')) || 20, x: 0, y: 0, tx: 0, ty: 0 };
            });

            var targetX = 0;
            var targetY = 0;
            var raf = null;

            function onPointerMove(e) {
                var rect = field.getBoundingClientRect();
                // Normalized pointer position relative to the field's center, -0.5..0.5
                targetX = ((e.clientX - rect.left) / rect.width) - 0.5;
                targetY = ((e.clientY - rect.top) / rect.height) - 0.5;
                items.forEach(function (item) {
                    item.tx = targetX * item.depth;
                    item.ty = targetY * item.depth;
                });
                if (!raf) raf = requestAnimationFrame(tick);
            }

            function onPointerLeave() {
                targetX = 0;
                targetY = 0;
                items.forEach(function (item) {
                    item.tx = 0;
                    item.ty = 0;
                });
                if (!raf) raf = requestAnimationFrame(tick);
            }

            // Ease each card's position toward its target so movement feels fluid,
            // not a 1:1 jump to the cursor, and each card settles at its own rate.
            function tick() {
                var stillMoving = false;

                items.forEach(function (item) {
                    var dx = item.tx - item.x;
                    var dy = item.ty - item.y;
                    item.x += dx * 0.08;
                    item.y += dy * 0.08;
                    item.el.style.transform = 'translate3d(' + item.x.toFixed(2) + 'px, ' + item.y.toFixed(2) + 'px, 0)';
                    if (Math.abs(dx) > 0.05 || Math.abs(dy) > 0.05) stillMoving = true;
                });

                raf = stillMoving ? requestAnimationFrame(tick) : null;
            }

            field.addEventListener('pointermove', onPointerMove);
            field.addEventListener('pointerleave', onPointerLeave);
        })();
    </script>

    <section class="stats">
        <div class="container stats-grid">
            <div class="stat">
                <span class="stat-num">120+</span>
                <span class="stat-label">Brands launched</span>
            </div>
            <div class="stat">
                <span class="stat-num">8</span>
                <span class="stat-label">Years in business</span>
            </div>
            <div class="stat">
                <span class="stat-num">98%</span>
                <span class="stat-label">Client satisfaction</span>
            </div>
            <div class="stat">
                <span class="stat-num">15</span>
                <span class="stat-label">Industries served</span>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-heading">
                <span class="eyebrow">What We Do</span>
                <h2>Everything a growing business needs to look the part</h2>
            </div>
            <div class="grid grid-3">
                <div class="feature-card">
                    <div class="feature-icon">🎨</div>
                    <h3>Brand Identity</h3>
                    <p>Logo systems, color palettes, and style guides that keep your business consistent everywhere it shows up.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💻</div>
                    <h3>Web Design</h3>
                    <p>Clean, fast, mobile-friendly websites built to turn visitors into customers.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📣</div>
                    <h3>Marketing Materials</h3>
                    <p>Brochures, business cards, signage, and social templates that match your brand perfectly.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section alt">
        <div class="container">
            <div class="section-heading">
                <span class="eyebrow">Why Lookalike</span>
                <h2>We make your business unmistakable</h2>
            </div>
            <div class="grid grid-3">
                <div class="value-card">
                    <h3>Consistency</h3>
                    <p>One design system across print, web, and social — no more mismatched logos or colors.</p>
                </div>
                <div class="value-card">
                    <h3>Speed</h3>
                    <p>Most brand and website projects launch within 4-6 weeks from kickoff.</p>
                </div>
                <div class="value-card">
                    <h3>Affordability</h3>
                    <p>Flexible packages built for small businesses, not just big-budget brands.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-band">
        <div class="container cta-wrap">
            <div>
                <h2>Ready to give your business a look people remember?</h2>
                <p>Tell us about your project and we'll get back to you within one business day.</p>
            </div>
            <a href="{{ route('contact') }}" class="btn btn-light">Get in Touch</a>
        </div>
    </section>
@endsection

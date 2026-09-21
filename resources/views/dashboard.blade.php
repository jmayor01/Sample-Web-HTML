@extends('layouts.app')

@section('title', 'Dashboard')
@section('description', 'Your Lookalike Studio account dashboard.')

@php
    $values = array_column($analytics['series'], 'value');
    $maxVal = max($values);
    $minVal = min($values);
    $range = max(1, $maxVal - $minVal);

    // Fixed SVG coordinate space; JS reads the same numbers back off data-* attrs.
    $vbW = 640;
    $vbH = 220;
    $padLeft = 34;
    $padRight = 46;
    $plotTop = 18;
    $plotBottom = 168;
    $plotW = $vbW - $padLeft - $padRight;
    $count = count($values);
    $step = $count > 1 ? $plotW / ($count - 1) : 0;

    $toY = fn ($v) => $plotBottom - (($v - $minVal) / $range) * ($plotBottom - $plotTop);

    $points = [];
    foreach ($values as $i => $v) {
        $points[] = [round($padLeft + $i * $step, 2), round($toY($v), 2)];
    }

    $linePath = '';
    foreach ($points as $i => [$x, $y]) {
        $linePath .= ($i === 0 ? "M{$x} {$y}" : " L{$x} {$y}");
    }

    $areaPath = $linePath." L{$points[$count - 1][0]} {$plotBottom} L{$points[0][0]} {$plotBottom} Z";

    $gridSteps = [$minVal, ($minVal + $maxVal) / 2, $maxVal];

    // Evenly spaced x-axis labels (always includes first & last) so they never
    // crowd together the way a plain "every Nth point" pick can at the tail.
    $labelCount = min(5, $count);
    $labelIndices = [];
    for ($k = 0; $k < $labelCount; $k++) {
        $labelIndices[] = $labelCount > 1
            ? (int) round($k * ($count - 1) / ($labelCount - 1))
            : 0;
    }
    $labelIndices = array_unique($labelIndices);
@endphp

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

            <div class="section-heading">
                <span class="eyebrow">Live Analytics</span>
                <h2>Your account at a glance</h2>
            </div>

            <div class="analytics-panel">
                <div class="analytics-status">
                    <span class="status-dot" aria-hidden="true"></span>
                    <span>Live</span>
                    <span class="status-sep" aria-hidden="true">&middot;</span>
                    <span class="muted-dark">Synced just now</span>
                </div>

                <div class="analytics-kpis">
                    <div class="stat-tile-dark">
                        <span class="stat-tile-label">Days Active</span>
                        <span class="stat-tile-value" data-count-to="{{ $analytics['daysActive'] }}">0</span>
                    </div>

                    <div class="stat-tile-dark">
                        <span class="stat-tile-label">Profile Views</span>
                        <span class="stat-tile-value" data-count-to="{{ $analytics['profileViews'] }}">0</span>
                        <span class="stat-tile-delta {{ $analytics['profileViewsDelta'] >= 0 ? 'is-up' : 'is-down' }}">
                            {{ $analytics['profileViewsDelta'] >= 0 ? '▲' : '▼' }}
                            {{ number_format(abs($analytics['profileViewsDelta']), 1) }}%
                        </span>
                    </div>

                    <div class="stat-tile-dark">
                        <span class="stat-tile-label">Project Inquiries</span>
                        <span class="stat-tile-value" data-count-to="{{ $analytics['inquiries'] }}">0</span>
                        <span class="stat-tile-delta {{ $analytics['inquiriesDelta'] >= 0 ? 'is-up' : 'is-down' }}">
                            {{ $analytics['inquiriesDelta'] >= 0 ? '▲' : '▼' }}
                            {{ number_format(abs($analytics['inquiriesDelta']), 1) }}%
                        </span>
                    </div>

                    <div class="stat-tile-dark">
                        <span class="stat-tile-label">Response Rate</span>
                        <span class="stat-tile-value" data-count-to="{{ $analytics['responseRate'] }}" data-suffix="%">0</span>
                    </div>
                </div>

                <div class="analytics-grid">
                    <figure class="chart-card">
                        <div class="chart-card-header">
                            <div>
                                <h3>Profile Views</h3>
                                <p class="muted-dark">Last {{ $count }} days</p>
                            </div>
                            <button type="button" class="chart-toggle-btn" data-chart-table-toggle aria-expanded="false">
                                View as table
                            </button>
                        </div>

                        <div class="chart-wrap">
                            <svg
                                class="chart-svg"
                                viewBox="0 0 {{ $vbW }} {{ $vbH }}"
                                role="img"
                                aria-label="Profile views over the last {{ $count }} days, ranging from {{ $minVal }} to {{ $maxVal }}"
                                tabindex="0"
                                data-chart
                                data-pad-left="{{ $padLeft }}"
                                data-pad-right="{{ $padRight }}"
                                data-plot-top="{{ $plotTop }}"
                                data-plot-bottom="{{ $plotBottom }}"
                                data-vb-w="{{ $vbW }}"
                                data-vb-h="{{ $vbH }}"
                            >
                                @foreach ($gridSteps as $g)
                                    <line
                                        x1="{{ $padLeft }}" x2="{{ $vbW - $padRight }}"
                                        y1="{{ round($toY($g), 2) }}" y2="{{ round($toY($g), 2) }}"
                                        class="chart-gridline"
                                    />
                                    <text x="0" y="{{ round($toY($g), 2) + 4 }}" class="chart-tick">{{ round($g) }}</text>
                                @endforeach

                                @foreach ($points as $i => [$x, $y])
                                    @if (in_array($i, $labelIndices, true))
                                        <text x="{{ $x }}" y="{{ $vbH - 4 }}" class="chart-tick chart-tick-x">{{ $analytics['series'][$i]['label'] }}</text>
                                    @endif
                                @endforeach

                                <path d="{{ $areaPath }}" class="chart-area" />
                                <path d="{{ $linePath }}" class="chart-line" />

                                <circle
                                    cx="{{ $points[$count - 1][0] }}" cy="{{ $points[$count - 1][1] }}"
                                    r="4" class="chart-end-dot"
                                />
                                <text
                                    x="{{ $points[$count - 1][0] + 8 }}" y="{{ $points[$count - 1][1] + 4 }}"
                                    class="chart-end-label"
                                >{{ $values[$count - 1] }}</text>

                                <line class="chart-crosshair" x1="0" x2="0" y1="{{ $plotTop }}" y2="{{ $plotBottom }}" opacity="0" />
                                <circle class="chart-crosshair-dot" r="5" opacity="0" />
                            </svg>

                            <div class="chart-tooltip" data-chart-tooltip role="status" aria-live="polite"></div>
                        </div>

                        <table class="chart-table" data-chart-table>
                            <caption class="sr-only">Profile views by day</caption>
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($analytics['series'] as $point)
                                    <tr>
                                        <td>{{ $point['label'] }}</td>
                                        <td>{{ $point['value'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </figure>

                    <div class="meter-card">
                        <h3>Profile Completeness</h3>

                        <div class="meter-ring-wrap">
                            <svg viewBox="0 0 120 120" class="meter-ring" role="img" aria-label="Profile {{ $analytics['completeness'] }}% complete">
                                <circle cx="60" cy="60" r="50" class="meter-track" />
                                <circle
                                    cx="60" cy="60" r="50" class="meter-fill"
                                    data-meter-fill
                                    data-value="{{ $analytics['completeness'] }}"
                                />
                            </svg>
                            <span class="meter-value">{{ $analytics['completeness'] }}%</span>
                        </div>

                        <ul class="completeness-list">
                            @foreach ($analytics['completenessItems'] as $item)
                                <li class="{{ $item['done'] ? 'is-done' : 'is-pending' }}">
                                    <span aria-hidden="true">{{ $item['done'] ? '✓' : '○' }}</span>
                                    {{ $item['label'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="contact-form-card account-card">
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

    <script>
        (function () {
            var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // Count-up KPI values
            document.querySelectorAll('[data-count-to]').forEach(function (el) {
                var target = parseFloat(el.getAttribute('data-count-to')) || 0;
                var suffix = el.getAttribute('data-suffix') || '';

                if (reduceMotion) {
                    el.textContent = target + suffix;
                    return;
                }

                var start = null;
                var duration = 900;

                function step(ts) {
                    if (start === null) start = ts;
                    var progress = Math.min((ts - start) / duration, 1);
                    var eased = 1 - Math.pow(1 - progress, 3);
                    el.textContent = Math.round(eased * target) + suffix;
                    if (progress < 1) requestAnimationFrame(step);
                }

                requestAnimationFrame(step);
            });

            // Radial meter fill
            document.querySelectorAll('[data-meter-fill]').forEach(function (circle) {
                var value = parseFloat(circle.getAttribute('data-value')) || 0;
                var radius = circle.r.baseVal.value;
                var circumference = 2 * Math.PI * radius;
                circle.style.strokeDasharray = circumference;
                circle.style.strokeDashoffset = reduceMotion
                    ? circumference * (1 - value / 100)
                    : circumference;

                if (!reduceMotion) {
                    requestAnimationFrame(function () {
                        circle.style.transition = 'stroke-dashoffset 1s ease';
                        circle.style.strokeDashoffset = circumference * (1 - value / 100);
                    });
                }
            });

            // Line chart crosshair + tooltip
            var chart = document.querySelector('[data-chart]');
            if (chart) {
                var wrap = chart.closest('.chart-wrap');
                var tooltip = wrap.querySelector('[data-chart-tooltip]');
                var crosshair = chart.querySelector('.chart-crosshair');
                var dot = chart.querySelector('.chart-crosshair-dot');

                var series = @json($analytics['series']);
                var padLeft = parseFloat(chart.dataset.padLeft);
                var padRight = parseFloat(chart.dataset.padRight);
                var plotTop = parseFloat(chart.dataset.plotTop);
                var plotBottom = parseFloat(chart.dataset.plotBottom);
                var vbW = parseFloat(chart.dataset.vbW);
                var vbH = parseFloat(chart.dataset.vbH);
                var plotW = vbW - padLeft - padRight;
                var minVal = Math.min.apply(null, series.map(function (p) { return p.value; }));
                var maxVal = Math.max.apply(null, series.map(function (p) { return p.value; }));
                var range = Math.max(1, maxVal - minVal);
                var stepX = series.length > 1 ? plotW / (series.length - 1) : 0;

                function valueToY(v) {
                    return plotBottom - ((v - minVal) / range) * (plotBottom - plotTop);
                }

                function showForIndex(index) {
                    index = Math.max(0, Math.min(series.length - 1, index));
                    var point = series[index];
                    var x = padLeft + index * stepX;
                    var y = valueToY(point.value);

                    crosshair.setAttribute('x1', x);
                    crosshair.setAttribute('x2', x);
                    crosshair.setAttribute('opacity', 1);
                    dot.setAttribute('cx', x);
                    dot.setAttribute('cy', y);
                    dot.setAttribute('opacity', 1);

                    var rect = chart.getBoundingClientRect();
                    var pxX = (x / vbW) * rect.width;
                    var pxY = (y / vbH) * rect.height;

                    tooltip.style.opacity = 1;
                    tooltip.style.left = pxX + 'px';
                    tooltip.style.top = pxY + 'px';
                    tooltip.innerHTML = '<strong>' + point.value + '</strong><span>' + point.label + '</span>';
                }

                function hide() {
                    crosshair.setAttribute('opacity', 0);
                    dot.setAttribute('opacity', 0);
                    tooltip.style.opacity = 0;
                }

                chart.addEventListener('pointermove', function (e) {
                    var rect = chart.getBoundingClientRect();
                    var relX = ((e.clientX - rect.left) / rect.width) * vbW;
                    var index = Math.round((relX - padLeft) / (stepX || 1));
                    showForIndex(index);
                });

                chart.addEventListener('pointerleave', hide);

                chart.addEventListener('focus', function () {
                    showForIndex(series.length - 1);
                });

                chart.addEventListener('blur', hide);

                var focusedIndex = series.length - 1;
                chart.addEventListener('keydown', function (e) {
                    if (e.key === 'ArrowLeft') {
                        focusedIndex = Math.max(0, focusedIndex - 1);
                        showForIndex(focusedIndex);
                        e.preventDefault();
                    } else if (e.key === 'ArrowRight') {
                        focusedIndex = Math.min(series.length - 1, focusedIndex + 1);
                        showForIndex(focusedIndex);
                        e.preventDefault();
                    }
                });
            }

            // Table-view toggle
            var toggleBtn = document.querySelector('[data-chart-table-toggle]');
            var table = document.querySelector('[data-chart-table]');
            if (toggleBtn && table) {
                toggleBtn.addEventListener('click', function () {
                    var expanded = toggleBtn.getAttribute('aria-expanded') === 'true';
                    toggleBtn.setAttribute('aria-expanded', String(!expanded));
                    table.classList.toggle('is-visible', !expanded);
                    toggleBtn.textContent = expanded ? 'View as table' : 'Hide table';
                });
            }
        })();
    </script>
@endsection

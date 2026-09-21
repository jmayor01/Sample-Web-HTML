<header class="site-header">
    <div class="container nav-wrap">
        <a href="{{ route('home') }}" class="brand">
            <span class="brand-mark">L</span>
            <span class="brand-name">Lookalike Studio</span>
        </a>

        <input type="checkbox" id="nav-toggle" class="nav-toggle">
        <label for="nav-toggle" class="nav-toggle-label" aria-label="Toggle navigation">
            <span></span><span></span><span></span>
        </label>

        <nav class="site-nav">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">Services</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>

            @auth
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
                    @csrf
                    <button type="submit" class="nav-link-btn">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Log In</a>
                <a href="{{ route('register') }}" class="btn btn-primary nav-cta">Sign Up</a>
            @endauth
        </nav>
    </div>
</header>

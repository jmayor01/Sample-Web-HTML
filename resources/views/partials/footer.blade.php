<footer class="site-footer">
    <div class="container footer-wrap">
        <div class="footer-col">
            <div class="brand">
                <span class="brand-mark">L</span>
                <span class="brand-name">Lookalike Studio</span>
            </div>
            <p class="muted">Branding, design, and digital experiences for businesses that want to be remembered.</p>
        </div>

        <div class="footer-col">
            <h4>Explore</h4>
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('services') }}">Services</a>
            <a href="{{ route('contact') }}">Contact</a>
        </div>

        <div class="footer-col">
            <h4>Contact</h4>
            <a href="mailto:hello@lookalikestudio.test">hello@lookalikestudio.test</a>
            <a href="tel:+15555550123">+1 (555) 555-0123</a>
            <p class="muted">123 Market Street, Suite 400<br>San Francisco, CA 94103</p>
        </div>

        <div class="footer-col">
            <h4>Follow</h4>
            <a href="#">Instagram</a>
            <a href="#">LinkedIn</a>
            <a href="#">X (Twitter)</a>
        </div>
    </div>

    <div class="container footer-bottom">
        <p>&copy; {{ date('Y') }} Lookalike Studio. All rights reserved.</p>
    </div>
</footer>

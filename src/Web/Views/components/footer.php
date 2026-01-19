<style>
    .footer {
        background: #ebf0e8;
        color: #e2e8f0;
        padding: 3rem 0 1rem;
        margin-top: auto;
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .footer-section h1 {
        color: #111827;
    }

    .footer-section h4 {
        color: #25a36f;
        margin-bottom: 1rem;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .footer-section p {
        line-height: 1.6;
        color: #a0aec0;
        font-size: 0.9rem;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 0.5rem;
    }

    .footer-section ul li a {
        color: #77DD77;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.2s;
    }

    .footer-section ul li a:hover {
        color: #4299e1;
    }

    .footer-bottom {
        border-top: 1px solid #2d3748;
        padding-top: 1rem;
        text-align: center;
    }

    .footer-bottom p {
        color: #718096;
        font-size: 0.85rem;
        margin: 0.25rem 0;
    }

    @media (max-width: 768px) {
        .footer {
            padding: 2rem 0 1rem;
        }

        .footer-content {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }

</style>

<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h1>SUC -Industry Collaboration Forum</h1>
                <p>Connecting Philippine State Universities and Colleges with industry partners for innovation and collaboration</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/about">About</a></li>
                    <li><a href="/search">Search</a></li>
                    <li><a href="/documents">Resources</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Community</h4>
                <ul>
                    <li><a href="/job-board">Job Board</a></li>
                    <li><a href="/research-hub">Research Hub</a></li>
                    <li><a href="/academic-calendar">Events</a></li>
                    <li><a href="/university-groups">Groups</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Support</h4>
                <ul>
                    <li><a href="/help">Help Center</a></li>
                    <li><a href="/contact">Contact Us</a></li>
                    <li><a href="/privacy">Privacy Policy</a></li>
                    <li><a href="/terms">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 SUC - Industry Collaboration Forum. All rights reserved.</p>
            <p>Empowering education through collaboration</p>
        </div>
    </div>
</footer>
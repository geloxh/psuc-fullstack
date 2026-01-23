<style>
    .footer {
        background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
        color: #e2e8f0;
        padding: 3rem 0 1rem;
        margin-top: auto;
        border-top: 3px solid #4299e1;
        /* Match sidebar positioning */
        margin-left: min(max(280px, 20vw), 300px);
        width: calc(100% - min(max(280px, 20vw), 300px));
        transition: all 0.3s ease;
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
        max-width: 1200px;
        margin: 0 auto 2rem;
        padding: 0 1rem;
    }

    .footer-section h1 {
        color: #ffffff;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .footer-section h4 {
        color: #4299e1; /* Match sidebar accent color */
        margin-bottom: 1rem;
        font-size: 1.1rem;
        font-weight: 600;
        position: relative;
    }

    .footer-section h4::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 30px;
        height: 2px;
        background: #4299e1; /* Match sidebar accent */
    }

    .footer-section p {
        line-height: 1.6;
        color: #cbd5e0;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
   
    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 0.5rem;
    }

    .footer-section ul li a {
        color: #a0aec0;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .footer-section ul li a:hover {
        color: #4299e1; /* Match sidebar hover */
        transform: translateX(5px); /* Match sidebar hover effect */
    }

    .footer-bottom {
        border-top: 1px solid #4a5568;
        padding-top: 1.5rem;
        text-align: center;
        max-width: 1200px;
        margin: 0 auto;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .footer-bottom p {
        color: #a0aec0;
        font-size: 0.85rem;
        margin: 0.25rem 0;
    }

    .social-links {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
    }

    .social-links a {
        color: #a0aec0;
        font-size: 1.2rem;
        transition: color 0.3s ease;
    }

    .social-links a:hover {
        color: #4299e1; /* Match sidebar accent */
    }

    @media (max-width: 768px) {
        .footer {
            padding: 2rem 0 1rem;
            margin-left: 0;
            width: 100%;
        }

        .footer-content {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .footer-section h1 {
            font-size: 1.3rem;
        }
    }
</style>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h1>SUC Forum</h1>
            <p>Connecting Philippine State Universities and Colleges with industry partners for innovation and collaboration</p>
        </div>
        <div class="footer-section">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="/suc-fullstack/public/">Home</a></li>
                <li><a href="/suc-fullstack/about">About</a></li>
                <li><a href="/suc-fullstack/search">Search</a></li>
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
        <div class="social-links">
            <a href="#" title="Facebook">icon</a>
            <a href="#" title="Instagram">icon</a>
            <a href="#" title="Email">icon</a>
            <a href="#" title="Youtube">icon</a>
        </div>
        <p>&copy; <?php echo date('Y'); ?> SUC Forum. All rights reserved.</p>
        <p>Empowering education through collaboration</p>
    </div>
</footer>

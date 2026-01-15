<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../../../db/database.php';
require_once __DIR__ . '/../../../Modules/Auth/Services/AuthService.php';

$database = new Database();
$authService = new \App\Modules\Auth\Services\AuthService($database->getConnection());
$user = $authService->getCurrentUser();
?>

<header class="header">
    <div class="container">
        <div class="header-content">
            <a href="/suc-fullstack/" class="logo">
                <img src="/suc-fullstack/assets/imgs/suc-logo.jpg" alt="SUC Forum Logo" style="height: 60px;">
            </a>

            <button class="mobile-nav-toggle" id="mobileNavToggle">
                <i class="fas fa-bars"></i>
            </button>

            <nav class="nav" id="navMenu">
                <ul class="nav-menu">
                    <li><a href="/suc-fullstack"><i class="fas fa-home"></i>Home</a></li>
                    <li class="user-menu dropdown-toggle">
                        <a href="#"><i class="fas fa-graduation-cap"></i>Academic <i class="fas fa-chevron-down"></i></a>
                        <div class="dropdown">
                            <a href="/suc-fullstack/calendar"><i class="fas fa-calendar-alt">Academic Calendar</i></a>
                            <a href="/suc-fullstack/documents"><i class="fas fa-file-alt"></i>Document Library</a>
                            <a href="/suc-fullstack/research"><i class="fas fa-microscope"></i>Researcch Hub</a>
                        </div>
                    </li>
                    <li class="user-menu dropdown-toggle">
                        <a href="#"><i class="fas fa-users"></i>Community <i class="fas fa-chevron-down"></i></a>
                        <div class="dropdown">
                            <a href="/suc-fullstack/events"><i class="fas fa-calendar"></i>Events</a>
                            <a href="/suc-fullstack/jobs"><i class="fas fa-briefcase"></i>Job Board</a>
                            <a href="/suc-fullstack/groups"><i class="fas fa-university"></i>University Groups</a>
                        </div>
                    </li>
                    <li><a href="/suc-fullstack/about"><i class="fas fa-info-circle"></i>About</a></li>
                    <li><a href="/suc-fullstack/search"><i class="fas fa-search"></i>Search</a></li>
                    <?php if($user): ?>
                        <li><a href="/suc-fullstack/messages"><i class="fas fa-info-circle"></i>About</a></li>
                        <li><a href="/suc-fullstack/notifications"><i class="fas fa-bell"></i>Notifications</a></li>
                        <li class="user-menu dropdown-toggle">
                            <a href="#">
                                <i class="fas fa-user"></i> <?php echo htmlspecialchars($user['username']); ?>
                                <i class="fasf fa-chevron-down"></i>
                            </a>
                            <div class="dropdown">
                                <a href="/suc-fullstack/profile"><i class="fas fa-user-circle"></i>Profile</a>
                                <a href="/suc-fullstack/settings"><i class="fas fa-cog"></i>Settings</a>
                                <?php if($user['role'] == 'admin'): ?>
                                    <a href="/suc-fullstack/admin"><i class="fas fa-shield-alt"></i>Admin Panel</a>
                                <?php endif; ?>
                                <a href="/suc-fullstack/logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li><a href="/suc-fullstack/login"><i class="fas fa-sign-in-alt"></i>Login</a></li>
                        <li><a href="/suc-fullstack/register"><i class="fas fa-user-plus"></i>Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>

<script src="/suc-fullstack/assets/scripts/main.js"></script>

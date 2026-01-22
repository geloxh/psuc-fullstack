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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="/suc-fullstack/assets/stylesheets/main.css">

<header class="header">
    <div class="container">
        <div class="header-content d-flex justify-content-between align-items-center">
            <a href="/suc-fullstack/public/" class="logo">
                <img src="/suc-fullstack/assets/imgs/suc-logo.jpg" alt="SUC Forum Logo" style="height: 60px;">
            </a>

            <nav class="d-flex gap-2">
                <a href="/suc-fullstack/public/" class="btn btn-outline-primary"><i class="fas fa-home"></i> Home</a>
                
                <!-- Academic Button Group -->
                <div class="btn-group">
                    <a href="/suc-fullstack/academic" class="btn btn-primary"><i class="fas fa-graduation-cap"></i> Academic</a>
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/suc-fullstack/calendar"><i class="fas fa-calendar-alt"></i> Academic Calendar</a>
                        <a class="dropdown-item" href="/suc-fullstack/documents"><i class="fas fa-file-alt"></i> Document Library</a>
                        <a class="dropdown-item" href="/suc-fullstack/research"><i class="fas fa-microscope"></i> Research Hub</a>
                    </div>
                </div>

                <!-- Community Button Group -->
                <div class="btn-group">
                    <a href="/suc-fullstack/community" class="btn btn-success"><i class="fas fa-users"></i> Community</a>
                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/suc-fullstack/events"><i class="fas fa-calendar"></i> Events</a>
                        <a class="dropdown-item" href="/suc-fullstack/jobs"><i class="fas fa-briefcase"></i> Job Board</a>
                        <a class="dropdown-item" href="/suc-fullstack/groups"><i class="fas fa-university"></i> University Groups</a>
                    </div>
                </div>

                <a href="/suc-fullstack/about" class="btn btn-outline-secondary"><i class="fas fa-info-circle"></i> About</a>
                <a href="/suc-fullstack/search" class="btn btn-outline-secondary"><i class="fas fa-search"></i> Search</a>

                <?php if($user): ?>
                    <a href="/suc-fullstack/messages" class="btn btn-outline-info"><i class="fas fa-envelope"></i> Messages</a>
                    <a href="/suc-fullstack/notifications" class="btn btn-outline-warning"><i class="fas fa-bell"></i> Notifications</a>
                    
                    <!-- User Button Group -->
                    <div class="btn-group">
                        <a href="/suc-fullstack/profile" class="btn btn-secondary"><i class="fas fa-user"></i> <?php echo htmlspecialchars($user['username']); ?></a>
                        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/suc-fullstack/profile"><i class="fas fa-user-circle"></i> Profile</a>
                            <a class="dropdown-item" href="/suc-fullstack/settings"><i class="fas fa-cog"></i> Settings</a>
                            <?php if($user['role'] == 'admin'): ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/suc-fullstack/admin"><i class="fas fa-shield-alt"></i> Admin Panel</a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/suc-fullstack/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/suc-fullstack/login" class="btn btn-outline-primary"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <a href="/suc-fullstack/register" class="btn btn-primary"><i class="fas fa-user-plus"></i> Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="/suc-fullstack/assets/scripts/main.js"></script>

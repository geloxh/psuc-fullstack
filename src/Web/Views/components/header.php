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
            <a href="/psuc-fullstack/" class="logo">
                <img src="/psuc-fullstack/assets/imgs/suc-logo.jpg" alt="SUC Forum Logo" style="height: 60px;">
            </a>


            <nav class="nav">
                <ul class="nav-menu">
                    <li><a href="/psuc-fullstack"><i class="fas fa-home"></i>Home</a></li>
                    <?php if($user): ?>
                        <li><a href="/psuc-fullstack/messages"><i class="fas fa-envelope"></i>Messages</a></li>
                        <li class="user-menu dropdown-toggle">
                            <a href="#">
                                <i class="fas fa-user"></i> <?php echo htmlspecialchars($user['username']); ?>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <div class="dropdown">
                                <a href="/psuc-fullstack/profile"><i class="fas fa-user-circle"></i>Profile</a>
                                <?php if($user['role'] == 'admin'): ?>
                                    <a href="/psuc-fullstack/admin"><i class="fas fa-shield-alt"></i>Admin Panel</a>
                                <?php endif; ?>
                                <a href="/psuc-fullstack/logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li><a href="/psuc-fullstack/login"><i class="fas fa-sign-in-alt"></i>Login</a></li>
                        <li><a href="/psuc-fullstack/register"><i class="fas fa-user-plus"></i>Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard for PSUC Forum">
    <link rel="stylesheet" href="assets/stylesheets/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Admin Page - PSUC Forum</title>
</head>
<body>
    <?php include __DIR__ . '/../../includes/header.php'; ?>

    <div class="dashboards-container">
        <div class="container">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h1>welcome back, <?php echo htmlspecialchars($user['full_name']); ?>!  👋</h1>
                <p>Here's what's happening with your forum today.</p>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <h3 class="stat-number"><?php echo number_format($stats['total_users']); ?></h3>
                    <p class="stat-label">Total Users</p>
                    <div class="stat-change">+<?php echo $stats['new_users_week']; ?> this week</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-comments"></i></div>
                <h3 class="stats-number"><?php echo number_format($stats['total_topics']); ?></h3>
                <p class="stat-label">Total Topics</p>
                <div class="stat-charge">+<?php echo $stats['topics_today']; ?> today</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-reply"></i></div>
                <h3 class="stat-number"><?php echo number_format($stats['total_posts']); ?></h3>
                <p class="stat-label">Total Posts</p>
                <div class="stat-change">+<?php echo $stats['posts_today']; ?> today</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                <h3 class="stat-number"><?php echo round(($stats['posts_today'] + $stats['topics_today']) / max($stats['total_users'], 1) * 100, 1); ?>%</h3>
                <p class="stat-label">Activity Rate</p>
                <div class="stat-change">Daily Engagement</div>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Quick Actions -->
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="quick-actions">
                <a href="users.php" class="action-btn">
                    <i class="fas fa-users"></i>
                    <span>Manage Users</span>
                </a>
                <a href="settings.php" class="action-btn">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </div>

            <!-- Recent Activity -->
            <div>
                <!-- Recent Users -->
                <div class="card" style="margin-bottom: 1.5rem;">
                    <div class="card-header">
                        <h3 class="card-title">Recent Users</h3>
                        <?php foreach($recent_users as $recent_user):  ?>
                            <div class="list-item">
                                <div class="list-avatar">
                                    <?php echo strtoupper(substr($recent_user['username'], 0, 1)); ?>
                                </div>
                                <div class="list-content">
                                    <p class="list-title"><?php echo htmlspecialchars($recent_user['full_name']); ?></p>
                                    <p class="list-subtitle">@<?php echo htmlspecialchars($recent_user['username']); ?></p>
                                </div>
                                <div class="badge">
                                    <?php echo date('M j', strtotime($recent_user['created_at'])); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Top Topics -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Popular Topics</h3>
                        </div>
                        <?php foreach($top_topics as $topic): ?>
                            <div class="list-item">
                                <div class="list-avatar">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <div class="list-content">
                                    <p class="list-title"><?php echo htmlspecialchars(substr($topic['title'], 0, 30)) . '...'; ?></p>
                                    <p class="list-subtitle">by <?php echo htmlspecialchars($topic['username']); ?></p>
                                </div>
                                <div class="badge">
                                    <?php echo $topic['reply_count']; ?> replies
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
     
</body>
</html>
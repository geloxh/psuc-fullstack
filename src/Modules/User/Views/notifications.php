<div class="notifications-container">
    <h1>Notifications</h1>

    <?php if (!empty($notifications)): ?>
        <div class="notifications-list">
            <?php foreach ($notifications as $notification): ?>
                <div class="notification-item <?= $notification['read'] ? '' : 'unread' ?>">
                    <div class="notification-content">
                        <p><?= htmlspecialchars($notification['message']) ?></p>
                        <span class="time"><?= $notification['created_at'] ?></span>
                    </div>
                    <?php if (!$notification['read']): ?>
                        <button class="mark-read" data-id="<?= $notification['id'] ?>">Mark as Read</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No notifications.</p>
    <?php endif; ?>
</div>
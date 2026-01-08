<div class="events-container">
    <h1>Events</h1>
    
    <?php if (!empty($events)): ?>
        <div class="events-list">
            <?php foreach ($events as $event): ?>
                <div class="event-card">
                    <h3><?= htmlspecialchars($event['title']) ?></h3>
                    <p><?= htmlspecialchars($event['description']) ?></p>
                    <span class="date"><?= htmlspecialchars($event['date']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No events scheduled.</p>
    <?php endif; ?>
</div>

<div class="research-container">
    <h1>Research Collaborations</h1>

    <?php if (!empty($collaborations)): ?>
        <div class="collaborations-list">
            <?php foreach ($collaborations as $collaboration): ?>
                <div class="collaboration-card">
                    <h3><?= htmlspecialchars($collaboration['title']) ?></h3>
                    <p><?= htmlspecialchars($collaboration['description']) ?></p>
                    <span class="status"><?= htmlspecialchars($collaboration['status']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No open collaborations available.</p>
    <?php endif; ?>
</div>
<div class="groups-container">
    <h1>User Group</h1>

    <?php if (!empty($groups)): ?>
        <div class="group-list">
            <?php foreach ($groups as $group): ?>
                <div class="group-card">
                    <h3><?= htmlspecialchars($group['name']) ?></h3>
                    <p><?= htmlspecialchars($group['description']) ?></p>
                    <span class="members"><?= $group['member_count'] ?> members</span>
                    <a href=""></a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p></p>
    <?php endif; ?>
</div>
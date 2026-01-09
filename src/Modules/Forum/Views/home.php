<div class="container">
    <h1>Welcome to PSUC Forum</h1>
    
    <?php foreach($categories as $category): ?>
        <div class="category-section">
            <h2><?php echo htmlspecialchars($category['name']); ?></h2>
            
            <?php foreach($category['forums'] as $forum): ?>
                <div class="forum-item">
                    <h3><a href="/psuc-fullstack/forum/<?php echo $forum['id']; ?>"><?php echo htmlspecialchars($forum['name']); ?></a></h3>
                    <p><?php echo htmlspecialchars($forum['description'] ?? ''); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
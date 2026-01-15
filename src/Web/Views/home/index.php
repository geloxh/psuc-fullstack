<div class="container">
    <div class="welcome-section">
        <h1>Welcome to SUC Forum</h1>
        <p>Connect with students and faculty from Philippine State Universities and Colleges</p>
        
        <?php if (!$user): ?>
            <div class="cta-buttons">
                <a href="/login" class="btn btn-primary">Login</a>
                <a href="/register" class="btn btn-secondary">Join Now</a>
            </div>
        <?php else: ?>
            <p>Welcome back, <?php echo htmlspecialchars($user['full_name']); ?>!</p>
        <?php endif; ?>
    </div>

    <div class="forum-categories">
        <?php if (empty($categories)): ?>
            <div class="no-content">
                <p>No categories available. Please contact administrator.</p>
            </div>
        <?php else: ?>
            <?php foreach ($categories as $category): ?>
                <div class="category-section">
                    <h2 class="category-title">
                        <i class="<?php echo $category['icon'] ?? 'fas fa-folder'; ?>"></i>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </h2>
                    
                    <?php if (!empty($category['description'])): ?>
                        <p class="category-description"><?php echo htmlspecialchars($category['description']); ?></p>
                    <?php endif; ?>
                    
                    <?php if (empty($category['forums'])): ?>
                        <p class="no-forums">No forums in this category yet.</p>
                    <?php else: ?>
                        <div class="forums-list">
                            <?php foreach ($category['forums'] as $forum): ?>
                                <div class="forum-item">
                                    <div class="forum-info">
                                        <h3><a href="/forum/<?php echo $forum['id']; ?>"><?php echo htmlspecialchars($forum['name']); ?></a></h3>
                                        <?php if (!empty($forum['description'])): ?>
                                            <p><?php echo htmlspecialchars($forum['description']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="forum-stats">
                                        <span><?php echo $forum['topics_count'] ?? 0; ?> Topics</span>
                                        <span><?php echo $forum['posts_count'] ?? 0; ?> Posts</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

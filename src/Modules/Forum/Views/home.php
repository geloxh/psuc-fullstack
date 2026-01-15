<div class="container" style="padding: 2rem 1rem;">
    <div class="hero-section">
        <h1 class="hero-title">Welcome to SUC-Industry Collaboration Forum</h1>
        <p class="hero-subtitle">Connect with students and faculty from Philippines State Universities and Colleges</p>
    </div>    

    
    <?php foreach($categories as $category): ?>
        <div class="category-section">
            <h2><?php echo htmlspecialchars($category['name']); ?></h2>
            
            <?php foreach($category['forums'] as $forum): ?>
                <div class="forum-item">
                    <h3><a href="/suc-fullstack/forum/<?php echo $forum['id']; ?>"><?php echo htmlspecialchars($forum['name']); ?></a></h3>
                    <p><?php echo htmlspecialchars($forum['description'] ?? ''); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
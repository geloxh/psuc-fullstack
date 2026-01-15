<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SUC Forum - A community for students, teachers, and staff to discuss and share knowledge.">
    <link rel="stylesheet" href="assets/stylesheets/main.css">
    <title><?php echo htmlspecialchars($topic['title']); ?> - SUC Forum</title>
</head>
<body>
    <div class="topic-header">
        <h1><?php echo htmlspecialchars($topic['title']); ?></h1>
        <div class="topic-meta">
            <span>by <?php echo htmlspecialchars($topic['username']); ?></span>
            <span><?php echo date('M j, Y', strtotime($topic['created_at'])); ?></span>
            <span><?php echo number_format($topic['views']); ?> views</span>
        </div>
    </div>

    <div class="topic-content">
        <?php echo nl2br(htmlspecialchars($topic['content'])); ?>
    </div>

    <div class="posts-section">
        <?php foreach($posts as $post): ?>
            <div class="post">
                <div class="post-author"><?php echo htmlspecialchars($post['username']); ?></div>
                <div class="post-content"><?php echo nl2br(htmlspecialchars($post['content'])); ?></div>
                <div class="post-date"><?php echo date('M j, Y g:i A', strtotime($post['created_at'])); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
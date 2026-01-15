<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SUC Forum - A community for students, teachers, and staff to discuss and share knowledge.">
    <link rel="stylesheet" href="assets/stylesheets/main.css">
    <title><?php echo htmlspecialchars($forum_info['name']); ?> - SUC Forum</title>
</head>
<body>
    <div class="forum-header">
        <h1><?php echo htmlspecialchars($forum_info['name']); ?></h1>
        <p><?php echo htmlspecialchars($forum_info['description']); ?></p>
    </div>

    <div class="topics-list">
        <?php foreach($topics as $topic): ?>
            <div class="topic-row">
                <h3>
                    <a href="topic.php?id=<?php echo $topic['id']; ?>"><?php echo htmlspecialchars($topic['title']); ?></a>
                </h3>
                <div class="topic-meta">
                    <span>by <?php echo htmlspecialchars($topic['username']); ?></span>
                    <span><?php echo $topic['replies_count']; ?> replies</span>
                    <span><?php echo number_format($topic['views']); ?> views</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
     
</body>
</html>
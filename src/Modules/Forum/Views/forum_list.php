<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SUC Forum - A community for students, teachers, and staff to discuss and share knowledge.">
    <link rel="stylesheet" href="assets/stylesheets/main.css">
    <title>SUC Forum</title>
</head>
<body>
    <div class="forum-container">
        <?php foreach($categories as $category): ?>
            <div class="category-section">
                <h2><?php echo htmlspecialchars($category['name']); ?></h2>
                <?php
                    $forums = $this->forumService->getForumsByCategory($category['id']);
                    foreach($forums as $forum):
                ?>
                    <div class="forum-item">
                        <a href="forum.php?id=<?php echo $forum['id']; ?>">
                            <h3><?php echo htmlspecialchars($forum['name']); ?></h3>
                            <p><?php echo htmlspecialchars($forum['description']); ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
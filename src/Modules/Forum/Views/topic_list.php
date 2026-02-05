<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SUC Forum - A community for students, teachers, and staff to discuss and share knowledge.">
    <title><?php echo htmlspecialchars($forum_info['name']); ?> - SUC Forum</title>
    <link rel="stylesheet" href="/suc-fullstack/assets/stylesheets/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .forum-container { max-width: 1000px; margin: 2rem auto; background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); }
        .forum-header { padding: 2rem; background: linear-gradient(135deg, #fafbfc 0%, #f8fafc 100%); border-bottom: 1px solid #f3f4f6; border-radius: 16px 16px 0 0; }
        .breadcrumb { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; font-size: 0.875rem; color: #6b7280; }
        .breadcrumb a { color: #3b82f6; text-decoration: none; transition: color 0.2s; }
        .breadcrumb a:hover { color: #2563eb; }
        .forum-title-bar { display: flex; justify-content: space-between; align-items: flex-start; gap: 2rem; }
        .forum-details h1 { font-size: 1.75rem; font-weight: 600; color: #111827; margin: 0 0 0.75rem 0; }
        .forum-details p { color: #6b7280; margin: 0 0 1rem 0; line-height: 1.5; }
        .forum-stats { display: flex; gap: 1.5rem; font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem; }
        .new-topic-button { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.25rem; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: all 0.2s; }
        .new-topic-button:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
        .topics-list { display: flex; flex-direction: column; }
        .topic-row { display: grid; grid-template-columns: 1fr auto; gap: 2rem; align-items: center; padding: 1.75rem 2rem; border-bottom: 1px solid rgba(243,244,246,0.6); transition: background-color 0.2s; }
        .topic-row:hover { background-color: rgba(248, 250, 252, 0.5); }
        .topic-info { flex: 1; }
        .topic-badges { margin-bottom: 0.75rem; }
        .topic-title { margin: 0 0 0.75rem 0; font-size: 1.1rem; font-weight: 500; }
        .topic-title a { color: #111827; text-decoration: none; transition: color 0.2s; }
        .topic-title a:hover { color: #3b82f6; }
        .topic-meta { display: flex; gap: 1.25rem; font-size: 0.85rem; color: #6b7280; margin-bottom: 1rem; }
        .topic-stats { display: flex; align-items: center; gap: 1rem; }
        .stat { text-align: center; min-width: 70px; padding: 0.5rem; background: rgba(248,250,252,0.5); border-radius: 8px; }
        .stat strong { display: block; font-size: 1.125rem; font-weight: 600; color: #111827; }
        .stat span { font-size: 0.7rem; color: #6b7280; text-transform: uppercase; }
        .badge { padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.7rem; font-weight: 500; margin-right: 0.5rem; }
        .badge.pinned { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: white; }
        .badge.locked { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
        .empty-state { text-align: center; padding: 5rem 2rem; color: #6b7280; }
        .empty-state h3 { margin: 0 0 1rem 0; font-size: 1.25rem; }
        .empty-state p { margin: 0 0 2rem 0; }
        .pagination { display: flex; justify-content: center; gap: 0.75rem; padding: 2.5rem 2rem; }
        .page-btn, .page-number { padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; background: white; color: #374151; text-decoration: none; border-radius: 10px; transition: all 0.2s; }
        .page-btn:hover, .page-number:hover { background: #f9fafb; border-color: #3b82f6; }
        .page-number.active { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border-color: #3b82f6; }
        
        @media (max-width: 768px) {
            .forum-title-bar { flex-direction: column; gap: 1rem; }
            .topic-row { grid-template-columns: 1fr; gap: 1rem; }
            .topic-stats { justify-content: center; }
            .forum-stats { flex-wrap: wrap; }
        }
    </style>
</head>
<body>
    <main>
        <div class="forum-container">
            <header class="forum-header">
                <nav class="breadcrumb">
                    <a href="/suc-fullstack/"><i class="fas fa-home"></i> Forum</a>
                    <i class="fas fa-chevron-right"></i>
                    <span><?php echo htmlspecialchars($forum_info['category_name']); ?></span>
                    <i class="fas fa-chevron-right"></i>
                    <span><?php echo htmlspecialchars($forum_info['name']); ?></span>
                </nav>

                <div class="forum-title-bar">
                    <div class="forum-details">
                        <h1><?php echo htmlspecialchars($forum_info['name']); ?></h1>
                        <p><?php echo htmlspecialchars($forum_info['description']); ?></p>
                        <div class="forum-stats">
                            <span><i class="fas fa-comments"></i> <?php echo $total_topics; ?> topics</span>
                            <span><i class="fas fa-reply"></i> <?php echo $forum_info['posts_count']; ?> posts</span>
                        </div>
                    </div>
                    <?php if($user): ?>
                        <a href="/suc-fullstack/new_topic.php?forum_id=<?php echo $forum_info['id']; ?>" class="new-topic-button">
                            <i class="fas fa-plus"></i> New Topic
                        </a>
                    <?php endif; ?>
                </div>
            </header>

            <div class="topics-section">
                <?php if(count($topics) > 0): ?>
                    <div class="topics-list">
                        <?php foreach($topics as $topic):
                            $last_reply = $topic['last_reply'] ? explode('|', $topic['last_reply']) : null;
                        ?>
                            <article class="topic-row">
                                <div class="topic-info">
                                    <div class="topic-badges">
                                        <?php if($topic['is_pinned']): ?>
                                            <span class="badge pinned"><i class="fas fa-thumbtack"></i> Pinned</span>
                                        <?php endif; ?>
                                        <?php if($topic['is_locked']): ?>
                                            <span class="badge locked"><i class="fas fa-lock"></i> Locked</span>
                                        <?php endif; ?>
                                    </div>
                                    <h3 class="topic-title">
                                        <a href="/suc-fullstack/topic.php?id=<?php echo $topic['id']; ?>">
                                            <?php echo htmlspecialchars($topic['title']); ?>
                                        </a>
                                    </h3>
                                    <div class="topic-meta">
                                        <span><i class="fas fa-user"></i> by <strong><?php echo htmlspecialchars($topic['username']); ?></strong></span>
                                        <span><i class="fas fa-calendar"></i> <?php echo date('M j, Y', strtotime($topic['created_at'])); ?></span>
                                    </div>
                                </div>
                                <div class="topic-stats">
                                    <div class="stat">
                                        <strong><?php echo $topic['replies_count']; ?></strong>
                                        <span>replies</span>
                                    </div>
                                    <div class="stat">
                                        <strong><?php echo number_format($topic['views']); ?></strong>
                                        <span>views</span>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-comments" style="font-size: 4rem; margin-bottom: 1.5rem; color: #d1d5db;"></i>
                        <h3>No topics yet</h3>
                        <p>This forum is waiting for its first discussion.</p>
                        <?php if($user): ?>
                            <a href="/suc-fullstack/new-topic?forum_id=<?php echo $forum_info['id']; ?>" class="new-topic-button">
                                <i class="fas fa-plus"></i> Create First Topic
                            </a>
                        <?php else: ?>
                            <a href="/suc-fullstack/src/Modules/auth/Views/login.php" class="new-topic-button" style="background: linear-gradient(135deg, #10b981, #059669);">
                                <i class="fas fa-sign-in-alt"></i> Sign In to Post
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if($total_pages > 1): ?>
                    <nav class="pagination">
                        <?php if($page > 1): ?>
                            <a href="?id=<?php echo $forum_info['id']; ?>&page=<?php echo $page-1; ?>" class="page-btn">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        <?php endif; ?>
                        
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?id=<?php echo $forum_info['id']; ?>&page=<?php echo $i; ?>"
                                class="page-number <?php echo $i == $page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if($page < $total_pages): ?>
                            <a href="?id=<?php echo $forum_info['id']; ?>&page=<?php echo $page+1; ?>" class="page-btn">
                                Next <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>

<style>
    /* Mobile-First Responsive Styles */
    .timeline-feed { max-width: 100%; padding: 0; }
    .empty-feed { text-align: center; padding: 40px 16px; color: #65676b; }
    .empty-feed i { font-size: 48px; color: #e4e6ea; margin-bottom: 16px; }
    .empty-feed h3 { font-size: 18px; font-weight: 600; margin: 0 0 8px 0; color: #1c1e21; }
    .empty-feed p { margin: 0 0 24px 0; font-size: 14px; line-height: 1.4; }
    .btn-create { background: #1877f2; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 15px; transition: all 0.2s; display: inline-block; }
    .btn-create:hover { background: #166fe5; transform: translateY(-1px); }

    .post { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); margin-bottom: 16px; border: 1px solid #e4e6ea; overflow: hidden; }
    .post-header { padding: 16px 16px 0; }
    .user-info { display: flex; align-items: center; gap: 12px; }
    .user-avatar { width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #e4e6ea, #f0f2f5); display: flex; align-items: center; justify-content: center; font-weight: 600; color: #65676b; font-size: 16px; flex-shrink: 0; }
    .user-details { flex: 1; min-width: 0; }
    .username { font-weight: 600; color: #1c1e21; text-decoration: none; font-size: 15px; line-height: 1.2; }
    .username:hover { text-decoration: underline; }
    .post-meta { font-size: 13px; color: #65676b; margin-top: 4px; display: flex; flex-wrap: wrap; gap: 8px; }
    .post-meta a { color: #1877f2; text-decoration: none; font-weight: 500; }
    .post-meta a:hover { text-decoration: underline; }
    .post-content { padding: 16px; }
    .post-title { margin: 0 0 12px 0; font-size: 18px; font-weight: 600; line-height: 1.3; }
    .post-title a { color: #1c1e21; text-decoration: none; }
    .post-title a:hover { color: #1877f2; }
    .post-text { color: #1c1e21; font-size: 15px; line-height: 1.4; margin-bottom: 16px; }
    .post-media { width: 100%; margin-bottom: 16px; border-radius: 8px; overflow: hidden; }
    .post-footer { border-top: 1px solid #e4e6ea; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; background: #fafbfc; }
    .post-stats { font-size: 13px; color: #65676b; display: flex; gap: 16px; }
    .post-actions { display: flex; gap: 8px; }
    .action-btn { color: #65676b; text-decoration: none; padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px; min-height: 44px; }
    .action-btn:hover { background: #f2f3f5; color: #1877f2; }

    .media-item { position: relative; border-radius: 8px; overflow: hidden; width: 100%; max-width: 100%; height: 250px; }
    .media-item img, .media-item video { width: 100%; height: 100%; object-fit: cover; }
    .media-overlay { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.7); color: white; padding: 16px; border-radius: 50%; }
    .file-preview { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 200px; background: #f8f9fa; color: #6c757d; text-align: center; padding: 20px; }
    .file-preview i { font-size: 2.5rem; margin-bottom: 12px; }
    .file-preview span { font-size: 0.9rem; word-break: break-word; }

    .hero-section { background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(147, 197, 253, 0.05)); border-radius: 16px; padding: 24px 16px; margin-bottom: 24px; text-align: center; border: 1px solid rgba(59, 130, 246, 0.1); }
    .hero-title { font-size: 24px; font-weight: 600; margin: 0 0 12px 0; line-height: 1.2; }
    .hero-subtitle { font-size: 16px; color: var(--text-secondary); line-height: 1.4; }

    .main-content { display: grid; grid-template-columns: 1fr; gap: 1rem; padding: 2rem 0; max-width: 1200px; margin: 0 auto; }
    .sidebar-right { display: none; }

    .activity-list { display: flex; flex-direction: column; gap: 12px; }
    .activity-item { padding: 12px; background: rgba(248, 250, 252, 0.6); border-radius: 8px; border: 1px solid rgba(229, 231, 235, 0.3); }
    .activity-title { font-weight: 500; color: var(--text-primary); font-size: 14px; text-decoration: none; display: block; margin-bottom: 4px; line-height: 1.3; }
    .activity-title:hover { color: var(--secondary-blue); }
    .activity-meta { font-size: 12px; color: var(--text-secondary); }
    .activity-time { display: block; margin-top: 2px; }

    @media (min-width: 768px) {
        .timeline-feed { padding: 0; }
        .empty-feed { padding: 60px 20px; }
        .post-header { padding: 16px 20px 0; }
        .post-content { padding: 16px 20px; }
        .post-footer { padding: 12px 20px; }
        .post-title { font-size: 20px; }
        .hero-section { padding: 40px 32px; }
        .hero-title { font-size: 32px; }
        .hero-subtitle { font-size: 18px; }
        .media-item { height: 300px; }
        .main-content { grid-template-columns: 1fr 280px; gap: 2rem; }
        .sidebar-right { display: block; position: sticky; top: 100px; height: fit-content; max-height: calc(100vh - 120px); overflow-y: auto; }
    }

    @media (min-width: 1024px) {
        .hero-section { padding: 48px 40px; }
        .hero-title { font-size: 36px; }
        .media-item { height: 350px; max-width: 600px; }
    }
</style>

<main class="container">
    <div class="main-content">
        <div class="forum-content">
            <div class="hero-section">
                <div class="hero-content">
                    <h1 class="hero-title"><i class="fas fa-graduation-cap"></i> Welcome to SUC-Industry Collaboration Forum</h1>
                    <p class="hero-subtitle">Connect, collaborate, and share knowledge with fellow students and faculty from Philippine State Universities and Colleges.</p>
                </div>
            </div>

            <div class="timeline-feed">
                <?php if (empty($recentTopics)): ?>
                    <div class="empty-feed">
                        <i class="fas fa-comments"></i>
                        <h3>No posts yet</h3>
                        <p>Be the first to share something with the community</p>
                        <?php if ($user): ?>
                            <a href="/new-topic" class="btn-create">Create Post</a>
                        <?php else: ?>
                            <a href="/login" class="btn-create">Sign In</a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <?php foreach($recentTopics as $topic): ?>
                        <article class="post">
                            <header class="post-header">
                                <div class="user-info">
                                    <?php if (!empty($topic['avatar'])): ?>
                                        <img src="/assets/avatars/<?php echo htmlspecialchars($topic['avatar']); ?>" alt="" class="user-avatar">
                                    <?php else: ?>
                                        <div class="user-avatar">
                                            <?php echo strtoupper(substr($topic['username'], 0, 1)); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="user-details">
                                        <a href="/profile?username=<?php echo htmlspecialchars($topic['username']); ?>" class="username"><?php echo htmlspecialchars($topic['username']); ?></a>
                                        <div class="post-meta">
                                            <span><?php echo date('M j \a\t g:i A', strtotime($topic['created_at'])); ?></span>
                                            <span>•</span>
                                            <a href="/forum?name=<?php echo urlencode($topic['forum_name']); ?>"><?php echo htmlspecialchars($topic['forum_name']); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </header>
                            
                            <div class="post-content">
                                <h2 class="post-title">
                                    <a href="/topic/<?php echo $topic['id']; ?>"><?php echo htmlspecialchars($topic['title']); ?></a>
                                </h2>
                                <div class="post-text">
                                    <?php
                                    $content = strip_tags($topic['content']);
                                    echo strlen($content) > 200 ? substr($content, 0, 200) . '...' : $content;
                                    ?>
                                </div>
                                
                                <?php if (!empty($topic['attachments'])): ?>
                                    <div class="post-media">
                                        <?php foreach (array_slice($topic['attachments'], 0, 4) as $attachment): ?>
                                            <?php if (strpos($attachment['file_type'], 'image/') === 0): ?>
                                                <div class="media-item">
                                                    <img src="<?php echo htmlspecialchars($attachment['file_path']); ?>" alt="Image attachment" loading="lazy">
                                                </div>
                                            <?php elseif (strpos($attachment['file_type'], 'video/') === 0): ?>
                                                <div class="media-item video-item">
                                                    <video controls preload="metadata">
                                                        <source src="<?php echo htmlspecialchars($attachment['file_path']); ?>" type="<?php echo htmlspecialchars($attachment['file_type']); ?>">
                                                    </video>
                                                    <div class="media-overlay"><i class="fas fa-play"></i></div>
                                                </div>
                                            <?php else: ?>
                                                <div class="media-item file-item">
                                                    <div class="file-preview">
                                                        <i class="fas fa-<?php echo $attachment['file_type'] === 'application/pdf' ? 'file-pdf' : 'file'; ?>"></i>
                                                        <span><?php echo htmlspecialchars(basename($attachment['file_path'])); ?></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <footer class="post-footer">
                                <div class="post-stats">
                                    <span><i class="fas fa-eye"></i> <?php echo $topic['views']; ?></span>
                                    <span><i class="fas fa-comments"></i> <?php echo $topic['reply_count']; ?></span>
                                </div>
                                <div class="post-actions">
                                    <a href="/topic/<?php echo $topic['id']; ?>" class="action-btn">
                                        <i class="far fa-comment"></i> Comment
                                    </a>
                                </div>
                            </footer>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <aside class="sidebar-right">
            <div class="widget">
                <div class="widget-header">
                    <div class="widget-icon"><i class="fas fa-chart-line"></i></div>
                    <h3>Forum Statistics</h3>
                </div>
                <div class="stats-grid">
                    <div class="stat-item">
                        <strong><?php echo $stats['total_users'] ?? 0; ?></strong>
                        <span>Members</span>
                    </div>
                    <div class="stat-item">
                        <strong><?php echo $stats['total_topics'] ?? 0; ?></strong>
                        <span>Topics</span>
                    </div>
                    <div class="stat-item">
                        <strong><?php echo $stats['total_posts'] ?? 0; ?></strong>
                        <span>Posts</span>
                    </div>
                    <div class="stat-item">
                        <strong><?php echo htmlspecialchars($stats['newest_user'] ?? 'None'); ?></strong>
                        <span>Newest Member</span>
                    </div>
                </div>
            </div>

            <div class="widget">
                <div class="widget-header">
                    <div class="widget-icon"><i class="fas fa-bolt"></i></div>
                    <h3>Quick Actions</h3>
                </div>
                <div class="quick-actions">
                    <a href="/new-topic" class="action-item"><i class="fas fa-plus"></i><span>New Topic</span></a>
                    <a href="/search" class="action-item"><i class="fas fa-search"></i><span>Search</span></a>
                    <a href="/messages" class="action-item"><i class="fas fa-envelope"></i><span>Messages</span></a>
                    <a href="/profile" class="action-item"><i class="fas fa-user"></i><span>Profile</span></a>
                </div>
            </div>

            <?php if (!empty($recentTopics)): ?>
            <div class="widget">
                <div class="widget-header">
                    <div class="widget-icon"><i class="fas fa-fire"></i></div>
                    <h3>Recent Activity</h3>
                </div>
                <div class="activity-list">
                    <?php foreach(array_slice($recentTopics, 0, 5) as $topic): ?>
                    <div class="activity-item">
                        <a href="/topic/<?php echo $topic['id']; ?>" class="activity-title"><?php echo htmlspecialchars($topic['title']); ?></a>
                        <div class="activity-meta">
                            <span>by <?php echo htmlspecialchars($topic['username']); ?> in <?php echo htmlspecialchars($topic['forum_name']); ?></span>
                            <span class="activity-time"><?php echo date('M j, g:i A', strtotime($topic['created_at'])); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </aside>
    </div>
</main>

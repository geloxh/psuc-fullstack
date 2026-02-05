<?php
    require_once __DIR__ . '/../../../config/database.php';
    require_once __DIR__ . '/../../../includes/auth.php';
    require_once __DIR__ . '/../../../includes/forum.php';

    $auth = new Auth();
    $forum = new Forum();
    $user = $auth->getCurrentUser();

    if (!$user) {
        header('Location: /suc-fullstack/login');
        exit;
    }

    $forum_id = $_SERVER['REQUEST_METHOD'] === 'POST' ? ($_POST['forum_id'] ?? 0) : ($_GET['forum_id'] ?? 0);
    $error = '';

    $database = new Database();
    $conn = $database->getConnection();

    $forum_query = "SELECT name FROM forums WHERE id = ?";
    $stmt = $conn->prepare($forum_query);
    $stmt->execute([$forum_id]);
    $forum_info = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$forum_id) {
        $categories_query = "SELECT c.*, (SELECT COUNT(*) FROM forums f WHERE f.category_id = c.id) as forum_count FROM categories c ORDER BY c.position, c.name";
        $stmt = $conn->prepare($categories_query);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $show_forum_selection = true;
    } elseif (!$forum_info) {
        header('Location: /suc-fullstack/');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $topic_id = $forum->createTopic($forum_id, $user['id'], $_POST['title'], $_POST['content']);
            if ($topic_id) {
                header("Location: /suc-fullstack/topic?id=$topic_id");
                exit;
            } else {
                $error = 'Failed to create topic. Please try again.';
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
?>

<div class="container">
    <?php if(isset($show_forum_selection)): ?>
        <div class="main-content" style="max-width: 1000px; margin: 2rem auto;">
            <div class="widget">
                <div class="widget-header">
                    <div class="widget-icon"><i class="fas fa-plus-circle"></i></div>
                    <h3>Create New Topic</h3>
                    <p>Choose a forum to start your discussion</p>
                </div>
                
                <div class="forum-selection" style="padding: 1rem;">
                    <?php foreach($categories as $category):
                        $forums_query = "SELECT id, name, description FROM forums WHERE category_id = ? ORDER BY position, name";
                        $stmt = $conn->prepare($forums_query);
                        $stmt->execute([$category['id']]);
                        $forums = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if(count($forums) > 0):
                    ?>
                        <div style="margin-bottom: 2rem;">
                            <h4 style="color: var(--text-primary); margin-bottom: 1rem;">
                                <i class="<?php echo $category['icon']; ?>" style="color: <?php echo $category['color']; ?>"></i>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </h4>
                            <div style="display: grid; gap: 1rem;">
                                <?php foreach($forums as $forum_item): ?>
                                    <a href="/suc-fullstack/new-topic?forum_id=<?php echo $forum_item['id']; ?>" 
                                       style="display: block; padding: 1rem; border: 1px solid var(--border-color); border-radius: 8px; text-decoration: none; color: var(--text-primary); transition: all 0.2s ease;">
                                        <h5 style="margin: 0 0 0.5rem 0;"><?php echo htmlspecialchars($forum_item['name']); ?></h5>
                                        <p style="margin: 0; color: var(--text-secondary); font-size: 0.9rem;"><?php echo htmlspecialchars($forum_item['description']); ?></p>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; endforeach; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="main-content" style="grid-template-columns: 1fr; max-width: 800px; margin: 2rem auto;">
            <div class="widget">
                <div class="widget-header">
                    <div class="widget-icon"><i class="fas fa-edit"></i></div>
                    <h3>Create New Topic</h3>
                    <p>in <?php echo htmlspecialchars($forum_info['name']); ?></p>
                </div>

                <?php if ($error): ?>
                    <div style="background: #fee; border: 1px solid #fcc; color: #c33; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span><?php echo $error; ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" class="topic-form">
                    <input type="hidden" name="forum_id" value="<?php echo $forum_id; ?>">
                    
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="title" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-primary);">Topic Title</label>
                        <input type="text" id="title" name="title" class="form-control" 
                               placeholder="What would you like to discuss?" required maxlength="255"
                               value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>"
                               style="font-size: 1.1rem; padding: 1rem;">
                    </div>

                    <div class="form-group" style="margin-bottom: 2rem;">
                        <label for="content" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-primary);">Content</label>
                        <textarea name="content" id="content" class="form-control" rows="8" 
                                  placeholder="Share your thoughts, ask questions, or start a discussion..." required
                                  style="resize: vertical; min-height: 200px; padding: 1rem; line-height: 1.6;"><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-actions" style="display: flex; gap: 1rem; justify-content: flex-end;">
                        <a href="/suc-fullstack/forum?id=<?php echo $forum_id; ?>" class="btn" style="background: #f3f4f6; color: var(--text-secondary); text-decoration: none;">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Create Topic
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .form-group label {
        font-size: 0.9rem;
    }

    .form-control:focus {
        border-color: var(--secondary-blue);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .topic-form {
        padding: 0.5rem 0;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .forum-selection a:hover {
        border-color: var(--secondary-blue) !important;
        background: rgba(59, 130, 246, 0.05);
    }
</style>

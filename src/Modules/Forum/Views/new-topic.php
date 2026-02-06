<div class="container">
    <div class="main-content" style="grid-template-columns: 1fr; max-width: 800px; margin: 2rem auto;">
        <div class="widget">
            <div class="widget-header">
                <div class="widget-icon"><i class="fas fa-plus-circle"></i></div>
                <h3>Create New Topic</h3>
            </div>

            <?php if ($error ?? false): ?>
                <div style="background: #fee; border: 1px solid #fcc; color: #c33; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span><?php echo $error; ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" class="topic-form">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="title" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-primary);">Topic Title</label>
                    <input type="text" id="title" name="title" class="form-control" 
                           placeholder="Enter a descriptive title for your topic" required 
                           style="font-size: 1.1rem; padding: 1rem;"
                           value="<?php echo htmlspecialchars($title ?? ''); ?>">
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="forum" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-primary);">Forum Category</label>
                    <select id="forum" name="forum_id" class="form-control" required style="padding: 1rem;">
                        <option value="">Select a forum category</option>
                        <?php if (isset($forums)): ?>
                            <?php foreach($forums as $forum): ?>
                                <option value="<?php echo $forum['id']; ?>"><?php echo htmlspecialchars($forum['name']); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 2rem;">
                    <label for="content" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-primary);">Content</label>
                    <textarea name="content" id="content" class="form-control" rows="8" 
                              placeholder="Share your thoughts, questions, or ideas..." required 
                              style="resize: vertical; min-height: 200px; padding: 1rem; line-height: 1.6;"><?php echo htmlspecialchars($content ?? ''); ?></textarea>
                </div>

                <div class="form-actions" style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <a href="/suc-fullstack/" class="btn" style="background: #f3f4f6; color: var(--text-secondary); text-decoration: none;">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Create Topic
                    </button>
                </div>
            </form>
        </div>
    </div>
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
</style>

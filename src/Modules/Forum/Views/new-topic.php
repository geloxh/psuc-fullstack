<div class="container">
    <div class="main-content" style="grid-template-columns: 1fr; max-width: 800px; margin: 2rem auto;">
        <div class="widget">
            <div class="widget-header">
                <div class="widget-icon"><i class="fas fa-plus-circle"></i></div>
                <h3>Create New Topic</h3>
            </div>

            <form method="POST" action="/suc-fullstack/new-topic" class="topic-form">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="title" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-primary);">Topic Title</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Enter a descriptive title for your topic" required style="font-size: 1.1rem; padding: 1rem;">
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="forum" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-primary);">Topic Title</label>
                    <select id="forum" name="forum_id" class="form-conrtol" required style="padding: 1rem;">
                        <option value="">Select a forum category</option>
                        <option value="1">General Discussions</option>
                        <option value="2">Academic Resources</option>
                        <option value="3">Industry Collaboration</option>
                        <option value="4">Research & Innovation</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 2rem;">
                    <label for="content" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-primary);">Content</label>
                    <textarea name="content" id="content" class="form-control" rows="8" placeholder="Share your thoughts, questions, or ideas..." required style="resize: vertical; min-height: 200px; padding: 1rem; line-height: 1.6;"></textarea>
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
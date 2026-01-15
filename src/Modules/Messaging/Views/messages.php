<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - SUC Forum</title>
    <link rel="stylesheet" href="assets/stylesheets/main.css">
    <link rel="stylesheet" href="assets/stylesheets/messages.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="messages-container">
        <!-- Sidebar -->
        <nav class="messages-nav">
            <button class="compose-btn" onclick="toggleCompose()">
                <i class="fas fa-edit"></i>
                New Message
            </button>
            
            <div class="nav-links">
                <a href="?view=inbox" class="nav-link <?php echo $view === 'inbox' ? 'active' : ''; ?>">
                    <i class="fas fa-inbox"></i>
                    Inbox
                    <?php if ($unread_count > 0): ?>
                        <span class="badge"><?php echo $unread_count; ?></span>
                    <?php endif; ?>
                </a>
                <a href="?view=sent" class="nav-link <?php echo $view === 'sent' ? 'active' : ''; ?>">
                    <i class="fas fa-paper-plane"></i>
                    Sent
                </a>
            </div>
        </nav>

        <!-- Messages List -->
        <div class="messages-list <?php echo $selected_message ? 'hidden-mobile' : ''; ?>">
            <div class="list-header">
                <h2><?php echo ucfirst($view); ?></h2>
                <?php if (isset($_GET['success'])): ?>
                    <div class="success-msg">Message sent!</div>
                <?php endif; ?>
                <?php if (isset($_GET['deleted'])): ?>
                    <div class="success-msg">Message deleted!</div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="error-msg"><?php echo $error; ?></div>
                <?php endif; ?>
            </div>

            <div class="search-box">
                <input type="text" class="search-input" placeholder="Search messages..." id="messageSearch">
            </div>

            <?php if (count($messages) > 0): ?>
                <div class="message-items">
                    <?php foreach ($messages as $message): ?>
                        <a href="?view=<?php echo $view; ?>&message=<?php echo $message['id']; ?>" 
                           class="message-item <?php echo !$message['is_read'] && $view === 'inbox' ? 'unread' : ''; ?> <?php echo $selected_message == $message['id'] ? 'active' : ''; ?>">
                            <div class="message-header">
                                <div class="message-from">
                                    <?php echo htmlspecialchars($message['other_user']); ?>
                                </div>
                                <div class="message-time">
                                    <?php echo date('M j', strtotime($message['created_at'])); ?>
                                </div>
                            </div>
                            <div class="message-subject">
                                <?php echo htmlspecialchars($message['subject']); ?>
                            </div>
                            <div class="message-preview">
                                <?php echo substr(htmlspecialchars($message['content']), 0, 60) . '...'; ?>
                            </div>      
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>No messages yet</h3>
                    <p>Your <?php echo $view; ?> is empty. Start a conversation!</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Message Detail -->
        <?php if ($message_detail): ?>
            <div class="message-detail">
                <div class="detail-header">
                    <button class="back-btn" onclick="window.location.href='?view=<?php echo $view; ?>'">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="detail-actions">
                        <button class="action-btn" title="Reply" onclick="replyToMessage(<?php echo $message_detail['id']; ?>, '<?php echo htmlspecialchars($message_detail['sender_name']); ?>', '<?php echo htmlspecialchars($message_detail['subject']); ?>')">
                            <i class="fas fa-reply"></i>
                        </button>
                        <button class="action-btn" title="Delete" onclick="deleteMessage(<?php echo $message_detail['id']; ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="message-content">
                    <h1><?php echo htmlspecialchars($message_detail['subject']); ?></h1>
                    <div class="message-meta">
                        <span class="from">From: <strong><?php echo htmlspecialchars($message_detail['sender_name']); ?></strong></span>
                        <span class="date"><?php echo date('M j, Y g:i A', strtotime($message_detail['created_at'])); ?></span>
                    </div>
                    <div class="message-body">
                        <?php echo nl2br(htmlspecialchars($message_detail['content'])); ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="no-message">
                <i class="fas fa-envelope-open"></i>
                <h3>Select a message</h3>
                <p>Choose a message from the list to read it</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Compose Modal -->
    <div class="compose-overlay" id="compose-overlay" onclick="toggleCompose()"></div>
    <div class="compose-modal" id="compose-modal">
        <div class="modal-header">
            <h3 id="modal-title">New Message</h3>
            <button class="close-btn" onclick="toggleCompose()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form method="POST" class="compose-form" id="compose-form">
            <select name="receiver_id" id="receiver-select" required>
                <option value="">Select recipient...</option>
                <?php foreach ($users as $u): ?>
                    <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['username']); ?></option>
                <?php endforeach; ?>
            </select>
            
            <input type="text" name="subject" id="subject-input" placeholder="Subject" required>
            
            <textarea name="content" id="content-textarea" placeholder="Write your message..." required></textarea>
            
            <div class="form-actions">
                <button type="submit" name="send_message" class="send-btn">
                    <i class="fas fa-paper-plane"></i>
                    Send
                </button>
                <button type="button" class="cancel-btn" onclick="toggleCompose()">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="compose-overlay" id="delete-overlay"></div>
    <div class="compose-modal" id="delete-modal" style="width: 400px;">
        <div class="modal-header">
            <h3>Delete Message</h3>
            <button class="close-btn" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 1.5rem;">
            <p>Are you sure you want to delete this message? This action cannot be undone.</p>
            
            <form method="POST" id="delete-form">
                <input type="hidden" name="message_id" id="delete-message-id">
                <div class="form-actions" style="margin-top: 1rem;">
                    <button type="submit" name="delete_message" class="send-btn" style="background: #ef4444;">
                        <i class="fas fa-trash"></i>
                        Delete
                    </button>
                    <button type="button" class="cancel-btn" onclick="closeDeleteModal()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleCompose() {
            const overlay = document.getElementById('compose-overlay');
            const modal = document.getElementById('compose-modal');
            
            overlay.classList.toggle('active');
            modal.classList.toggle('active');
            
            if (!modal.classList.contains('active')) {
                resetComposeForm();
            }
        }

        function replyToMessage(messageId, senderName, subject) {
            document.getElementById('modal-title').textContent = 'Reply to Message';
            
            const receiverSelect = document.getElementById('receiver-select');
            for (let option of receiverSelect.options) {
                if (option.textContent === senderName) {
                    option.selected = true;
                    break;
                }
            }
            
            const replySubject = subject.startsWith('Re: ') ? subject : 'Re: ' + subject;
            document.getElementById('subject-input').value = replySubject;
            
            toggleCompose();
        }

        function deleteMessage(messageId) {
            document.getElementById('delete-message-id').value = messageId;
            document.getElementById('delete-overlay').classList.add('active');
            document.getElementById('delete-modal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('delete-overlay').classList.remove('active');
            document.getElementById('delete-modal').classList.remove('active');
        }

        function resetComposeForm() {
            document.getElementById('modal-title').textContent = 'New Message';
            document.getElementById('compose-form').reset();
        }

        // Search functionality
        document.getElementById('messageSearch')?.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const messages = document.querySelectorAll('.message-item');
            
            messages.forEach(message => {
                const text = message.textContent.toLowerCase();
                message.style.display = text.includes(searchTerm) ? 'block' : 'none';
            });
        });

        // Auto-hide success/error messages
        setTimeout(() => {
            const successMsg = document.querySelector('.success-msg');
            const errorMsg = document.querySelector('.error-msg');
            if (successMsg) successMsg.style.display = 'none';
            if (errorMsg) errorMsg.style.display = 'none';
        }, 3000);

        // Close modals when clicking overlay
        document.getElementById('delete-overlay').addEventListener('click', closeDeleteModal);
    </script>
</body>
</html>

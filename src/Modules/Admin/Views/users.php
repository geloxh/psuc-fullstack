<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manage Users Page for SUC Forum Admin">
    <link rel="stylesheet" href="assets/stylesheets/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Manage Users - SUC Admin</title>
</head>
<body>
    <?php include __DIR__ . '/../../includes/header.php'; ?>

    <main class="container">
        <div class="main-content">
            <div class="forum-content">
                <div class="p-3">
                    <h1><i class="fas fa-users"></i> Manage Users</h1>
                    <p class="text-secondary">roral users: <?php echo $data['total']; ?></p>
                </div>

                <!-- Filters -->
                <div class="p-3">
                    <form method="GET" class="filters">
                        <input type="text" name="search" placeholder="Search users..."  value="<?php echo htmlspecialchars($search); ?>" class="form-control">
                        <select name="role" class="form-control">
                            <option value="">All Roles</option>
                            <option value="admin" <?php echo $role_filter == 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="moderator" <?php echo $role_filter == 'moderator' ? 'selected' : ''; ?>>Moderator</option>
                            <option value="faculty" <?php echo $role_filter == 'faculty' ? 'selected' : ''; ?>>Faculty</option>
                            <option value="student" <?php echo $role_filter == 'student' ? 'selected' : ''; ?>>Student</option> 
                        </select>
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="users.php" class="btn btn-secondary">Clear</a>
                    </form>
                </div>

                <!-- Users Table -->
                <div class="p-3">
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['users'] as $u): ?>
                                <tr data-user-id="<?php echo $u['id']; ?>">
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 1rem">
                                            <img src="../assets/avatars/<?php echo $u['avatar'] ?: 'default.png'; ?>" alt="Avatar" class="user-avatar">
                                            <div>
                                                <strong><?php echo htmlspecialchars($u['username']); ?></strong>
                                                <br><smal><?php echo htmlspecialchars($u['full_name']); ?></small>
                                            </div>
                                        </div>                  
                                    </td>
                                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                                    <td>
                                        <select class="role-select" data-user-id="<?php echo $u['id']; ?>">
                                            <option value="admin" <?php echo $u['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                            <option value="moderator" <?php echo $u['role'] == 'moderator' ? 'selected' : ''; ?>>Moderator</option>
                                            <option value="faculty" <?php echo $u['role'] == 'faculty' ? 'selected' : ''; ?>>Faculty</option>
                                            <option value="student" <?php echo $u['role'] == 'student' ? 'selected' : ''; ?>>Student</option>
                                        </select>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($u['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm delete-user" data-user-id="<?php echo $u['id']; ?>">\
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <?php if($data['total_pages'] > 1): ?>
                        <div class="pagination">
                            <?php for($i = 1; $i <= $data['total_pages']; $i++): ?>
                                <a href="?page=<php echo $i; ?>&search=<?php echo urlencode($search); ?>&role=<?php echo urlencode($role_filter); ?> ">
                                    class="<?php echo $i == $page ? 'active' : ''; ?>">
                                    <?php echo $i; ?> 
                                </a>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Handle role updates
        document.querySelectorAll('.role-select').forEach(select => {
            select.addEventListener('change', function() {
                const userId = this.dataset.userId;
                const role = this.value;

                fetch('', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `ajax=1&action=update_role&user_id=${useId}&role=${role}`
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Failed to update role');
                    }
                });
            });
        });

        // Handle user deletion
        document.querySelectorAll('.delete-user').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this user?')) {
                    const userId = this.dataset.userId;

                    fetch('', {
                        method: 'POST',
                        headers: {'Content-Type' : 'application/x-www-form-urlencoded'},
                        body: `ajax=1&action=delete_user&user_id=${userId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('tr').remove();
                        } else {
                            alert('Failed to delete user');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
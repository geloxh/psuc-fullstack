<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manage Users Page for PSUC Admin">
    <link rel="stylesheet" href="assets/stylesheets/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Manage Users - PSUC Admin</title>
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
                                            <option value=""></option>
                                            <option value=""></option>
                                            <option value=""></option>
                                            <option value=""></option>
                                        </select>
                                    </td>

                                </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>
</body>
</html>
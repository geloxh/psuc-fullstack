<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - SUC Forum</title>
    <link rel="stylesheet" href="assets/stylesheets/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main style="background: #f8fafc; min-height: 100vh; padding: 3rem 1rem;">
        <div style="max-width: 700px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h1 style="font-size: 2.5rem; font-weight: 300; color: #1a202c; margin: 0 0 0.5rem 0;">Account Settings</h1>
                <p style="color: #718096; font-size: 1.1rem; margin: 0;">Manage your profile information</p>
            </div>

            <?php if($success): ?>
                <div style="background: rgba(34, 197, 94, 0.1); color: #059669; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; text-align: center;">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <?php if($error): ?>
                <div style="background: rgba(239, 68, 68, 0.1); color: #dc2626; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; text-align: center;">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div style="background: white; border-radius: 20px; padding: 3rem; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                <form method="POST">
                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; font-weight: 500; color: #1a202c; margin-bottom: 0.75rem;">Full Name</label>
                        <input type="text" name="full_name" required 
                               value="<?php echo htmlspecialchars($user['full_name']); ?>"
                               style="width: 100%; padding: 1rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem;">
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; font-weight: 500; color: #1a202c; margin-bottom: 0.75rem;">Email Address</label>
                        <input type="email" name="email" required 
                               value="<?php echo htmlspecialchars($user['email']); ?>"
                               style="width: 100%; padding: 1rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem;">
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; font-weight: 500; color: #1a202c; margin-bottom: 0.75rem;">University/College</label>
                        <select name="university" required 
                                style="width: 100%; padding: 1rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem;">
                            <?php foreach($universities as $group => $unis): ?>
                                <optgroup label="<?php echo htmlspecialchars($group); ?>">
                                    <?php foreach($unis as $uni): ?>
                                        <option value="<?php echo htmlspecialchars($uni); ?>" 
                                                <?php echo $user['university'] == $uni ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($uni); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div style="text-align: center;">
                        <button type="submit" 
                                style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; padding: 1rem 3rem; border-radius: 50px; font-weight: 500; cursor: pointer; font-size: 1rem;">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>

<?php
$error = $error ?? '';
$success = $success ?? '';
$universities = $universities ?? [];
$formData = $formData ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SUC Forum</title>
    <style>
        @import url('https://fonts.cdnfonts.com/css/optima');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Optima', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .logo {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .logo-img {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            display: block;
            border-radius: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #2d3748;
            margin: 0 0 0.5rem;
        }
        .subtitle {
            color: #718096;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        input, select {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            background: #f7fafc;
            transition: all 0.2s ease;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #4299e1;
            background: white;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        }
        button {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin: 1.5rem 0;
            transition: all 0.2s ease;
        }
        button:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(66, 153, 225, 0.3);
        }
        .error {
            background: #fed7d7;
            color: #c53030;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            border-left: 4px solid #e53e3e;
        }
        .success {
            background: #c6f6d5;
            color: #2f855a;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            border-left: 4px solid #38a169;
        }
        .links {
            text-align: center;
            font-size: 0.9rem;
            color: #718096;
        }
        .links a {
            color: #4299e1;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .links a:hover {
            color: #3182ce;
        }
        @media (max-width: 480px) {
            .container {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="assets/imgs/suc-logo.jpg" alt="SUC Logo" class="logo-img">
            <h1>SUC-Industry Collaboration Forum</h1>
            <p class="subtitle">Join the community</p>
        </div>
                
        <?php if($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
                
        <form method="POST" action="/register">
            <div class="form-group">
                <input type="text" name="full_name" placeholder="Full Name" required value="<?php echo htmlspecialchars($formData['full_name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required value="<?php echo htmlspecialchars($formData['username'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <select name="university" required>
                    <option value="">Select your institution</option>
                    <?php foreach($universities as $group => $unis): ?>
                        <optgroup label="<?php echo htmlspecialchars($group); ?>">
                            <?php foreach($unis as $uni): ?>
                                <option value="<?php echo htmlspecialchars($uni); ?>" <?php echo (isset($formData['university']) && $formData['university'] == $uni) ? 'selected' : ''; ?>><?php echo htmlspecialchars($uni); ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <select name="role" required>
                    <option value="college student" <?php echo (isset($formData['role']) && $formData['role'] == 'college student') ? 'selected' : ''; ?>>College Student</option>
                    <option value="faculty" <?php echo (isset($formData['role']) && $formData['role'] == 'faculty') ? 'selected' : ''; ?>>Faculty</option>
                    <option value="other" <?php echo (isset($formData['role']) && $formData['role'] == 'other') ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required minlength="6">
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required minlength="6">
            </div>
            <button type="submit">Register</button>
        </form>
        
        <div class="links">
            <a href="/login">Already have an account?</a> • <a href="/">Back to forum</a>
        </div>
    </div>
</body>
</html>

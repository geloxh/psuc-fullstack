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

        .search-dropdown {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 1rem;
            border:2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            background: #f7fafc;
            transition: all 0.2s ease;
        }

        .dropdown-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #e2e8f0;
            border-top:none;
            border-radius: 0 0 12px 12px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f1f5f9;       
        }

        .dropdown-item:hover {
            background: #f8fafc;
        }

        .dropdown-item.selected {
            background: #e6fffa;
            color: #2d3748;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="/suc-fullstack/assets/imgs/suc-logo.jpg" alt="SUC Logo" class="logo-img">
            <h1>SUC-Industry Collaboration Forum</h1>
            <p class="subtitle">Join the community</p>
        </div>
                
        <?php if($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
                
        <form method="POST" action="/suc-fullstack/register">
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
                <div class="search-dropdown">
                    <input type="text" id="universitySearch" placeholder="Search your institution..." autocomplete="off">
                    <input type="hidden" name="university" id="universityValue" required>
                    <div class="dropdown-list" id="universityDropdown"></div>
                </div>
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
            <a href="/suc-fullstack/src/Modules/Auth/Views/login.php">Already have an account?</a> • <a href="/suc-fullstack/public/">Back to forum</a>
        </div>
    </div>

    <script>
        const universities = <?php echo json_encode(!empty($universities) && is_array($universities) ? array_merge(...array_values($universities)) : []); ?>;
        const searchInput = document.getElementById('universitySearch');
        const hiddenInput = document.getElementById('universityValue');
        const dropdown = document.getElementById('universityDropdown');

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const filtered = universities.filter(uni => uni.toLowerCase().includes(query));

            if (query && filtered.length > 0) {
                dropdown.innerHTML = filtered.map(uni =>
                    `<div class="dropdown-item" data-value="${uni}">${uni}</div>`
                ).join('');
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        });

        dropdown.addEventListener('click', function(e) {
            if (e.target.classList.contains('dropdown-item')) {
                const value = e.target.dataset.value;
                searchInput.value = value;
                hiddenInput.value = value;
                dropdown.style.display = 'none';
            }
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
</body>
</html>

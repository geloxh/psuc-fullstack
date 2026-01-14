<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PSUC Forum">
    <link rel="stylesheet" href="/psuc-fullstack/assets/stylesheets/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php if (isset($styles)): ?>
        <?php foreach ($styles as $style): ?>
            <link rel="stylesheet" href="<?php echo $style; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <title><?php echo $title ?? 'PSUC Forum'; ?></title>
</head>
<body>
   <?php include __DIR__ . '/../components/header.php'; ?>

   <div class="main-layout">
        <?php include __DIR__ . '/../components/SideBar.php'; ?>
        <main>
            <?php echo $content ?? ''; ?>
        </main>
   </div>

    <?php include __DIR__ . '/../components/footer.php'; ?>

    <script src="/psuc-fullstack/assets/scripts/main.js"></script>
    <?php if (isset($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
     
</body>
</html>

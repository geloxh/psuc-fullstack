<?php include __DIR__ . '/../../../Web/Views/components/header.php'; ?>
<?php include __DIR__ . '/../../../Web/Views/components/SideBard.php'; ?>

<div class="container">
    <h1>Edit Topic</h1>
    <form method="POST" action="/suc-fullstack/topic/<?= $topic['id'] ?>/update">
        <div class="form-group">
            <label>Title:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($topic['title']) ?>" required>
        </div>
        <div class="form-group">
            <label>Content:</label>
            <textarea name="content" required><?= htmlspecialchars($topic['content']) ?></textarea>
        </div>
        <button type="submit">Update Topic</button>
        <a href="/suc-fullstack/topic/<?= $topic['id'] ?>">Cancel</a>
    </form>
</div>

<?php include __DIR__ . '/../../../Web/Views/components/footer.php'; ?>
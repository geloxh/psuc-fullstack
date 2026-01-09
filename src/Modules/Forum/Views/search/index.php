<div class="search-container">
    <h1>Search Results</h1>

    <form method="GET" class="search-form">
        <input type="text" name="q" value="<?= htmlspecialchars($query) ?>" placeholder="Search topics, posts...">
        <button type="submit">Search</button>
    </form>

    <?php if (!empty($query)): ?>
        <h2>Results for "<?= htmlspecialchars($query) ?>"</h2>

        <?php if (!empty($results)): ?>
            <div class="search-results">
                <?php foreach ($results as $result): ?>
                    <div class="result-item">
                        <h3><a href="/topic/<?= $result['id'] ?>"><?= htmlspecialchars($result['title']) ?></a></h3>
                        <p><?= htmlspecialchars(substr($result['content'], 0, 200)) ?>...</p>
                        <span class="meta">By <?= htmlspecialchars($result['author']) ?> on <?= $result['created_at'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No results found for your search.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
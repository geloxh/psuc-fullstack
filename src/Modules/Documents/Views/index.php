<div class="documents-container">
    <h1>Documents</h1>

    <div class="documents-list">
        <?php if (!empty($documents)): ?>
            <?php foreach ($documents as $document): ?>
                <div class="document-item">
                    <h3><?= htmlspecialchars($document['title']) ?></h3>
                    <p><?= htmlspecialchars($document['description']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No documents available.</p>
        <?php endif; ?>
    </div>
</div>
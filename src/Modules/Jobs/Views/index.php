<div class="jobs-container">
    <h1>Job Opportunities</h1>
    
    <?php if (!empty($jobs)): ?>
        <div class="jobs-list">
            <?php foreach ($jobs as $job): ?>
                <div class="job-card">
                    <h3><?= htmlspecialchars($job['title']) ?></h3>
                    <p><?= htmlspecialchars($job['description']) ?></p>
                    <span class="company"><?= htmlspecialchars($job['company']) ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No job opportunities available.</p>
        <?php endif; ?>
    </div>
</div>

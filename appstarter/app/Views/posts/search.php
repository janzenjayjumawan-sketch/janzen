<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h3 class="text-3xl font-bold mb-6">Search Results for "<?= htmlspecialchars($keyword) ?>"</h3>
        
        <?php if (!empty($results)): ?>
            <?php foreach ($results as $post): ?>
                <div class="bg-white rounded-lg shadow-md mb-4 p-4 post-card">
                    <div class="flex justify-between items-start mb-3">
                        <a href="<?= base_url('/users/profile/' . $post['username']) ?>" class="text-blue-600 hover:text-blue-800 font-semibold">
                            <?= $post['username'] ?>
                        </a>
                        <small class="text-gray-500"><?= date('M d, Y', strtotime($post['created_at'])) ?></small>
                    </div>
                    <p class="text-gray-700 mb-3"><?= substr(nl2br($post['content']), 0, 200) ?>...</p>
                    <a href="<?= base_url('/posts/view/' . $post['id']) ?>" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm transition">View Post</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded">No posts found for your search.</div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <?php foreach ($posts as $post): ?>
            <div class="bg-white rounded-lg shadow-md mb-6 hover:shadow-lg transition-shadow post-card">
                <div class="border-b border-gray-200 p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <a href="<?= base_url('/users/profile/' . $post['username']) ?>" class="text-blue-600 hover:text-blue-800 font-semibold">
                                <?= $post['username'] ?>
                            </a>
                        </div>
                        <small class="text-gray-500"><?= date('M d, Y H:i', strtotime($post['created_at'])) ?></small>
                    </div>
                </div>
                <div class="p-4">
                    <p class="post-content"><?= nl2br($post['content']) ?></p>
                    <?php if ($post['image_url']): ?>
                        <img src="<?= base_url('writable/uploads/' . $post['image_url']) ?>" class="w-full rounded mt-4" alt="Post image">
                    <?php endif; ?>
                </div>
                <div class="border-t border-gray-200 p-4">
                    <div class="flex gap-3 flex-wrap">
                        <button class="like-btn px-4 py-2 text-sm rounded hover:bg-red-50 transition" data-post-id="<?= $post['id'] ?>">
                            ❤️ <span class="like-count"><?= $post['likes_count'] ?></span>
                        </button>
                        <a href="<?= base_url('/posts/view/' . $post['id']) ?>" class="px-4 py-2 text-sm rounded hover:bg-blue-50 transition text-blue-600">
                            💬 <?= $post['comments_count'] ?>
                        </a>
                        <?php if (session()->get('user_id') == $post['user_id'] || session()->get('is_admin')): ?>
                            <a href="<?= base_url('/posts/edit/' . $post['id']) ?>" class="px-4 py-2 text-sm rounded hover:bg-gray-100 transition">Edit</a>
                            <a href="<?= base_url('/posts/delete/' . $post['id']) ?>" class="px-4 py-2 text-sm rounded hover:bg-red-50 transition text-red-600" onclick="return confirm('Delete this post?')">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if (empty($posts)): ?>
            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded text-center">
                <p>No posts yet. Follow some users or create a post to get started!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.querySelectorAll('.like-btn').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        const postId = btn.dataset.postId;
        const response = await fetch('<?= base_url('/posts/like/') ?>' + postId);
        const data = await response.json();
        if (data.success) {
            btn.classList.toggle('bg-red-100');
        }
    });
});
</script>
<?= $this->endSection() ?>

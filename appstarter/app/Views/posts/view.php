<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Post -->
        <div class="bg-white rounded-lg shadow-md mb-6 p-6 post-card">
            <div class="border-b pb-4 mb-4">
                <div class="flex justify-between items-center">
                    <div>
                        <a href="<?= base_url('/users/profile/' . $post['username']) ?>" class="text-blue-600 hover:text-blue-800 font-semibold">
                            <?= $post['username'] ?>
                        </a>
                    </div>
                    <small class="text-gray-500"><?= date('M d, Y H:i', strtotime($post['created_at'])) ?></small>
                </div>
            </div>
            <p class="post-content"><?= nl2br($post['content']) ?></p>
            <?php if ($post['image_url']): ?>
                <img src="<?= base_url('writable/uploads/' . $post['image_url']) ?>" class="w-full rounded my-4" alt="Post image">
            <?php endif; ?>
            <div class="flex gap-2 mt-6">
                <button class="like-btn px-4 py-2 rounded hover:bg-red-50 transition" data-post-id="<?= $post['id'] ?>">
                    ❤️ <span class="like-count"><?= $post['likes_count'] ?></span>
                </button>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="border-b bg-gray-50 p-4">
                <h5 class="font-bold text-lg">Comments</h5>
            </div>
            <div class="p-6">
                <?php if ($user_id): ?>
                    <form method="post" action="<?= base_url('/comments/create') ?>" class="mb-6">
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                        <div class="mb-3">
                            <textarea class="form-textarea" name="content" placeholder="Write a comment..." required></textarea>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm transition">Post Comment</button>
                    </form>
                <?php else: ?>
                    <p class="text-gray-600 mb-4"><a href="<?= base_url('/auth/login') ?>" class="text-blue-600">Login</a> to comment</p>
                <?php endif; ?>

                <!-- Comments List -->
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <div class="flex justify-between items-start">
                            <strong class="comment-author"><?= $comment['username'] ?></strong>
                            <small class="text-gray-500"><?= date('M d, Y H:i', strtotime($comment['created_at'])) ?></small>
                        </div>
                        <p class="comment-text"><?= $comment['content'] ?></p>
                        <div class="flex gap-2 mt-2">
                            <button class="comment-like-btn text-sm px-2 py-1 rounded hover:bg-red-50 transition" data-comment-id="<?= $comment['id'] ?>">
                                ❤️ <span class="like-count"><?= $comment['likes_count'] ?></span>
                            </button>
                            <?php if (session()->get('user_id') == $comment['user_id'] || session()->get('is_admin')): ?>
                                <a href="<?= base_url('/comments/edit/' . $comment['id']) ?>" class="text-sm px-2 py-1 rounded hover:bg-gray-100">Edit</a>
                                <a href="<?= base_url('/comments/delete/' . $comment['id']) ?>" class="text-sm px-2 py-1 rounded hover:bg-red-50 text-red-600" onclick="return confirm('Delete?')">Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
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

document.querySelectorAll('.comment-like-btn').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        const commentId = btn.dataset.commentId;
        const response = await fetch('<?= base_url('/comments/like/') ?>' + commentId);
        const data = await response.json();
        if (data.success) {
            btn.classList.toggle('bg-red-100');
        }
    });
});
</script>
<?= $this->endSection() ?>

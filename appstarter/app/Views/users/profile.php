<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 text-center profile-card">
                <?php if ($user['profile_pic']): ?>
                    <img src="<?= base_url($user['profile_pic']) ?>" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover" alt="Profile Picture">
                <?php else: ?>
                    <div class="w-32 h-32 rounded-full mx-auto mb-4 bg-gray-300 flex items-center justify-center">
                        <span class="text-2xl text-gray-600"><?= strtoupper(substr($user['first_name'], 0, 1)) ?><?= strtoupper(substr($user['last_name'], 0, 1)) ?></span>
                    </div>
                <?php endif; ?>
                <h4 class="text-2xl font-bold"><?= $user['first_name'] ?> <?= $user['last_name'] ?></h4>
                <p class="text-gray-600">@<?= $user['username'] ?></p>
                <p class="text-sm text-gray-500 mt-1">
                    Born: <?= date('M d, Y', strtotime($user['dob'])) ?> | <?= $user['sex'] ?>
                </p>
                <?php if ($user['bio']): ?>
                    <p class="text-gray-700 mt-3"><?= nl2br($user['bio']) ?></p>
                <?php endif; ?>
                
                <div class="grid grid-cols-3 gap-4 mt-6 profile-stats">
                    <div class="stat">
                        <h5 class="stat-number"><?= $followers ?></h5>
                        <small class="stat-label">Followers</small>
                    </div>
                    <div class="stat">
                        <h5 class="stat-number"><?= $following ?></h5>
                        <small class="stat-label">Following</small>
                    </div>
                    <div class="stat">
                        <h5 class="stat-number"><?= count($posts) ?></h5>
                        <small class="stat-label">Posts</small>
                    </div>
                </div>

                <div class="mt-6 space-y-2">
                    <?php if (session()->get('user_id') == $user['id']): ?>
                        <a href="<?= base_url('/users/edit') ?>" class="block bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Edit Profile</a>
                    <?php elseif (session()->get('user_id')): ?>
                        <button class="block w-full follow-btn bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition" data-user-id="<?= $user['id'] ?>" data-following="<?= $isFollowing ? '1' : '0' ?>">
                            <?= $isFollowing ? 'Unfollow' : 'Follow' ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow mt-4 p-4">
                <a href="<?= base_url('/users/followers/' . $user['username']) ?>" class="block text-blue-600 hover:text-blue-800 mb-2">👥 Followers</a>
                <a href="<?= base_url('/users/following/' . $user['username']) ?>" class="block text-blue-600 hover:text-blue-800">➜ Following</a>
            </div>
        </div>

        <!-- Posts Section -->
        <div class="md:col-span-2">
            <h5 class="text-2xl font-bold mb-4">Posts</h5>
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="bg-white rounded-lg shadow-md mb-4 p-4 post-card">
                        <p class="post-content"><?= nl2br($post['content']) ?></p>
                        <?php if ($post['image_url']): ?>
                            <img src="<?= base_url('writable/uploads/' . $post['image_url']) ?>" class="w-full rounded mt-3 max-h-64 object-cover" alt="Post image">
                        <?php endif; ?>
                        <div class="flex gap-2 mt-4">
                            <a href="<?= base_url('/posts/view/' . $post['id']) ?>" class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm transition">View</a>
                            <?php if (session()->get('user_id') == $user['id']): ?>
                                <a href="<?= base_url('/posts/edit/' . $post['id']) ?>" class="px-4 py-1 bg-gray-400 text-white rounded hover:bg-gray-500 text-sm transition">Edit</a>
                                <a href="<?= base_url('/posts/delete/' . $post['id']) ?>" class="px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm transition" onclick="return confirm('Delete?')">Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded">No posts yet.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.follow-btn').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        const userId = btn.dataset.userId;
        const response = await fetch('<?= base_url('/users/follow/') ?>' + userId, { method: 'POST' });
        const data = await response.json();
        if (data.success) {
            btn.textContent = data.following ? 'Unfollow' : 'Follow';
            btn.classList.toggle('bg-blue-600');
            btn.classList.toggle('bg-gray-400');
        }
    });
});
</script>
<?= $this->endSection() ?>

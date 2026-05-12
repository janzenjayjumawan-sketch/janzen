<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Manage Posts</h3>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Author</th>
                    <th>Content</th>
                    <th>Likes</th>
                    <th>Comments</th>
                    <th>Posted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?= $post['username'] ?></td>
                        <td><?= substr($post['content'], 0, 50) ?>...</td>
                        <td><?= $post['likes_count'] ?></td>
                        <td><?= $post['comments_count'] ?></td>
                        <td><?= date('M d, Y', strtotime($post['created_at'])) ?></td>
                        <td>
                            <button class="btn btn-sm btn-danger delete-post" data-post-id="<?= $post['id'] ?>" onclick="return confirm('Delete post?')">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.querySelectorAll('.delete-post').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        const postId = btn.dataset.postId;
        const response = await fetch('<?= base_url('/admin/delete-post/') ?>' + postId, { method: 'POST' });
        const data = await response.json();
        if (data.success) {
            location.reload();
        }
    });
});
</script>
<?= $this->endSection() ?>

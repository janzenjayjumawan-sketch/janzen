<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 mt-4">
    <h3 class="text-2xl font-bold mb-4">Manage Users</h3>
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $user['username'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $user['email'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="<?= $user['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?> px-2 py-1 rounded-full text-xs font-medium">
                                <?= $user['is_active'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="bg-yellow-500 hover:bg-yellow-700 text-white text-xs py-1 px-2 rounded toggle-status" data-user-id="<?= $user['id'] ?>">
                                <?= $user['is_active'] ? 'Deactivate' : 'Activate' ?>
                            </button>
                            <button class="bg-red-500 hover:bg-red-700 text-white text-xs py-1 px-2 rounded ml-2 delete-user" data-user-id="<?= $user['id'] ?>" onclick="return confirm('Delete user?')">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.querySelectorAll('.toggle-status').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        const userId = btn.dataset.userId;
        const response = await fetch('<?= base_url('/admin/toggle-status/') ?>' + userId, { method: 'POST' });
        const data = await response.json();
        if (data.success) {
            location.reload();
        }
    });
});

document.querySelectorAll('.delete-user').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        const userId = btn.dataset.userId;
        const response = await fetch('<?= base_url('/admin/delete-user/') ?>' + userId, { method: 'POST' });
        const data = await response.json();
        if (data.success) {
            location.reload();
        }
    });
});
</script>
<?= $this->endSection() ?>

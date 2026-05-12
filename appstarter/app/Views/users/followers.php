<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 mt-4">
    <div class="flex">
        <div class="w-full md:w-2/3">
            <h4 class="text-xl font-semibold mb-4"><?= $user['username'] ?>'s Followers</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php foreach ($followers as $follower): ?>
                    <div class="bg-white shadow-md rounded-lg">
                        <div class="p-4 text-center">
                            <a href="<?= base_url('/users/profile/' . $follower['username']) ?>" class="no-underline text-gray-900 hover:text-blue-500">
                                <h6 class="text-lg font-medium"><?= $follower['username'] ?></h6>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

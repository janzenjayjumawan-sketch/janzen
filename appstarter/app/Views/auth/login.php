<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 mt-5">
    <div class="flex justify-center">
        <div class="w-full md:w-1/2">
            <div class="bg-white shadow-md rounded-lg">
                <div class="bg-blue-600 text-white p-4 rounded-t-lg">
                    <h3 class="mb-0">Login</h3>
                </div>
                <div class="p-4">
                    <?php if (isset($error)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <?php if (is_array($error)): ?>
                                <?php foreach ($error as $err): ?>
                                    <p><?= $err ?></p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <?= $error ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('/auth/login') ?>">
                        <div class="mb-4">
                            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="username" name="username" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                            <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="password" name="password" required>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">Login</button>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 rounded-b-lg text-center">
                    Don't have an account? <a href="<?= base_url('/auth/register') ?>" class="text-blue-500 hover:text-blue-700">Register here</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-6">Search Users</h2>

    <form action="<?= base_url('/users/search') ?>" method="get" class="mb-8">
        <div class="flex gap-4">
            <input type="search" name="q" placeholder="Search by username, name, or email..."
                   value="<?= esc($query) ?>" required
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Search
            </button>
        </div>
    </form>

    <?php if ($query): ?>
        <h3 class="text-xl font-semibold mb-4">Search Results for "<?= esc($query) ?>"</h3>

        <?php if (empty($users)): ?>
            <div class="text-center py-8">
                <p class="text-gray-600">No users found matching your search.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($users as $user): ?>
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                        <div class="flex items-center space-x-4">
                            <?php if ($user['profile_pic']): ?>
                                <img src="<?= base_url($user['profile_pic']) ?>"
                                     class="w-16 h-16 rounded-full object-cover" alt="Profile Picture">
                            <?php else: ?>
                                <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-lg text-gray-600">
                                        <?= strtoupper(substr($user['first_name'], 0, 1)) ?><?= strtoupper(substr($user['last_name'], 0, 1)) ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <div class="flex-1">
                                <h4 class="text-lg font-semibold">
                                    <a href="<?= base_url('/users/profile/' . $user['username']) ?>"
                                       class="text-blue-600 hover:text-blue-800">
                                        <?= esc($user['first_name']) ?> <?= esc($user['last_name']) ?>
                                    </a>
                                </h4>
                                <p class="text-gray-600">@<?= esc($user['username']) ?></p>
                                <p class="text-sm text-gray-500"><?= esc($user['email']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
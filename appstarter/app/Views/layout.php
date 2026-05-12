<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SocialHub' ?></title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

    <!-- Global JavaScript -->
    <script src="<?= base_url('js/script.js') ?>" defer></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="<?= base_url('/') ?>" class="text-2xl font-bold hover:text-blue-200 transition">
                    SocialHub
                </a>

                <div class="flex items-center gap-6">
                    <?php if (session()->get('user_id')): ?>
                        <!-- Authenticated User Navigation -->
                        <a href="<?= base_url('/posts/feed') ?>" class="hover:text-blue-200 transition">Feed</a>
                        <a href="<?= base_url('/posts/create') ?>" class="hover:text-blue-200 transition">Create</a>
                        <a href="<?= base_url('/users/edit') ?>" class="hover:text-blue-200 transition">Edit Profile</a>

                        <!-- Search Form -->
                        <form action="<?= base_url('/users/search') ?>" method="get" class="flex">
                            <input type="search" name="q" placeholder="Search users..." required
                                   class="px-3 py-1 rounded-l text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300" />
                            <button type="submit" class="bg-blue-500 px-3 py-1 rounded-r hover:bg-blue-600 transition">
                                Search
                            </button>
                        </form>

                        <!-- User Profile Link -->
                        <a href="<?= base_url('/users/profile/' . session()->get('username')) ?>"
                           class="hover:text-blue-200 transition">
                            <?= session()->get('username') ?>
                        </a>

                        <?php if (session()->get('is_admin')): ?>
                            <!-- Admin Link -->
                            <a href="<?= base_url('/admin/dashboard') ?>" class="hover:text-blue-200 transition">
                                Admin
                            </a>
                        <?php endif; ?>

                        <!-- Logout Button -->
                        <a href="<?= base_url('/auth/logout') ?>"
                           class="bg-red-500 px-4 py-1 rounded hover:bg-red-600 transition">
                            Logout
                        </a>
                    <?php else: ?>
                        <!-- Guest Navigation -->
                        <a href="<?= base_url('/auth/login') ?>" class="hover:text-blue-200 transition">Login</a>
                        <a href="<?= base_url('/auth/register') ?>"
                           class="bg-green-500 px-4 py-1 rounded hover:bg-green-600 transition">
                            Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages Container -->
    <div class="max-w-7xl mx-auto px-4 py-4">
        <?php if (session()->getFlashdata('success')): ?>
            <!-- Success Message -->
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?= session()->getFlashdata('success') ?>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                      onclick="this.parentElement.style.display='none';">
                    ×
                </span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <!-- Error Message -->
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?php if (is_array(session()->getFlashdata('error'))): ?>
                    <?php foreach (session()->getFlashdata('error') as $err): ?>
                        <p><?= $err ?></p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?= session()->getFlashdata('error') ?>
                <?php endif; ?>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                      onclick="this.parentElement.style.display='none';">
                    ×
                </span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Main Content Area -->
    <main class="min-h-screen">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Site Footer -->
    <footer class="bg-gray-900 text-white mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2026 SocialHub. All rights reserved.</p>
            <p class="text-sm text-gray-400 mt-2">
                Built with CodeIgniter 4 and Tailwind CSS
            </p>
        </div>
    </footer>

</body>
</html>

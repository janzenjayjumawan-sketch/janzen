<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-4">Welcome to SocialHub</h1>
        <p class="text-xl mb-8">Connect, share, and discover with the world!</p>
        <?php if (!session()->get('user_id')): ?>
            <div class="space-x-4">
                <a href="<?= base_url('/auth/register') ?>" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Get Started</a>
                <a href="<?= base_url('/auth/login') ?>" class="inline-block border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">Login</a>
            </div>
        <?php else: ?>
            <a href="<?= base_url('/posts/feed') ?>" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Go to Feed</a>
        <?php endif; ?>
    </div>
</div>

<?php if (session()->get('user_id')): ?>
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto text-center">
            <h3 class="text-3xl font-bold mb-4">Your Social Hub Awaits</h3>
            <p class="text-gray-600 mb-8">Start sharing your thoughts and connecting with others!</p>
            <div class="space-x-4">
                <a href="<?= base_url('/posts/feed') ?>" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">View Feed</a>
                <a href="<?= base_url('/posts/create') ?>" class="inline-block bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition">Create Post</a>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>

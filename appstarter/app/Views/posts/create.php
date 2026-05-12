<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6">
                <h4 class="text-2xl font-bold">Create New Post</h4>
            </div>
            <div class="p-6">
                <form method="post" action="<?= base_url('/posts/create') ?>" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">What's on your mind?</label>
                        <textarea class="form-textarea" id="content" name="content" placeholder="Share your thoughts..." required></textarea>
                    </div>
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Add Image (Optional)</label>
                        <input type="file" class="form-input" id="image" name="image" accept="image/*">
                    </div>
                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-medium transition">Post</button>
                        <a href="<?= base_url('/posts/feed') ?>" class="flex-1 bg-gray-400 text-white py-2 rounded-lg hover:bg-gray-500 font-medium transition text-center">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

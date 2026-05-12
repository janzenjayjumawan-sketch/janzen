<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 mt-4">
    <h3 class="text-2xl font-bold mb-4">Edit Comment</h3>
    <div class="flex justify-center">
        <div class="w-full md:w-1/2">
            <form method="post" action="<?= base_url('/comments/edit/' . $comment['id']) ?>">
                <div class="mb-4">
                    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Comment</label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="content" name="content" rows="4" required><?= $comment['content'] ?></textarea>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                <a href="<?= base_url('/posts/view/' . $comment['post_id']) ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

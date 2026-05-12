<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 mt-5">
    <div class="flex justify-center">
        <div class="w-full md:w-1/2">
            <div class="bg-white shadow-md rounded-lg">
                <div class="bg-green-600 text-white p-4 rounded-t-lg">
                    <h3 class="mb-0">Register</h3>
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

                    <form method="post" action="<?= base_url('/auth/register') ?>" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-4">
                            <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-4">
                            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" id="username" name="username" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" id="email" name="email" required>
                        </div>
                        <div class="mb-4">
                            <label for="dob" class="block text-gray-700 text-sm font-bold mb-2">Date of Birth</label>
                            <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" id="dob" name="dob" required>
                        </div>
                        <div class="mb-4">
                            <label for="sex" class="block text-gray-700 text-sm font-bold mb-2">Sex</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" id="sex" name="sex" required>
                                <option value="">Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="profile_pic" class="block text-gray-700 text-sm font-bold mb-2">Profile Picture</label>
                            <input type="file" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" id="profile_pic" name="profile_pic" accept="image/*">
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                            <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" id="password" name="password" required>
                        </div>
                        <div class="mb-4">
                            <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                            <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full">Register</button>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 rounded-b-lg text-center">
                    Already have an account? <a href="<?= base_url('/auth/login') ?>" class="text-green-500 hover:text-green-700">Login here</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

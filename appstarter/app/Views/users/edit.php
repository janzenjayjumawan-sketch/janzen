<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6">
                <h4 class="text-2xl font-bold">Edit Profile</h4>
            </div>
            <div class="p-6">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('/users/edit') ?>" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" class="form-input mt-1" id="first_name" name="first_name" value="<?= $user['first_name'] ?>" required>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" class="form-input mt-1" id="last_name" name="last_name" value="<?= $user['last_name'] ?>" required>
                    </div>
                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" class="form-input mt-1" id="dob" name="dob" value="<?= $user['dob'] ?>" required>
                    </div>
                    <div>
                        <label for="sex" class="block text-sm font-medium text-gray-700">Sex</label>
                        <select class="form-input mt-1" id="sex" name="sex" required>
                            <option value="Male" <?= $user['sex'] == 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= $user['sex'] == 'Female' ? 'selected' : '' ?>>Female</option>
                            <option value="Other" <?= $user['sex'] == 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                        <textarea class="form-textarea mt-1" id="bio" name="bio" maxlength="500" data-max-chars="500"><?= $user['bio'] ?? '' ?></textarea>
                    </div>
                    <div>
                        <label for="profile_pic" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                        <input type="file" class="form-input mt-1" id="profile_pic" name="profile_pic" accept="image/*">
                        <?php if ($user['profile_pic']): ?>
                            <div class="mt-2">
                                <img src="<?= base_url($user['profile_pic']) ?>" class="w-16 h-16 rounded-full object-cover" alt="Current Profile Picture">
                                <small class="text-gray-600 block">Leave empty to keep current picture</small>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition font-medium">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

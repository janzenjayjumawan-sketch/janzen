<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\FollowModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $postModel;
    protected $followModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->postModel = new PostModel();
        $this->followModel = new FollowModel();
    }

    public function profile($username)
    {
        $user = $this->userModel->where('username', $username)->first();
        if (!$user) {
            throw new \Exception('User not found');
        }

        $posts = $this->postModel->where('user_id', $user['id'])->findAll();
        $followers = $this->followModel->getFollowersCount($user['id']);
        $following = $this->followModel->getFollowingCount($user['id']);

        $current_user_id = session()->get('user_id');
        $isFollowing = false;
        if ($current_user_id) {
            $isFollowing = $this->followModel->where('follower_id', $current_user_id)
                ->where('following_id', $user['id'])
                ->countAllResults() > 0;
        }

        return view('users/profile', [
            'user' => $user,
            'posts' => $posts,
            'followers' => $followers,
            'following' => $following,
            'isFollowing' => $isFollowing,
        ]);
    }

    public function edit()
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/auth/login');
        }

        $user = $this->userModel->find($user_id);

        if ($this->request->getMethod() === 'post') {
            $first_name = $this->request->getPost('first_name');
            $last_name = $this->request->getPost('last_name');
            $dob = $this->request->getPost('dob');
            $sex = $this->request->getPost('sex');
            $bio = $this->request->getPost('bio');
            $profilePic = $this->request->getFile('profile_pic');

            $profileUrl = $user['profile_pic'];
            if ($profilePic && $profilePic->isValid() && !$profilePic->hasMoved()) {
                // Validate file
                $validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($profilePic->getMimeType(), $validTypes) && $profilePic->getSize() <= 2 * 1024 * 1024) {
                    $newName = $profilePic->getRandomName();
                    $profilePic->move(WRITEPATH . 'uploads/profile_pics', $newName);
                    $profileUrl = 'writable/uploads/profile_pics/' . $newName;
                } else {
                    return view('users/edit', ['user' => $user, 'error' => 'Invalid profile picture. Must be JPEG, PNG, or GIF under 2MB.']);
                }
            }

            $this->userModel->update($user_id, [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'dob' => $dob,
                'sex' => $sex,
                'bio' => $bio,
                'profile_pic' => $profileUrl,
            ]);

            session()->setFlashdata('success', 'Profile updated successfully!');
            return redirect()->to('/users/profile/' . $user['username']);
        }

        return view('users/edit', ['user' => $user]);
    }

    public function follow($user_id)
    {
        $current_user_id = session()->get('user_id');
        if (!$current_user_id) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not logged in']);
        }

        if ($current_user_id == $user_id) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cannot follow yourself']);
        }

        $isFollowing = $this->followModel->where('follower_id', $current_user_id)
            ->where('following_id', $user_id)
            ->countAllResults() > 0;

        if ($isFollowing) {
            $this->followModel->where('follower_id', $current_user_id)
                ->where('following_id', $user_id)
                ->delete();
        } else {
            $this->followModel->insert([
                'follower_id' => $current_user_id,
                'following_id' => $user_id,
            ]);
        }

        return $this->response->setJSON(['success' => true, 'following' => !$isFollowing]);
    }

    public function followers($username)
    {
        $user = $this->userModel->where('username', $username)->first();
        if (!$user) {
            throw new \Exception('User not found');
        }

        $followers = $this->followModel->getFollowers($user['id']);

        return view('users/followers', ['user' => $user, 'followers' => $followers]);
    }

    public function following($username)
    {
        $user = $this->userModel->where('username', $username)->first();
        if (!$user) {
            throw new \Exception('User not found');
        }

        $following = $this->followModel->getFollowing($user['id']);

        return view('users/following', ['user' => $user, 'following' => $following]);
    }

    public function search()
    {
        $query = $this->request->getGet('q');
        $users = [];

        if ($query) {
            $users = $this->userModel->like('username', $query)
                ->orLike('first_name', $query)
                ->orLike('last_name', $query)
                ->orLike('email', $query)
                ->findAll(20); // Limit to 20 results
        }

        return view('users/search', ['users' => $users, 'query' => $query]);
    }
}

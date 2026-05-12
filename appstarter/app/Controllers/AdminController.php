<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PostModel;

class AdminController extends BaseController
{
    protected $userModel;
    protected $postModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->postModel = new PostModel();
    }

    public function dashboard()
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/')->with('error', 'Unauthorized');
        }

        $totalUsers = $this->userModel->countAllResults();
        $totalPosts = $this->postModel->countAllResults();
        $allUsers = $this->userModel->findAll(10);
        $allPosts = $this->postModel->getPostsWithAuthor(10);

        return view('admin/dashboard', [
            'totalUsers' => $totalUsers,
            'totalPosts' => $totalPosts,
            'allUsers' => $allUsers,
            'allPosts' => $allPosts,
        ]);
    }

    public function manageUsers()
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/')->with('error', 'Unauthorized');
        }

        $users = $this->userModel->findAll();

        return view('admin/manage_users', ['users' => $users]);
    }

    public function toggleUserStatus($user_id)
    {
        if (!session()->get('is_admin')) {
            return $this->response->setJSON(['success' => false]);
        }

        $user = $this->userModel->find($user_id);
        $this->userModel->update($user_id, ['is_active' => !$user['is_active']]);

        return $this->response->setJSON(['success' => true]);
    }

    public function deleteUser($user_id)
    {
        if (!session()->get('is_admin')) {
            return $this->response->setJSON(['success' => false]);
        }

        $this->userModel->delete($user_id);

        return $this->response->setJSON(['success' => true]);
    }

    public function managePosts()
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/')->with('error', 'Unauthorized');
        }

        $posts = $this->postModel->getPostsWithAuthor(50);

        return view('admin/manage_posts', ['posts' => $posts]);
    }

    public function deletePost($post_id)
    {
        if (!session()->get('is_admin')) {
            return $this->response->setJSON(['success' => false]);
        }

        $this->postModel->delete($post_id);

        return $this->response->setJSON(['success' => true]);
    }
}

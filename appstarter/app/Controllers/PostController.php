<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CommentModel;
use App\Models\LikeModel;
use App\Models\UserModel;

class PostController extends BaseController
{
    protected $postModel;
    protected $commentModel;
    protected $likeModel;
    protected $userModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->commentModel = new CommentModel();
        $this->likeModel = new LikeModel();
        $this->userModel = new UserModel();
    }

    public function feed()
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/auth/login');
        }

        $page = $this->request->getVar('page') ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $posts = $this->postModel->getFeedForUser($user_id, $limit, $offset);

        return view('posts/feed', ['posts' => $posts]);
    }

    public function create()
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() === 'post') {
            $content = $this->request->getPost('content');
            $image = $this->request->getFile('image');

            $imageUrl = null;
            if ($image && $image->isValid()) {
                $imageUrl = $image->getRandomName();
                $image->move(WRITEPATH . 'uploads', $imageUrl);
            }

            $data = [
                'user_id' => $user_id,
                'content' => $content,
                'image_url' => $imageUrl,
            ];

            if ($this->postModel->insert($data)) {
                session()->setFlashdata('success', 'Post created successfully!');
                return redirect()->to('/posts/feed');
            }
        }

        return view('posts/create');
    }

    public function edit($id)
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/auth/login');
        }

        $post = $this->postModel->find($id);
        if (!$post || $post['user_id'] != $user_id) {
            return redirect()->to('/posts/feed')->with('error', 'Unauthorized');
        }

        if ($this->request->getMethod() === 'post') {
            $content = $this->request->getPost('content');
            $this->postModel->update($id, ['content' => $content]);
            session()->setFlashdata('success', 'Post updated successfully!');
            return redirect()->to('/posts/feed');
        }

        return view('posts/edit', ['post' => $post]);
    }

    public function delete($id)
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/auth/login');
        }

        $post = $this->postModel->find($id);
        if (!$post || ($post['user_id'] != $user_id && !session()->get('is_admin'))) {
            return redirect()->to('/posts/feed')->with('error', 'Unauthorized');
        }

        $this->postModel->delete($id);
        session()->setFlashdata('success', 'Post deleted successfully!');
        return redirect()->to('/posts/feed');
    }

    public function view($id)
    {
        $post = $this->postModel->select('posts.*, users.username, users.profile_pic')
            ->join('users', 'users.id = posts.user_id')
            ->find($id);

        if (!$post) {
            throw new \Exception('Post not found');
        }

        $comments = $this->commentModel->getCommentsForPost($id);
        $user_id = session()->get('user_id');

        return view('posts/view', ['post' => $post, 'comments' => $comments, 'user_id' => $user_id]);
    }

    public function like($post_id)
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not logged in']);
        }

        $liked = $this->likeModel->hasUserLikedPost($user_id, $post_id);

        if ($liked) {
            $this->likeModel->where('user_id', $user_id)
                ->where('post_id', $post_id)
                ->delete();
            $this->postModel->update($post_id, ['likes_count' => $this->postModel->find($post_id)['likes_count'] - 1]);
        } else {
            $this->likeModel->insert([
                'user_id' => $user_id,
                'post_id' => $post_id,
            ]);
            $this->postModel->update($post_id, ['likes_count' => $this->postModel->find($post_id)['likes_count'] + 1]);
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function search()
    {
        $keyword = $this->request->getVar('q');
        $results = $this->postModel->searchPosts($keyword, 50);

        return view('posts/search', ['results' => $results, 'keyword' => $keyword]);
    }
}

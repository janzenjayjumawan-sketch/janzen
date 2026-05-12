<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\LikeModel;
use App\Models\PostModel;

class CommentController extends BaseController
{
    protected $commentModel;
    protected $likeModel;
    protected $postModel;

    public function __construct()
    {
        $this->commentModel = new CommentModel();
        $this->likeModel = new LikeModel();
        $this->postModel = new PostModel();
    }

    public function create()
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() === 'post') {
            $post_id = $this->request->getPost('post_id');
            $content = $this->request->getPost('content');

            $data = [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'content' => $content,
            ];

            if ($this->commentModel->insert($data)) {
                $this->postModel->update($post_id, ['comments_count' => $this->postModel->find($post_id)['comments_count'] + 1]);
                return redirect()->to('/posts/view/' . $post_id);
            }
        }

        return redirect()->back();
    }

    public function edit($id)
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/auth/login');
        }

        $comment = $this->commentModel->find($id);
        if (!$comment || $comment['user_id'] != $user_id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        if ($this->request->getMethod() === 'post') {
            $content = $this->request->getPost('content');
            $this->commentModel->update($id, ['content' => $content]);
            return redirect()->to('/posts/view/' . $comment['post_id']);
        }

        return view('comments/edit', ['comment' => $comment]);
    }

    public function delete($id)
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/auth/login');
        }

        $comment = $this->commentModel->find($id);
        if (!$comment || ($comment['user_id'] != $user_id && !session()->get('is_admin'))) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $post_id = $comment['post_id'];
        $this->commentModel->delete($id);
        $this->postModel->update($post_id, ['comments_count' => $this->postModel->find($post_id)['comments_count'] - 1]);

        return redirect()->to('/posts/view/' . $post_id);
    }

    public function like($comment_id)
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return $this->response->setJSON(['success' => false]);
        }

        $liked = $this->likeModel->hasUserLikedComment($user_id, $comment_id);

        if ($liked) {
            $this->likeModel->where('user_id', $user_id)
                ->where('comment_id', $comment_id)
                ->delete();
            $this->commentModel->update($comment_id, ['likes_count' => $this->commentModel->find($comment_id)['likes_count'] - 1]);
        } else {
            $this->likeModel->insert([
                'user_id' => $user_id,
                'comment_id' => $comment_id,
            ]);
            $this->commentModel->update($comment_id, ['likes_count' => $this->commentModel->find($comment_id)['likes_count'] + 1]);
        }

        return $this->response->setJSON(['success' => true]);
    }
}

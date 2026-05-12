<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['user_id', 'content', 'image_url', 'likes_count', 'comments_count'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'content' => 'required|min_length[1]|max_length[5000]',
    ];

    public function getPostsWithAuthor($limit = 20, $offset = 0)
    {
        return $this->select('posts.*, users.username, users.profile_pic, users.id as user_id')
            ->join('users', 'users.id = posts.user_id')
            ->orderBy('posts.created_at', 'DESC')
            ->limit($limit, $offset)
            ->findAll();
    }

    public function getFeedForUser($user_id, $limit = 20, $offset = 0)
    {
        return $this->select('posts.*, users.username, users.profile_pic, users.id as author_id')
            ->join('users', 'users.id = posts.user_id')
            ->join('follows', 'follows.following_id = posts.user_id OR posts.user_id = ' . $user_id, 'left')
            ->where('posts.user_id', $user_id)
            ->orWhere('follows.follower_id', $user_id)
            ->distinct()
            ->orderBy('posts.created_at', 'DESC')
            ->limit($limit, $offset)
            ->findAll();
    }

    public function searchPosts($keyword, $limit = 20)
    {
        return $this->select('posts.*, users.username, users.profile_pic')
            ->join('users', 'users.id = posts.user_id')
            ->like('posts.content', $keyword)
            ->orderBy('posts.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}

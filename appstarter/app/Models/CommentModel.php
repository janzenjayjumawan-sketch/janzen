<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['post_id', 'user_id', 'content', 'likes_count'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'content' => 'required|min_length[1]|max_length[1000]',
    ];

    public function getCommentsForPost($post_id, $limit = 50)
    {
        return $this->select('comments.*, users.username, users.profile_pic')
            ->join('users', 'users.id = comments.user_id')
            ->where('comments.post_id', $post_id)
            ->orderBy('comments.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}

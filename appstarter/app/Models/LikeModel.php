<?php

namespace App\Models;

use CodeIgniter\Model;

class LikeModel extends Model
{
    protected $table = 'likes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['user_id', 'post_id', 'comment_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    public function hasUserLikedPost($user_id, $post_id)
    {
        return $this->where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->where('comment_id', null)
            ->countAllResults() > 0;
    }

    public function hasUserLikedComment($user_id, $comment_id)
    {
        return $this->where('user_id', $user_id)
            ->where('comment_id', $comment_id)
            ->countAllResults() > 0;
    }
}

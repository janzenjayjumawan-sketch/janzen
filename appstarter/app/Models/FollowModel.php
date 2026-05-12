<?php

namespace App\Models;

use CodeIgniter\Model;

class FollowModel extends Model
{
    protected $table = 'follows';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['follower_id', 'following_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    public function getFollowers($user_id)
    {
        return $this->select('users.*')
            ->join('users', 'users.id = follows.follower_id')
            ->where('follows.following_id', $user_id)
            ->findAll();
    }

    public function getFollowing($user_id)
    {
        return $this->select('users.*')
            ->join('users', 'users.id = follows.following_id')
            ->where('follows.follower_id', $user_id)
            ->findAll();
    }

    public function getFollowersCount($user_id)
    {
        return $this->where('following_id', $user_id)->countAllResults();
    }

    public function getFollowingCount($user_id)
    {
        return $this->where('follower_id', $user_id)->countAllResults();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['username', 'first_name', 'last_name', 'email', 'password', 'dob', 'sex', 'bio', 'profile_pic', 'is_admin', 'is_active'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $skipValidation = false;
    protected $validationRules = [
        'username' => 'required|alpha_numeric|min_length[3]|max_length[50]|is_unique[users.username]',
        'first_name' => 'required|alpha_space|min_length[1]|max_length[100]',
        'last_name' => 'required|alpha_space|min_length[1]|max_length[100]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'dob' => 'required|valid_date[Y-m-d]',
        'sex' => 'required|in_list[Male,Female,Other]',
        'bio' => 'permit_empty|max_length[500]',
        'profile_pic' => 'permit_empty|max_length[255]',
    ];

    public function getUsersWithFollowCount($limit = 10)
    {
        $db = \Config\Database::connect();
        return $this->select('users.*, 
            (SELECT COUNT(*) FROM follows WHERE following_id = users.id) as followers_count,
            (SELECT COUNT(*) FROM follows WHERE follower_id = users.id) as following_count')
            ->limit($limit)
            ->findAll();
    }

    public function isFollowing($follower_id, $following_id)
    {
        $db = \Config\Database::connect();
        return $db->table('follows')
            ->where('follower_id', $follower_id)
            ->where('following_id', $following_id)
            ->countAllResults() > 0;
    }
}

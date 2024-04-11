<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model {
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'body', 'user_id', 'image_name', 'updated_at'];
    protected $useTimestamps = true;

    public function getPostsWithUsers() {
        return $this->select('posts.*, users.name as user_name')
            ->join('users', 'users.id = posts.user_id')
            ->orderBy('posts.created_at', 'DESC')
            ->findAll();
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model {
    // Database table name
    protected $table = 'posts';

    // Primary key of the table
    protected $primaryKey = 'id';

    // Fields that are allowed to be filled
    protected $allowedFields = ['title', 'body', 'user_id', 'image_name', 'updated_at'];

    // Enable timestamps for created_at and updated_at fields
    protected $useTimestamps = true;

    // Method to retrieve posts with associated user names
    public function getPostsWithUsers() {
        // Select posts along with the name of the user who created each post
        return $this->select('posts.*, users.name as user_name')
            ->join('users', 'users.id = posts.user_id') // Join users table to fetch user names
            ->orderBy('posts.created_at', 'DESC') // Order posts by creation date in descending order
            ->findAll(); // Fetch all the posts
    }
}
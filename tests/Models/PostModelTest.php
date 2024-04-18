<?php namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model {
    protected $table = 'posts'; // Correct table name
    protected $primaryKey = 'id'; // Primary key of the table
    protected $allowedFields = ['title', 'body', 'user_id', 'created_at', 'image_name', 'updated_at']; // Fields that are fillable
    protected $returnType = 'array'; // Type of return values (can also be 'object')
    protected $useTimestamps = true; // Automatically handle timestamps if true
    protected $createdField  = 'created_at'; // Field for created time
    protected $updatedField  = 'updated_at'; // Field for updated time
    protected $validationRules = []; // Validation rules if any

    protected $DBGroup;

    public function __construct()
    {
        if (getenv('CI_ENVIRONMENT') === 'testing') {
            $this->DBGroup = 'tests';
        } else {
            $this->DBGroup = 'default'; // or any other group as per your configuration
        }

        parent::__construct();
    }

    // Method to get posts along with user info
    public function getPostsWithUsers() {
        $builder = $this->db->table($this->table);
        $builder->select('posts.*, users.name as user_name');
        $builder->join('users', 'users.id = posts.user_id');
        return $builder->get()->getResultArray();
    }
}
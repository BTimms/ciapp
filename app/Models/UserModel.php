<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
    // Database table name
    protected $table = 'users';

    // Fields that are allowed to be filled
    protected $allowedFields = ['name', 'email', 'password', 'updated_at'];

    // Callback method to hash password before insertion
    protected $beforeInsert = ['beforeInsert'];

    // Callback method to hash password before update
    protected $beforeUpdate = ['beforeUpdate'];

    // Method to hash password before insertion
    protected function beforeInsert(array $data){
        $data = $this->passwordHash($data);
        //$data['data']['created_at'] = date('d m Y H:i:s'); // Optionally add created_at timestamp

        return $data;
    }

    // Method to hash password before update
    protected function beforeUpdate(array $data){
        $data = $this->passwordHash($data);
        $data['data']['updated_at'] = date('Y-m-d H:i:s'); // Update updated_at timestamp
        return $data;
    }

    // Method to hash password
    protected function passwordHash(array $data){
        if(isset($data['data']['password']))
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }
}

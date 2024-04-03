<?php namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';

    public function getPosts($slug = null){
        if(!$slug){
            return $this->findAll();
        }
        return $this->asArray()
                    ->where(['slug'=>$slug])
                    ->first();
    }
}
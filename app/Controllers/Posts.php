<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PostModel;

class Posts extends Controller
{
    public function post(){
        $model = new PostModel();
        $data['posts'] =$model->getPosts();
        return view('posts/post',$data);

    }
    // Additional methods for other pages can be added here
}

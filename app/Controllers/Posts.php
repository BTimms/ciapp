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
    public function create(){
        helper('form');
        $model = new PostModel();

        if(! $this->validate([
            'title' => 'required',
            'body' =>'required'
        ])){
            return view('posts/create');
        }else{
            $model->save(
                [
                    'title' => $this->request->getVar('title'),
                    'body' => $this->request->getVar('body'),
                     'slug' => url_title($this->request->getVar('title'))
                ]
            );
            return redirect()->to('/posts');
        }
    }
    // Additional methods for other pages can be added here
}

<?php

// app/Controllers/PostsController.php
namespace App\Controllers;

use App\Models\PostModel;

class PostsController extends BaseController
{
    // Assume $user_id is set to the logged-in user's ID
    private $user_id;

    public function __construct()
    {
        // Ensure you have session started and user logged in
        $session = session();
        $this->user_id = $session->get('user_id');
    }

    public function index()
    {
        $postModel = new PostModel();
        $data['posts'] = $postModel->getPostsWithUsers(); // Ensure this method returns the correct data

        return view('posts/index', $data);
    }


    public function edit($id)
    {
        $model = new PostModel();
        $post = $model->find($id);

        if (!$post || $post['user_id'] != session()->get('id')) {
            return redirect()->to('/posts')->with('error', 'Unauthorized access or post not found');
        }

        return view('posts/edit', ['post' => $post]);
    }

    public function delete($id)
    {
        $postModel = new PostModel();
        $post = $postModel->find($id);

        if (!$post || $post['user_id'] != session()->get('id')) {
            return redirect()->to('/posts')->with('error', 'Unauthorized access to delete the post');
        }

        if ($postModel->delete($id)) {
            return redirect()->to('/posts')->with('message', 'Post deleted successfully');
        } else {
            return redirect()->to('/posts')->with('error', 'Could not delete the post');
        }
    }

    // Other controller methods...
    public function create()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Continue with create post logic
        return view('posts/create');
    }

    public function store()
    {
        helper(['form', 'url']);
        $model = new PostModel();

        // Basic validation
        if (!$this->validate([
            'title' => 'required|min_length[3]',
            'body' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'body' => $this->request->getPost('body'),
            'user_id' => session()->get('id'),
        ];

        // Handle image upload
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getName();
            if ($file->move('assets/images/', $imageName)) {
                $data['image_name'] = $imageName;
            } else {
                log_message('error', 'Image upload failed. Error: ' . $file->getErrorString());
                // Handle error in file upload
                return redirect()->back()->withInput()->with('error', 'Could not upload image.');
            }
        }
        log_message('info', 'Data to be saved: ' . print_r($data, true));
        if ($model->save($data)) {
            return redirect()->to('/posts')->with('message', 'Post created successfully.');
        } else {
            log_message('error', 'Post saving failed. Errors: ' . print_r($model->errors(), true));
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
    }


    public function show($id)
    {
        $postModel = new PostModel();
        $post = $postModel
            ->select('posts.*, users.name as user_name')
            ->join('users', 'users.id = posts.user_id')
            ->where('posts.id', $id)
            ->first();

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Post not found');
        }

        return view('posts/show', ['post' => $post]);
    }

    public function update($id)
    {
        $postModel = new PostModel();
        $post = $postModel->find($id);

        // Basic validation
        $data = [
            'title' => $this->request->getPost('title'),
            'body' => $this->request->getPost('body'),
            // Keep the existing image name unless a new image is uploaded
            'image_name' => $post['image_name'],
        ];

        // Handle new image upload
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            // Use the original file name instead of a random name
            $imageName = $file->getName();
            if ($file->move('assets/images/', $imageName)) {
                // Update the image name in the data array only if a new image is uploaded
                $data['image_name'] = $imageName;
            } else {
                // Handle error in file upload
                return redirect()->back()->withInput()->with('error', 'Could not upload image.');
            }
        }

        if ($postModel->update($id, $data)) {
            return redirect()->to('/posts')->with('message', 'Post updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $postModel->errors());
        }
    }
}

<?php

// app/Controllers/PostsController.php
namespace App\Controllers;

use App\Models\PostModel;

class PostsController extends BaseController
{
    // Private variable to store the user's ID
    private $user_id;

    // Constructor to initialize the user's ID from session
    public function __construct() {
        // Ensure session is started and user is logged in
        $session = session();
        $this->user_id = $session->get('user_id');
    }

    // Method for displaying all posts
    public function index()
    {
        $postModel = new PostModel();
        // Retrieve posts along with their associated users
        $data['posts'] = $postModel->getPostsWithUsers();

        return view('posts/index', $data);
    }

    // Method for displaying the edit form for a post
    public function edit($id)
    {
        $model = new PostModel();
        $post = $model->find($id);

        // Check if post exists and user is authorized to edit it
        if (!$post || $post['user_id'] != session()->get('id')) {
            return redirect()->to('/posts')->with('error', 'Unauthorized access or post not found');
        }

        return view('posts/edit', ['post' => $post]);
    }

    // Method for deleting a post
    public function delete($id)
    {
        $postModel = new PostModel();
        $post = $postModel->find($id);

        // Check if post exists and user is authorized to delete it
        if (!$post || $post['user_id'] != session()->get('id')) {
            return redirect()->to('/posts')->with('error', 'Unauthorized access to delete the post');
        }

        // Attempt to delete the post
        if ($postModel->delete($id)) {
            return redirect()->to('/posts')->with('message', 'Post deleted successfully');
        } else {
            return redirect()->to('/posts')->with('error', 'Could not delete the post');
        }
    }

    // Method for displaying the form to create a new post
    public function create()
    {
        // Redirect to login page if user is not logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return view('posts/create');
    }

    // Method for storing a newly created post
    public function store()
    {
        helper(['form', 'url']);
        $model = new PostModel();

        // Basic validation for post data
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
                // Handle error in file upload
                return redirect()->back()->withInput()->with('error', 'Could not upload image.');
            }
        }

        // Save the post data
        if ($model->save($data)) {
            return redirect()->to('/posts')->with('message', 'Post created successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
    }

    // Method for displaying a single post
    public function show($id)
    {
        $postModel = new PostModel();
        $post = $postModel
            ->select('posts.*, users.name as user_name')
            ->join('users', 'users.id = posts.user_id')
            ->where('posts.id', $id)
            ->first();

        // If post not found, throw a 404 error
        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Post not found');
        }

        return view('posts/show', ['post' => $post]);
    }

    // Method for updating a post
    public function update($id)
    {
        $postModel = new PostModel();
        $post = $postModel->find($id);

        // Basic validation for post data
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

        // Attempt to update the post
        if ($postModel->update($id, $data)) {
            return redirect()->to('/posts')->with('message', 'Post updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $postModel->errors());
        }
    }

    // Method for displaying the dashboard with user's posts
    public function dashboard()
    {
        $postModel = new PostModel();
        $data['posts'] = $postModel
            ->select('posts.*, users.name as user_name')
            ->join('users', 'posts.user_id = users.id')
            ->where('posts.user_id', session()->get('id'))
            ->orderBy('posts.created_at', 'DESC')
            ->findAll();

        return view('posts/dashboard', $data);
    }
}
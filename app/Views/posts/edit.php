<?= $this->extend('layouts/template') ?>

<?php
/**
 * @var array $post The post data
 */
?>

<?= $this->section('content') ?>
    <div class="container">
        <a href="<?= site_url('posts') ?>" class="btn btn-primary mb-3"><-Back to Posts</a>
        <h1>Edit Post</h1>
        <form action="<?= site_url('posts/update/' . $post['id']) ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" value="<?= esc($post['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                <textarea class="form-control" name="body" id="body" required><?= esc($post['body']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" name="image" id="image">
                <small>Current Image: <?= esc($post['image_name']) ?></small>
                <img src="/assets/images/<?= esc($post['image_name']) ?>" alt="Current Image" style="width: 100px;">
            </div>

            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>
    <br>
<?= $this->endSection() ?>
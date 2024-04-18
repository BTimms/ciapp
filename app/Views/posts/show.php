<?= $this->extend('layouts/template') ?>

<?php
/**
 * @var array $post The post data
 */
?>

<?= $this->section('content') ?>
    <div class="container">
        <a href="<?= site_url('posts') ?>" class="btn btn-primary mb-3"><-- Back to Posts</a>
        <div class="row">
            <div class="col-md-12">
                <h1><?= esc($post['title']) ?></h1>
                <img src="/assets/images/<?= esc($post['image_name']) ?>" alt="<?= esc($post['title']) ?>" class="img-fluid"><br><br>
                <p>Posted on <?= date('d M Y', strtotime($post['created_at'])) ?> by <?= esc($post['user_name']) ?></p>
                <p><?= esc($post['body']) ?></p>                

                <?php if (session()->get('id') == $post['user_id']): ?>
                    <a href="<?= site_url('posts/edit/' . $post['id']) ?>" class="btn btn-primary">Edit</a>
                    <a href="<?= site_url('posts/delete/' . $post['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <br>
<?= $this->endSection() ?>
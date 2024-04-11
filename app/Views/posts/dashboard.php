<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
    <div class="container">
        <a href="<?= site_url('posts') ?>" class="btn btn-primary mb-3"><-Back to Posts</a>
        <h1>Dashboard</h1>
        <?php if (!empty($posts)): ?>
            <div class="list-group">
                <?php foreach ($posts as $post): ?>
                    <div class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <div>
                                <h5 class="mb-1"><?= esc($post['title']) ?></h5>
                                <p class="mb-1"><?= esc(substr($post['body'], 0, 100)) ?>...</p>
                                <small>Posted on <?= date('d M Y', strtotime($post['created_at'])) ?> by <?= esc($post['user_name']) ?></small>
                            </div>
                            <small class="text-muted">
                                <a href="<?= site_url('posts/edit/' . $post['id']) ?>" class="btn btn-primary">Edit</a>
                                <a href="<?= site_url('posts/delete/' . $post['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>
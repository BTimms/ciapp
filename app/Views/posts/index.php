<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<style>
    .post-image img {
        max-width: 300px; /* width can be adjusted here */
        max-height: 300px; /* height can be adjusted here */
        width: auto;
        height: auto;
    }
</style>

<div class="jumbotron text-center">
    <h1>Welcome To SportPost</h1>
</div>

<div class="container">
    <h1>Latest Posts</h1>
    <hr>
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="row mb-3">
                <div class="col-md-4 post-image">
                    <img src="/assets/images/<?= esc($post['image_name']) ?>" alt="<?= esc($post['title']) ?>" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <h2><a href="<?= site_url('posts/show/' . $post['id']) ?>"><?= esc($post['title']) ?></a></h2>
                    <p>Posted on <?= date('d M Y', strtotime($post['created_at'])) ?> by <?= esc($post['user_name']) ?></p>
                    <p><?= esc((strlen($post['body']) > 200) ? substr($post['body'], 0, 200) . '...' : $post['body']) ?></p>
                    <?php if (strlen($post['body']) > 200): ?>
                        <a href="<?= site_url('posts/' . $post['id']) ?>" class="btn btn-primary">Read more</a>
                    <?php endif; ?>
                </div>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No posts found.</p>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>


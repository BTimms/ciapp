<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<div class="jumbotron text-center" >
    <h1>Welcome to SportPost</h1>
</div>
    <h1>Latest Posts</h1>

<section class="blog-section">
    <div class="container">
        <?php if ($posts): ?>
            <?php foreach ($posts as $post): ?>
                <h3><?= $post['title'] ?></h3>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No Posts Found</p>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>



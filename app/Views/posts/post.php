<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<div class="jumbotron text-center" >
    <h1>Welcome to SportPost</h1>
</div>
    <h1>Latest Posts</h1>
        <?php if (count($posts)> 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="jumbotron" style="position: relative; padding-right: 50px;">
                <h3><?= $post['title'] ?></h3>
                <small>Posted on <?php echo $post['created_at']?></small><br>
                <?php echo $post['body']?>
                    <p style="position: absolute; bottom: 0; right: 10px;">
                    <a class="btn btn-primary" href="<?php echo site_url('/posts/'.$post['slug']);?>">Read more--></a>
                </p>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No Posts Found</p>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>



<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <a href="<?= site_url('posts') ?>" class="btn btn-primary mb-3"><-Back to Posts</a>
    <h1>Create Post</h1>
    <hr>
    <form action="<?= site_url('posts/store') ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea class="form-control" name="body" id="body" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>
        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
    <br>
</div>
<?= $this->endSection() ?>


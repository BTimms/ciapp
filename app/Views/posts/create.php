<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<div class="container">
    <form class="" action="/posts/create" method="post">
        <div class="form-group">
            <label for="title"><strong>Title</strong></label>
            <input type="text" class="form-control" name="title" id="title" value="">
        </div>
        <div class="form-group">
            <label for="body"><strong>Content</strong></label>
            <textarea class="form-control" name="body" id="body"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
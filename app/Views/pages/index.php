<!-- app/Views/pages/index.php -->
<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="jumbotron text-center" >
    <h1>Welcome to SportPost</h1>
    <h2>Dedicated to Uncovering the</h2>
    <h2>Heart and Soul of Sports</h2>
    <p>Stories, Insights and Analysis Beyond the Game</p>
    <!-- Hero section with Login and Register button -->
    <a href="/login" class="btn btn-primary">Login</a>
    <a href="/register" class="btn btn-primary">Register</a>
</div>
<?= $this->endSection() ?>

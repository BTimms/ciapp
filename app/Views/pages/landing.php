<!-- app/Views/pages/landing.php -->
<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="jumbotron text-center">
    <h1>Welcome To SportPost</h1>
    <h2>Dedicated to Uncovering the Heart and Soul of Sports</h2>
    <p>Stories, Insights and Analysis Beyond the Game</p>
    <a class="btn btn-primary btn-lg" href="<?= site_url('/login') ?>" role="button">Login</a>
    <a class="btn btn-primary btn-lg" href="<?= site_url('/register') ?>" role="button">Register</a>
</div>
<?= $this->endSection() ?>



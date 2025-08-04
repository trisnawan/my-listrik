<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<section>
    <div class="container py-5">
        <h1 class="mb-4"><?= $title ?></h1>
        <?= showAlert(getAlert()) ?>
        <form class="row" method="post" action="<?= current_url() ?>">
            <div class="col-12 mb-3">
                <label for="email" class="form-label">Alamat email</label>
                <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
            </div>
            <div class="col-12 mb-3">
                <label for="password" class="form-label">Kata sandi</label>
                <input type="password" name="password" class="form-control" placeholder="***" required>
            </div>
            <div class="col-12 mb-3">
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection() ?>
<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<section>
    <div class="container py-5">
        <h1 class="mb-4"><?= $title ?></h1>
        <?= showAlert($alert) ?>
        <form action="<?= current_url() ?>" method="post" class="row">
            <div class="col-12 mb-3">
                <label for="full_name" class="form-label">Nama lengkap</label>
                <input type="text" name="full_name" class="form-control" value="<?= $profile['full_name'] ?>" required>
            </div>
            <div class="col-12 mb-3">
                <label for="email" class="form-label">Alamat email</label>
                <input type="email" name="email" class="form-control" value="<?= $profile['email'] ?>" required>
            </div>
            <div class="col-12 mb-3">
                <label for="password" class="form-label">Ubah kata sandi (kosongkan jika tidak ingin diubah)</label>
                <input type="password" name="password" class="form-control" placeholder="***">
            </div>
            <div class="col-12 mb-3">
                <button type="submit" class="btn btn-primary w-100">Simpan Profile</button>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection() ?>
<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<section>
    <div class="container py-5">
        <div class="row">
            <div class="col-sm-12 col-md-8 mb-4">
                <h1 class="mb-2"><?= getenv('CI_TITLE') ?></h1>
                <p class="mb-4">Website pembayaran listrik pascabayar untuk mempermudah pembayaran tagihan listrik rumah kamu!</p>
                <div class="row">
                    <div class="col-6 mb-3">
                        <a href="<?= base_url('account/login') ?>" class="card shadow-sm h-100 decoration-none bg-primary text-white">
                            <div class="card-body">
                                <h5 class="mb-0">Masuk</h5>
                                <div class="small">Sudah berlangganan dan memiliki akun?</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="<?= base_url('account/register') ?>" class="card shadow-sm h-100 decoration-none bg-primary text-white">
                            <div class="card-body">
                                <h5 class="mb-0">Daftar Sekarang</h5>
                                <div class="small">Memulai berlangganan dan miliki akun!</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md mb-4">
                <img src="<?= base_url('assets/img/home-hero.png') ?>" class="w-100" alt="Banner">
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
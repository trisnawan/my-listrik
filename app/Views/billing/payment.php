<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<section>
    <div class="container py-5">
        <h1 class="mb-4"><?= $title ?></h1>
        <?= showAlert($alert ?? null) ?>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Periode</label>
                        <input type="text" class="form-control" value="<?= $data['month'] ?>/<?= $data['year'] ?>" disabled>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Meter Total</label>
                        <input type="text" class="form-control" value="<?= $data['meter_total'] ?>" disabled>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Total Tagihan</label>
                        <input type="text" class="form-control" value="<?= rupiah($data['amount']) ?>" disabled>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Biaya Admin</label>
                        <input type="text" class="form-control" value="<?= rupiah($data['fee']) ?>" disabled>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Total Bayar</label>
                        <input type="text" class="form-control" value="<?= rupiah($data['total']) ?>" disabled>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Status</label>
                        <input type="text" class="form-control is-<?= $data['state']=='paid' ? 'valid' : 'invalid' ?>" value="<?= strtoupper($data['state']) ?>" disabled>
                    </div>
                    <?php if($data['state']=='unpaid'): ?>
                    <div class="col-12 mb-3">
                        <a href="https://checkout-staging.xendit.co/web/<?= $data['gateway_code'] ?>" class="btn btn-primary w-100">Bayar Sekarang</a>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
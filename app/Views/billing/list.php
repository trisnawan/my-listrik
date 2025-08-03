<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<section>
    <div class="container py-5">
        <h1 class="mb-4"><?= $title ?></h1>
        <?= showAlert($alert ?? null) ?>
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" width="160">Periode</th>
                        <th class="text-center" width="130">Total Daya</th>
                        <th class="text-center" width="200">Total Tagihan</th>
                        <th class="text-center" width="100">Status</th>
                        <th class="text-center" width="100"><i class="bi-gear"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($data): foreach($data as $i => $val): ?>
                    <tr>
                        <td class="text-center align-middle"><?= $val['month'] ?>/<?= $val['year'] ?></td>
                        <td class="text-center align-middle"><?= $val['meter_total'] ?></td>
                        <td class="text-center align-middle"><?= rupiah($val['amount']) ?></td>
                        <td class="text-center align-middle text-<?= $val['state']=='paid' ? 'success' : 'danger' ?>"><?= strtoupper($val['state']) ?></td>
                        <td class="text-end align-middle">
                            <a href="<?= base_url($val['payment_id'] ? 'billing/payment/'.$val['id'] : 'billing/payment_order/'.$val['id']) ?>" class="btn btn-sm btn-primary">Bayar Sekarang</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
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
                        <th class="text-center" width="200">Nomor KWH</th>
                        <th class="text-center">Pelanggan</th>
                        <th class="text-center" width="220">Paket Daya</th>
                        <th class="text-center" width="280"><i class="bi-gear"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($data): foreach($data as $i => $val): ?>
                    <tr>
                        <td class="text-center align-middle text-<?= $val['nomor_kwh'] ? 'dark' : 'warning' ?>"><?= $val['nomor_kwh'] ?? 'Belum dipasang' ?></td>
                        <td class="text-start align-middle">
                            <div><?= $val['full_name'] ?></div>
                            <div class="small"><i class="bi-envelope"></i> <?= $val['email'] ?></div>
                        </td>
                        <td class="text-center align-middle"><?= ($val['rate_title'] ?? '-') ?></td>
                        <td class="text-end align-middle">
                            <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tagihanModal" data-id="<?= $val['id'] ?>">Buat Tagihan</a>
                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $val['id'] ?>" data-nomor="<?= $val['nomor_kwh'] ?>" data-rate="<?= $val['rate_id'] ?>">Ubah</a>
                            <a href="<?= base_url('rates/rate_delete/'.$val['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="<?= current_url() ?>">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Loading...</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="user_id">
                <div class="mb-3">
                    <label for="nomor_kwh" class="form-label">Nomor KWH</label>
                    <input type="text" name="nomor_kwh" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="rate_id" class="form-label">Paket Daya</label>
                    <select name="rate_id" class="form-select" required>
                        <option value="">-- pilih salah satu --</option>
                        <?php foreach($rates as $rate): ?>
                        <option value="<?= $rate['id'] ?>"><?= $rate['title'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    const exampleModal = document.getElementById('exampleModal');
    if (exampleModal) {
        exampleModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nomor = button.getAttribute('data-nomor');
            const rate = button.getAttribute('data-rate');

            exampleModal.querySelector('.modal-title').textContent = 'Ubah pengguna';
            if(id){
                exampleModal.querySelector('.modal-body input[name=user_id]').value = (id);
                exampleModal.querySelector('.modal-body input[name=nomor_kwh]').value = (nomor);
                exampleModal.querySelector('.modal-body select[name=rate_id]').value = (rate);
            }else{
                exampleModal.querySelector('.modal-body input[name=nomor_kwh]').value = ('');
                exampleModal.querySelector('.modal-body select[name=rate_id]').value = ('');
            }
        })
    }
</script>

<div class="modal fade" id="tagihanModal" tabindex="-1" aria-labelledby="tagihanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="<?= base_url('customer/billing') ?>">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tagihanModalLabel">Buat tagihan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="user_id">
                <div class="mb-3">
                    <label for="month" class="form-label">Bulan</label>
                    <select name="month" class="form-select" required>
                        <option value="">-- pilih salah satu --</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Tahun</label>
                    <input type="number" name="year" class="form-control" maxlength="4" required>
                </div>
                <div class="mb-3">
                    <label for="meter_start" class="form-label">Meter awal</label>
                    <input type="number" name="meter_start" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="meter_end" class="form-label">Meter akhir</label>
                    <input type="number" name="meter_end" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    const tagihanModal = document.getElementById('tagihanModal');
    if (tagihanModal) {
        tagihanModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            tagihanModal.querySelector('.modal-body input[name=user_id]').value = (id);
        })
    }
</script>
<?= $this->endSection() ?>
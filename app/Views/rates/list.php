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
                        <th class="text-center" width="60">#</th>
                        <th class="text-center">Daya</th>
                        <th class="text-center" width="320">Harga/KWH</th>
                        <th class="text-center" width="220"><i class="bi-gear"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($data): foreach($data as $i => $val): ?>
                    <tr>
                        <td class="text-center align-middle"><?= $i+1 ?></td>
                        <td class="text-start align-middle"><?= $val['title'] ?></td>
                        <td class="text-center align-middle"><?= rupiah($val['price']) ?></td>
                        <td class="text-end align-middle">
                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $val['id'] ?>" data-title="<?= $val['title'] ?>" data-price="<?= $val['price'] ?>">Ubah</a>
                            <a href="<?= base_url('rates/rate_delete/'.$val['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
        <div class="text-end">
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Buat harga baru</a>
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
                <input type="hidden" name="id">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Daya</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Biaya per KWH</label>
                    <input type="number" name="price" class="form-control" required>
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
            const title = button.getAttribute('data-title');
            const price = button.getAttribute('data-price');

            if(id){
                exampleModal.querySelector('.modal-title').textContent = 'Ubah harga';
                exampleModal.querySelector('.modal-body input[name=id]').value = (id);
                exampleModal.querySelector('.modal-body input[name=title]').value = (title);
                exampleModal.querySelector('.modal-body input[name=price]').value = (price);
            }else{
                exampleModal.querySelector('.modal-title').textContent = 'Tambah harga';
                exampleModal.querySelector('.modal-body input[name=title]').value = ('');
                exampleModal.querySelector('.modal-body input[name=price]').value = ('');
            }
        })
    }
</script>
<?= $this->endSection() ?>
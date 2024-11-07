<?=$this->extend('layouts/base')?>
<?=$this->section('title')?>Perubahan Data Lulusan<?=$this->endSection()?>
<?=$this->section('content')?>
<div class="container-fluid p-0">

    <div class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <h1 class="h3 d-inline align-middle">Perubahan Data Lulusan</h1>
            </div>
            <div class="col-md-6 text-end">
                <button id="downloadSelected" class="btn btn-primary" disabled>Download Selected</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <?=$this->include('alerts/success');?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th> <!-- Checkbox untuk memilih semua -->
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NPM</th>
                                    <th>Prodi</th>
                                    <th>Terakhir Di Update</th>
                                    <th>Status pengajuan</th>
                                    <th>Jenis Pengajuan</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;?>
                                <?php foreach ($pdl as $value): ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select-item" value="<?=esc($value->id_pdl);?>">
                                        <!-- Checkbox untuk setiap baris -->
                                    </td>
                                    <td><?=esc($no++);?></td>
                                    <td><?=esc($value->nama);?></td>
                                    <td><?=esc($value->npm);?></td>
                                    <td><?=esc($value->prodi);?></td>
                                    <td><?=($value->terakhir_update == '0000-00-00' || $value->terakhir_update == null) ? 'Belum di update' : esc($value->terakhir_update);?>
                                    </td>
                                    <td><?=esc($value->status_pengajuan);?></td>
                                    <td><?=esc($value->jenis_pengajuan);?></td>
                                    <td><?=esc($value->keterangan);?></td>
                                    <td>
                                        <?php if ($value->status_pengajuan === 'Verifikasi Pimpinan'): ?>
                                        <a href="<?=base_url('puskom/pdl/detail/' . $value->id_pdl)?>"
                                            class="btn btn-primary btn-sm">Lihat Berkas</a>
                                        <?php elseif ($value->status_pengajuan === 'Verifikasi Berkas'): ?>
                                        <a href="<?=base_url('puskom/pdl/detail/' . $value->id_pdl)?>"
                                            class="btn btn-primary btn-sm">Lihat Berkas</a>
                                        <a href="<?=base_url('puskom/pdl/acc/' . $value->id_pdl)?>"
                                            class="btn btn-success btn-sm"
                                            onclick="return confirm('Apakah anda yakin ingin menerima data ini?')">Acc</a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalTolak-<?=$value->id_pdl?>">Tolak</button>
                                        <?php endif;?>
                                    </td>

                                </tr>
                                <div class="modal fade" id="modalTolak-<?=$value->id_pdl?>" tabindex="-1"
                                    aria-labelledby="modalTolakLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTolakLabel">Tolak Pengajuan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?=site_url('puskom/pdl/tolak/' . $value->id_pdl)?>"
                                                    method="post">
                                                    <div class="mb-3">
                                                        <label for="keterangan" class="form-label">Keterangan
                                                            Penolakan</label>
                                                        <textarea class="form-control" id="keterangan" name="keterangan"
                                                            rows="3" required></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Tolak</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;?>
                                </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
// Mengaktifkan atau menonaktifkan tombol download berdasarkan item yang dipilih
const checkAll = document.getElementById('checkAll');
const checkboxes = document.querySelectorAll('.select-item');
const downloadButton = document.getElementById('downloadSelected');
const statusVerif = document.querySelectorAll('.status-verif');

// Toggle semua checkbox
checkAll.addEventListener('change', function() {
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    toggleDownloadButton();
});

// Toggle tombol download saat checkbox di klik
checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        // check if checkAll should be checked
        checkAll.checked = Array.from(checkboxes).every(checkbox => checkbox.checked);

        toggleDownloadButton();
    });
});

function toggleDownloadButton() {
    const selected = Array.from(checkboxes).some(checkbox => checkbox.checked);
    downloadButton.disabled = !selected;
}

// Mengirimkan data ke server untuk mendownload file ZIP
downloadButton.addEventListener('click', function() {
    const selectedIds = Array.from(checkboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);

    const statusVerifIds = Array.from(statusVerif).map(status => status.value);

    if (selectedIds.length > 0) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?=base_url('puskom/pdl/download')?>';

        selectedIds.forEach((id, i) => {
            if (!statusVerifIds.includes(id)) {
                setTimeout(() => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'pdl_ids[]';
                    input.value = id;
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                    // reset form
                    form.innerHTML = '';
                }, i * 1000);
            } else {
                console.info('Data yang dipilih tidak dapat di download karena belum diverifikasi',
                    id);
            }
        });

    }
});
</script>

<?=$this->endSection()?>
<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Perubahan Data Lulusan<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid p-0">

    <div class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <h1 class="h3 d-inline align-middle">Perubahan Data Mahasiswa</h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <?= $this->include('alerts/success'); ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th> <!-- Checkbox untuk memilih semua -->
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NPM</th>
                                    <th>Terakhir Di Update</th>
                                    <th>Status pengajuan</th>
                                    <th>Jenis Pengajuan</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($pdm as $value): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="select-item" value="<?= esc($value->id_pdm); ?>"> <!-- Checkbox untuk setiap baris -->
                                        </td>
                                        <td><?= esc($no++); ?></td>
                                        <td><?= esc($value->nama); ?></td>
                                        <td><?= esc($value->npm); ?></td>
                                        <td><?= ($value->terakhir_update == '0000-00-00' || $value->terakhir_update == null) ? 'Belum di update' : esc($value->terakhir_update); ?></td>
                                        <td><?= esc($value->status_pengajuan); ?></td>
                                        <td><?= esc($value->jenis_pengajuan); ?></td>
                                        <td><?= esc($value->keterangan); ?></td>
                                        <td>
                                            <?php if ($value->status_pengajuan === 'Proses Pengajuan Dikti'): ?>
                                                <a href="<?= base_url('pimpinan/pdm/detail/' . $value->id_pdm) ?>" class="btn btn-primary btn-sm">Lihat Berkas</a>
                                            <?php elseif ($value->status_pengajuan === 'Verifikasi Pimpinan'): ?>
                                                <a href="<?= base_url('pimpinan/pdm/detail/' . $value->id_pdm) ?>" class="btn btn-primary btn-sm">Lihat Berkas</a>
                                                <a href="<?= base_url('pimpinan/pdm/acc/' . $value->id_pdm) ?>" class="btn btn-success btn-sm" onclick="return confirm('Apakah anda yakin ingin menerima data ini?')">Acc</a>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTolak-<?= $value->id_pdm ?>">Tolak</button>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                    <div class="modal fade" id="modalTolak-<?= $value->id_pdm ?>" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTolakLabel">Tolak Pengajuan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="<?= site_url('pimpinan/pdm/tolak/' . $value->id_pdm) ?>" method="post">
                                                        <div class="mb-3">
                                                            <label for="keterangan" class="form-label">Keterangan Penolakan</label>
                                                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Perubahan Data Mahasiswa<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid p-0">

    <div class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <h1 class="h3 d-inline align-middle">Perubahan Data Mahasiswa</h1>
            </div>
            <div class="col-md-6">
                <div class="text-end">
                    <a href="<?= site_url('/prodi/pdm/tambah') ?>" class="btn btn-primary"><i
                            class="ti ti-plus ti-sm"></i> Tambah</a>
                </div>
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
                                <?php
                                $no = 1;
                                foreach ($pdm as $key => $value) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($value->nama); ?></td>
                                        <td><?= esc($value->npm); ?></td>
                                        <td><?= esc($value->prodi); ?></td>
                                        <td>
                                            <?php if ($value->terakhir_update == '0000-00-00' || $value->terakhir_update == null): ?>
                                                Belum di update
                                            <?php else: ?>
                                                <?= esc($value->terakhir_update); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($value->status_pengajuan); ?></td>
                                        <td><?= esc($value->jenis_pengajuan); ?></td>
                                        <td><?= esc($value->keterangan); ?></td>

                                        <td>
                                            <?php if ($value->status_pengajuan === 'Draft'): ?>
                                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                    <a href="<?= base_url('prodi/pdm/edit/' . $value->id_pdm) ?>"
                                                        class="btn btn-warning btn-sm rounded">Edit</a>
                                                    <?php if ($value->jenis_pengajuan !== null): ?>
                                                        <a href="<?= base_url('prodi/pdm/ajukan/' . $value->id_pdm) ?>"
                                                            class="btn btn-success btn-sm rounded"
                                                            onclick="return confirm('Apakah anda yakin ingin mengajukan data ini?')">Ajukan</a>
                                                    <?php endif; ?>
                                                    <a href="<?= base_url('prodi/pdm/delete/' . $value->id_pdm) ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">Hapus</a>
                                                    <a href="<?= base_url('prodi/pdm/lihatjp/' . $value->id_pdm) ?>"
                                                        class="btn btn-info btn-sm rounded">Jenis Pengajuan</a>
                                                </div>
                                            <?php elseif ($value->status_pengajuan === 'Ditolak'): ?>
                                                <a href="<?= base_url('prodi/pdm/delete/' . $value->id_pdm) ?>"
                                                    class="btn btn-danger btn-sm rounded"
                                                    onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">Hapus</a>
                                            <?php endif; ?>

                                            <a href="<?= base_url('prodi/pdm/detail/' . $value->id_pdm) ?>"
                                                class="btn btn-primary btn-sm rounded">Lihat Berkas</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
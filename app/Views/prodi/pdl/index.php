<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Perubahan Data Lulusan<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid p-0">

    <div class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <h1 class="h3 d-inline align-middle">Perubahan Data Lulusan</h1>
            </div>
            <div class="col-md-6">
                <div class="text-end">
                    <a href="<?= site_url('/prodi/pdl/tambah') ?>" class="btn btn-primary"><i class="ti ti-plus ti-sm"></i> Tambah</a>
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
                                foreach ($pdl as $key => $value) : ?>
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
                                                <a href="<?= base_url('prodi/pdl/edit/' . $value->id_pdl) ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="<?= base_url('prodi/pdl/ajukan/' . $value->id_pdl) ?>" class="btn btn-success btn-sm" onclick="return confirm('Apakah anda yakin ingin mengajukan data ini?')">Ajukan</a>
                                                <a href="<?= base_url('prodi/pdl/delete/' . $value->id_pdl) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">Hapus</a>
                                                <a href="<?= base_url('prodi/pdl/lihatjp/' . $value->id_pdl) ?>" class="btn btn-info btn-sm">Jenis Pengajuan</a>
                                            <?php elseif ($value->status_pengajuan === 'Ditolak'): ?>
                                                <a href="<?= base_url('prodi/pdl/delete/' . $value->id_pdl) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">Hapus</a>
                                            <?php endif; ?>

                                            <a href="<?= base_url('prodi/pdl/detail/' . $value->id_pdl) ?>" class="btn btn-primary btn-sm">Lihat Berkas</a>
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
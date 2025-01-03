<?= $this->extend('layouts/base') ?>
<?= $this->section('title'); ?>Lihat Berkas <?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Lihat Berkas</h1>
    </div>
    <a href="<?= base_url('/prodi/pdl/pddsk'); ?>" class="btn btn-secondary btn-sm my-4"><i class="bx bx-left-arrow-alt"></i> Kembali</a>
    <?php if ($pdl->status_pengajuan === 'Draft'): ?>
        <a href="<?= base_url('/prodi/pdl/pddsk/edit/' . $pdl->id_pdl); ?>" class="btn btn-primary btn-sm my-4"><i class="bx bx-edit"></i> Edit</a>
    <?php endif; ?>
    <!-- <a href="" class="btn btn-success btn-sm my-4"><i class="bx bx-check"></i> Selesai</a> -->
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Perubahan Data Mahasiswa</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <p><strong>Nama Mahasiswa:</strong> <?= $pdl->nama; ?></p>
                    <p><strong>NPM:</strong> <?= $pdl->npm; ?></p>
                    <p><strong>Program Studi:</strong> <?= $pdl->prodi; ?></p>
                    <p><strong>Status Pengajuan:</strong> <?= $pdl->status_pengajuan; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Berkas</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <?php foreach ($bpm as $r): ?>
                        <div class="col-md-6">
                            <h2 class="text-center mb-3 mt-3"><?= $r['jenis']; ?></h2>
                            <iframe src="<?= base_url('uploads/pdl/pddsk/' . $r['file']); ?>" height="600px" width="100%" style="border: none;" title="Detail Berkas"></iframe>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
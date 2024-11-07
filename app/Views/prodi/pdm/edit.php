<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Edit PDM<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mb-3">
        <div class="row">
            <div class="col-md-12">
                <h1 class="h3 d-inline align-middle">Edit Perubahan Data Mahasiswa</h1>
            </div>
        </div>
    </div>

    <!-- Edit::Start -->
    <form id="editor-form" action="<?= site_url('prodi/pdm/update/' . $pdm['id_pdm']) ?>" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                <?= $this->include('alerts/errors'); ?>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label" for="npm">NPM</label>
                                <input type="text" name="npm" id="npm" value="<?= $pdm['npm'] ?>" class="form-control mb-3" required />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" value="<?= $pdm['nama'] ?>" class="form-control mb-3" required />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="prodi">Program Studi</label>
                                <input type="text" name="prodi" id="prodi" value="<?= $pdm['prodi'] ?>" class="form-control mb-3" readonly />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="file">KTP</label>
                                <small class="text-muted">File saat ini: <?= $berkas[0]->file ?></small>
                                <input type="file" name="file[]" class="form-control">

                                <label class="form-label mt-2" for="file">Akta Kelahiran</label>
                                <small class="text-muted">File saat ini: <?= $berkas[1]->file ?></small>
                                <input type="file" name="file[]" class="form-control">

                                <label class="form-label mt-2" for="file">Kartu Keluarga</label>
                                <small class="text-muted">File saat ini: <?= $berkas[2]->file ?></small>
                                <input type="file" name="file[]" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label mt-2" for="file">Ijazah dan Transkrip</label>
                                <small class="text-muted">File saat ini: <?= $berkas[3]->file ?></small>
                                <input type="file" name="file[]" class="form-control">

                                <label class="form-label mt-2" for="file">KTM</label>
                                <small class="text-muted">File saat ini: <?= $berkas[4]->file ?></small>
                                <input type="file" name="file[]" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="/prodi/pdm" class="btn btn-success">cancel</a>
                </div>
            </div>
        </div>
    </form>
    <!--/ Edit::End -->
</div>
<?= $this->endSection() ?>
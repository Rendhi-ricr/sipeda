<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Lihat Jenis Pengajuan<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid p-0">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <h1 class="h3 d-inline align-middle">Jenis Pengajuan</h1>
            </div>
        </div>
    </div>
    <a href="<?= base_url('/prodi/pdm'); ?>" class="btn btn-secondary my-4 rounded"><i class="bx bx-right-arrow-alt"></i> Kembali</a>

    <form id="editor-form" action="<?= site_url('prodi/pdm/jp/' . $id_pdm) ?>" method="post" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label" for="jp">Jenis Pengajuan</label>
                <select name="jenis_pengajuan" id="jp" class="form-control select2">
                    <option value="">Pilih Jenis Pengajuan</option>
                    <option value="Nama">Nama</option>
                    <option value="NIK">NIK</option>
                    <option value="Jenis Kelamin">Jenis Kelamin</option>
                    <option value="Tanggal Lahir">Tanggal Lahir</option>
                    <option value="Tempat Lahir">Tempat Lahir</option>
                    <option value="Nama Ibu">Nama Ibu</option>
                    <option value="NPM">NPM</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label" for="da">Data Awal</label>
                <input type="text" name="data_awal" id="da" class="form-control" required />

            </div>
            <div class="col-md-6">
                <label class="form-label" for="du">Data Yang Diajukan</label>
                <input type="text" name="data_diusulkan" id="du" class="form-control" required />
            </div>
        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary mb-3">Submit</button>
        </div>
    </form>


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
                                    <th>Jenis Pengajuan</th>
                                    <th>Data Awal</th>
                                    <th>Data Diusulkan</th>
                                </tr>

                                <?php
                                $no = 1;
                                foreach ($jppm as $jp) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $jp['jenis_pengajuan'] ?></td>
                                        <td><?= $jp['data_awal'] ?></td>
                                        <td><?= $jp['data_diusulkan'] ?></td>
                                    </tr>
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
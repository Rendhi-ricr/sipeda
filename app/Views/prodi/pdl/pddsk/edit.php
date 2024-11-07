<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Edit Perubahan Antar Status<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="mb-3">
        <div class="row">
            <div class="col-md-12">
                <h1 class="h3 d-inline align-middle">Edit Data Perubahan Antar Status</h1>
            </div>
        </div>
    </div>

    <!-- Edit::Start -->
    <form id="editor-form" action="<?= site_url('prodi/pdl/pddsk/update/' . $pdl['id_pdl']) ?>" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                <?= $this->include('alerts/errors'); ?>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label" for="npm">NPM</label>
                        <input type="text" name="npm" id="npm" class="form-control" value="<?= $pdl['npm'] ?>" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label" for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="<?= $pdl['nama'] ?>" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label" for="prodi">Program Studi</label>
                        <input type="text" name="prodi" id="prodi" class="form-control" value="<?= $pdl['prodi'] ?>" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label" for="jenis_pengajuan">Jenis Pengajuan</label>
                        <select name="jenis_pengajuan" id="jenis_pengajuan" class="form-control select2" required>
                            <option value="">Pilih Jenis Pengajuan</option>
                            <option value="Perubahan Tanggal keluar" <?= $jppm['jenis_pengajuan'] == 'Perubahan Tanggal keluar' ? 'selected' : '' ?>>Perubahan Tanggal keluar</option>
                            <option value="Periode Keluar" <?= $jppm['jenis_pengajuan'] == 'Periode Keluar' ? 'selected' : '' ?>>Periode Keluar</option>
                            <option value="Tanggal SK" <?= $jppm['jenis_pengajuan'] == 'Tanggal SK' ? 'selected' : '' ?>>Tanggal SK</option>
                            <option value="IPK" <?= $jppm['jenis_pengajuan'] == 'IPK' ? 'selected' : '' ?>>IPK</option>
                            <option value="No Ijazah Atau No Sertifikat Profesi" <?= $jppm['jenis_pengajuan'] == 'No Ijazah Atau No Sertifikat Profesi' ? 'selected' : '' ?>>No Ijazah Atau No Sertifikat Profesi</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="data_awal">Data Awal</label>
                        <input type="text" name="data_awal" id="data_awal" class="form-control" value="<?= $jppm['data_awal'] ?>" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="data_diusulkan">Data Yang Diusulkan</label>
                        <input type="text" name="data_diusulkan" id="data_diusulkan" class="form-control" value="<?= $jppm['data_diusulkan'] ?>" required />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="file">Ijazah dan Transkrip</label>
                        <small class="text-muted">File saat ini: <?= $bpm[0]->file ?></small>
                        <input type="file" name="file[]" class="form-control">
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
    <!--/ Edit::End -->
</div>

<script>
    // Script to toggle input fields when checkbox is checked
    document.querySelectorAll(".form-check-input").forEach((checkbox) => {
        checkbox.addEventListener("change", function() {
            const inputField = this.parentNode.querySelector(".row");
            if (this.checked) {
                inputField.classList.remove("d-none");
            } else {
                inputField.classList.add("d-none");
            }
        });
    });
</script>
<?= $this->endSection() ?>
<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Tambah Perubahan Antar Status<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="mb-3">
        <div class="row">
            <div class="col-md-12">
                <h1 class="h3 d-inline align-middle">Tambah Data Perubahan Antar Status</h1>
            </div>
        </div>
    </div>

    <!-- Tambah::Start -->
    <form id="editor-form" action="<?= site_url('prodi/pdl/pddsk/simpan') ?>" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                <?= $this->include('alerts/errors'); ?>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label" for="npm">NPM</label>
                        <input type="text" name="npm" id="npm" class="form-control" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label" for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" required />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label" for="angkatan">Angkatan</label>
                        <input type="number" name="angkatan" id="angkatan" class="form-control" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label" for="prodi">Program Studi</label>
                        <input type="text" name="prodi" id="prodi" class="form-control" value="<?= $prodi ?>" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label" for="jenis_pengajuan">Jenis Pengajuan</label>
                        <select name="jenis_pengajuan" id="jenis_pengajuan" class="form-control select2">
                            <option value="">Pilih Jenis Pengajuan</option>
                            <option value="Perubahan Tanggal keluar">Perubahan Tanggal keluar</option>
                            <option value="Periode Keluar">Periode Keluar</option>
                            <option value="Tanggal SK">Tanggal SK</option>
                            <option value="IPK">IPK</option>
                            <option value="No Ijazah Atau No Sertifikat Profesi">No Ijazah Atau No Sertifikat Profesi</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="data_awal">Data Awal</label>
                        <input type="text" name="data_awal" id="data_awal" class="form-control" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="data_diusulkan">Data Yang Diusulkan</label>
                        <input type="text" name="data_diusulkan" id="data_diusulkan" class="form-control" required />
                    </div>
                </div>

                <!-- Mulai Bagian Input File dengan 2 Kolom -->
                <!-- <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="file_ktp">KTP</label>
                        <small class="text-muted "> | Maximum Upload : <h7 style="color:red;">200 kb</h7></small>
                        <input type="file" name="file[]" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="file_akta">Akta Kelahiran</label>
                        <small class="text-muted "> | Maximum Upload : <h7 style="color:red;">200 kb</h7></small>
                        <input type="file" name="file[]" class="form-control" required>
                    </div>
                </div> -->

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="file_ijazah">Ijazah dan Transkrip</label>
                        <small class="text-muted "> | Maximum Upload : <h7 style="color:red;">200 kb</h7></small>
                        <input type="file" name="file[]" class="form-control" required>
                    </div>
                    <div class="col-md-6 d-none" id="dokumenInput">
                        <label class="form-label" for="file_sk">Sk Yudisium</label>
                        <small class="text-muted"> | Maximum Upload: <span style="color:red;">200 kb</span></small>
                        <input type="file" name="file[]" class="form-control" id="file_dokumen">
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
    <!--/ Tambah::End -->
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

    document.getElementById('jenis_pengajuan').addEventListener('change', function() {
        const dokumenInput = document.getElementById('dokumenInput');
        const selectedValue = this.value;

        // Tampilkan dokumenInput jika jenis pengajuan adalah "No Ijazah Atau No Sertifikat Profesi"
        if (selectedValue === 'No Ijazah Atau No Sertifikat Profesi') {
            dokumenInput.classList.remove('d-none');
        } else {
            dokumenInput.classList.add('d-none');
        }
    });
</script>

<?= $this->endSection() ?>
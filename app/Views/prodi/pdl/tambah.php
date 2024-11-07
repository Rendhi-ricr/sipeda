<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Tambah PDL<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="mb-3">
        <div class="row">
            <div class="col-md-12">
                <h1 class="h3 d-inline align-middle">Tambah Perubahan Data Lulusan</h1>
            </div>
        </div>
    </div>

    <!-- Tambah::Start -->
    <form id="editor-form" action="<?= site_url('prodi/pdl/simpan') ?>" method="post" enctype="multipart/form-data">
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
                        <label class="form-label" for="prodi">Program Studi</label>
                        <input type="text" name="prodi" id="prodi" class="form-control" value="<?= $prodi ?>" readonly>
                    </div>
                </div>

                <!-- <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label" for="jp">Jenis Pengajuan</label>
                        <select name="jp" id="jp" class="form-control select2">
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
                    <div class="col-md-12">
                        <label class="form-label" for="da">Data Awal</label>
                        <input type="text" name="da" id="da" class="form-control" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label" for="du">Data Yang Diajukan</label>
                        <input type="text" name="du" id="du" class="form-control" required />
                    </div>
                </div> -->

                <!-- Mulai Bagian Input File dengan 2 Kolom -->
                <div class="row mb-3">
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
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="file_kk">Kartu Keluarga</label>
                        <small class="text-muted "> | Maximum Upload : <h7 style="color:red;">200 kb</h7></small>
                        <input type="file" name="file[]" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="file_ijazah">Ijazah dan Transkrip</label>
                        <small class="text-muted "> | Maximum Upload : <h7 style="color:red;">200 kb</h7></small>
                        <input type="file" name="file[]" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- <div class="col-md-6">
                        <label class="form-label" for="file_transkrip">Transkrip</label>
                        <small class="text-muted "> | Maximum Upload : <h7 style="color:red;">200 kb</h7></small>
                        <input type="file" name="file[]" class="form-control" required>
                    </div> -->
                    <div class="col-md-6">
                        <label class="form-label" for="file_ktm">KTM</label>
                        <small class="text-muted "> | Maximum Upload : <h7 style="color:red;">200 kb</h7></small>
                        <input type="file" name="file[]" class="form-control" required>
                    </div>
                </div>

                <!-- <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jenis_pengajuan[]" value="Nama" id="nama">
                            <label class="form-label" for="nama">Nama</label>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Data Awal</label>
                                    <input type="text" name="data_awal[]" class="form-control mt-2">
                                </div>
                                <div class="col-md-6">
                                    <label>Data Diusulkan</label>
                                    <input type="text" name="data_diusulkan[]" class="form-control mt-2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jenis_pengajuan[]" value="NIK" id="nik">
                            <label class="form-label" for="nik">NIK</label>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Data Awal</label>
                                    <input type="text" name="data_awal[]" class="form-control mt-2">
                                </div>
                                <div class="col-md-6">
                                    <label>Data Diusulkan</label>
                                    <input type="text" name="data_diusulkan[]" class="form-control mt-2">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jenis_pengajuan[]" value="Jenis Kelamin" id="jenis_kelamin">
                            <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Data Awal</label>
                                    <input type="text" name="data_awal[]" class="form-control mt-2">
                                </div>
                                <div class="col-md-6">
                                    <label>Data Diusulkan</label>
                                    <input type="text" name="data_diusulkan[]" class="form-control mt-2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jenis_pengajuan[]" value="Tanggal Lahir" id="tanggal_lahir">
                            <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Data Awal</label>
                                    <input type="text" name="data_awal[]" class="form-control mt-2">
                                </div>
                                <div class="col-md-6">
                                    <label>Data Diusulkan</label>
                                    <input type="text" name="data_diusulkan[]" class="form-control mt-2">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jenis_pengajuan[]" value="Tempat Lahir" id="tempat_lahir">
                            <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Data Awal</label>
                                    <input type="text" name="data_awal[]" class="form-control mt-2">
                                </div>
                                <div class="col-md-6">
                                    <label>Data Diusulkan</label>
                                    <input type="text" name="data_diusulkan[]" class="form-control mt-2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jenis_pengajuan[]" value="Nama Ibu" id="nama_ibu">
                            <label class="form-label" for="nama_ibu">Nama Ibu</label>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Data Awal</label>
                                    <input type="text" name="data_awal[]" class="form-control mt-2">
                                </div>
                                <div class="col-md-6">
                                    <label>Data Diusulkan</label>
                                    <input type="text" name="data_diusulkan[]" class="form-control mt-2">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jenis_pengajuan[]" value="NPM" id="npm">
                            <label class="form-label" for="npm">NPM</label>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Data Awal</label>
                                    <input type="text" name="data_awal[]" class="form-control mt-2">
                                </div>
                                <div class="col-md-6">
                                    <label>Data Diusulkan</label>
                                    <input type="text" name="data_diusulkan[]" class="form-control mt-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- Akhir Bagian Input File -->

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
</script>
<?= $this->endSection() ?>
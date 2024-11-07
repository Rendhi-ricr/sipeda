<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <form method="POST" action="/register">
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h3 class="card-title text-center mb-4">Sign Up</h3>
                            <form>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="prodi">Prodi</label>
                                    <select class="form-select" id="prodi" name="prodi" required>
                                        <option value="">Pilih Prodi</option>
                                        <option value="Administrasi Publik">Administrasi Publik</option>
                                        <option value="Administrasi Bisnis">Administrasi Bisnis</option>
                                        <option value="Administrasi Keuangan">Administrasi Keuangan</option>
                                        <option value="Teknik Mesin">Teknik Mesin</option>
                                        <option value="Teknik Elektro">Teknik Elektro</option>
                                        <option value="Teknik Arsitektur">Teknik Arsitektur</option>
                                        <option value="Teknik Sipil">Teknik Sipil</option>
                                        <option value="Ilmu Hukum">Ilmu Hukum</option>
                                        <option value="Sistem Informasi">Sistem Informasi</option>
                                        <option value="Ilmu Komunikasi">Ilmu Komunikasi</option>
                                        <option value="Agribisnis">Agribisnis</option>
                                        <option value="Agroteknologi">Agroteknologi</option>
                                        <option value="Matematika">Matematika</option>
                                        <option value="Pendidikan Jasmani Kesehatan dan Rekreasi">Pendidikan Jasmani Kesehatan dan Rekreasi</option>
                                        <option value="Bahasa Inggris">Bahasa Inggris</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cpassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="cpassword" name="confirm_password" placeholder="Enter your password" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                                <div class="mt-3 text-center">
                                    <p>Already have an account? <a href="/login">Login here</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
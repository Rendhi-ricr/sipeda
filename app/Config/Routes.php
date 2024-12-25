<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('login', 'Auth::index'); // Menampilkan halaman login
$routes->post('login', 'Auth::login'); // Menangani proses login

$routes->get('register', 'Auth::tambah'); // Menampilkan halaman registrasi
$routes->post('register', 'Auth::register'); // Menangani proses registrasi

$routes->get('logout', 'Auth::logout');

// Routes untuk Pdm Controller
$routes->group('prodi/pdm', function ($routes) {
    $routes->get('/', 'Prodi\Pdm::index'); // Menampilkan daftar PDM
    $routes->get('detail/(:num)', 'Prodi\Pdm::detail/$1'); // Menampilkan detail PDM
    $routes->get('tambah', 'Prodi\Pdm::tambah'); // Menampilkan form tambah PDM
    $routes->post('simpan', 'Prodi\Pdm::simpan'); // Menyimpan data PDM
    $routes->get('edit/(:num)', 'Prodi\Pdm::edit/$1'); // Menampilkan form edit PDM
    $routes->post('update/(:num)', 'Prodi\Pdm::update/$1'); // Memperbarui data PDM
    $routes->get('delete/(:num)', 'Prodi\Pdm::delete/$1'); // Menghapus data PDM
    $routes->get('ajukan/(:num)', 'Prodi\Pdm::ajukan/$1'); // Mengajukan PDM untuk verifikasi
    $routes->get('lihatjp/(:num)', 'Prodi\Pdm::lihatjp/$1'); // Menampilkan jenis pengajuan
    $routes->post('jp/(:num)', 'Prodi\Pdm::jp/$1'); // Menyimpan jenis pengajuan
    $routes->get('generate-surat/(:num)/(:alphanum)', 'Prodi\Pdm::generateAndSaveSurat/$1/$2'); // Menghasilkan surat
});

$routes->group('prodi/pdl/putus_studi', function ($routes) {
    $routes->get('/', 'Prodi\Pdl\Putus_Studi::index'); // Menampilkan daftar PDM
    // $routes->get('detail/(:num)', 'Prodi\Pdl::detail/$1'); // Menampilkan detail PDM
    $routes->get('tambah', 'Prodi\Pdl\Putus_Studi::tambah'); // Menampilkan form tambah PDM
    $routes->post('simpan', 'Prodi\Pdl\Putus_Studi::simpan'); // Menyimpan data PDM
    // $routes->get('edit/(:num)', 'Prodi\Pdl::edit/$1'); // Menampilkan form edit PDM
    // $routes->post('update/(:num)', 'Prodi\Pdl::update/$1'); // Memperbarui data PDM
    // $routes->get('delete/(:num)', 'Prodi\Pdl::delete/$1'); // Menghapus data PDM
    // $routes->get('ajukan/(:num)', 'Prodi\Pdl::ajukan/$1'); // Mengajukan PDM untuk verifikasi
    // $routes->get('lihatjp/(:num)', 'Prodi\Pdl::lihatjp/$1'); // Menampilkan jenis pengajuan
    // $routes->post('jp/(:num)', 'Prodi\Pdl::jp/$1'); // Menyimpan jenis pengajuan
    // $routes->get('generate-surat/(:num)', 'Prodi\Pdl::generateSurat/$1'); // Menghasilkan surat
});
$routes->group('prodi/pdl/pddsk', function ($routes) {
    $routes->get('/', 'Prodi\Pdl\Pddsk::index'); // Menampilkan daftar PDM
    $routes->get('detail/(:num)', 'Prodi\Pdl\Pddsk::detail/$1'); // Menampilkan detail PDM
    $routes->get('tambah', 'Prodi\Pdl\Pddsk::tambah'); // Menampilkan form tambah PDM
    $routes->post('simpan', 'Prodi\Pdl\Pddsk::simpan'); // Menyimpan data PDM
    $routes->get('edit/(:num)', 'Prodi\Pdl\Pddsk::edit/$1'); // Menampilkan form edit PDM
    $routes->post('update/(:num)', 'Prodi\Pdl\Pddsk::update/$1'); // Memperbarui data PDM
    $routes->get('delete/(:num)', 'Prodi\Pdl\Pddsk::delete/$1'); // Menghapus data PDM
    $routes->get('ajukan/(:num)', 'Prodi\Pdl\Pddsk::ajukan/$1'); // Mengajukan PDM untuk verifikasi
    // $routes->get('generate-surat/(:num)/(:alphanum)', 'Prodi\Pdl\Pddsk::generateSurat/$1/$2'); // Mengajukan PDM untuk verifikasi
    $routes->get('lihatjp/(:num)', 'Prodi\Pdl::lihatjp/$1'); // Menampilkan jenis pengajuan
    $routes->post('jp/(:num)', 'Prodi\Pdl::jp/$1'); // Menyimpan jenis pengajuan
    $routes->get('generate-surat/(:num)', 'Prodi\Pdl::generateSurat/$1'); // Menghasilkan surat
});

$routes->group("puskom/pdm", function ($routes) {
    // Route untuk menampilkan daftar PDM
    $routes->get('/', 'Puskom\Pdm::index');
    // Route untuk menampilkan detail PDM berdasarkan ID
    $routes->get('detail/(:num)', 'Puskom\Pdm::detail/$1');

    // Route untuk mengonfirmasi pengajuan PDM
    $routes->get('acc/(:num)', 'Puskom\Pdm::acc/$1');

    // Route untuk menolak pengajuan PDM
    $routes->post('tolak/(:num)', 'Puskom\Pdm::tolak/$1');

    // Route untuk mengunduh beberapa berkas PDM secara multiple (ZIP)
    $routes->post('downloadMultiple', 'Puskom\Pdm::downloadMultiple');
});
$routes->group("puskom/pdl", function ($routes) {
    // Route untuk menampilkan daftar PDM
    $routes->get('/', 'Puskom\Pdl::index');
    // Route untuk menampilkan detail Pdl berdasarkan ID
    $routes->get('detail/(:num)', 'Puskom\Pdl::detail/$1');

    // Route untuk mengonfirmasi pengajuan Pdl
    $routes->get('acc/(:num)', 'Puskom\Pdl::acc/$1');

    // Route untuk menolak pengajuan Pdl
    $routes->post('tolak/(:num)', 'Puskom\Pdl::tolak/$1');

    // Route untuk mengunduh beberapa berkas Pdl
    $routes->post('download', 'Puskom\Pdl::download');
});
$routes->group("puskom/pdl/pddsk", function ($routes) {
    // Route untuk menampilkan daftar PDM
    $routes->get('/', 'Puskom\Pdl\Pddsk::index');
    // Route untuk menampilkan detail Pdl berdasarkan ID
    $routes->get('detail/(:num)', 'Puskom\Pdl\Pddsk::detail/$1');

    // Route untuk mengonfirmasi pengajuan Pdl
    $routes->get('acc/(:num)', 'Puskom\Pdl\Pddsk::acc/$1');

    // Route untuk menolak pengajuan Pdl
    $routes->post('tolak/(:num)', 'Puskom\Pdl\Pddsk::tolak/$1');

    // Route untuk mengunduh beberapa berkas Pdl
    $routes->post('download', 'Puskom\Pdl\Pddsk::download');
});

// Route untuk mengakses halaman indeks PDM
$routes->group('pimpinan/pdm', function ($routes) {
    $routes->get('/', 'Pimpinan\Pdm::index'); // Halaman utama PDM
    $routes->get('detail/(:num)', 'Pimpinan\Pdm::detail/$1'); // Halaman detail PDM berdasarkan ID
    $routes->get('acc/(:num)', 'Pimpinan\Pdm::acc_pimpinan/$1'); // Proses penerimaan PDM berdasarkan ID
    $routes->post('tolak/(:num)', 'Pimpinan\Pdm::tolakPimpinan/$1'); // Proses penolakan PDM berdasarkan ID
});
$routes->group('pimpinan/pdl/pddsk', function ($routes) {
    $routes->get('/', 'Pimpinan\Pdl\Pddsk::index'); // Halaman utama PDM
    $routes->get('detail/(:num)', 'Pimpinan\Pdl\Pddsk::detail/$1'); // Halaman detail PDM berdasarkan ID
    $routes->get('acc/(:num)', 'Pimpinan\Pdl\Pddsk::acc_pimpinan/$1'); // Proses penerimaan PDM berdasarkan ID
    $routes->post('tolak/(:num)', 'Pimpinan\Pdl\Pddsk::tolakPimpinan/$1'); // Proses penolakan PDM berdasarkan ID
});

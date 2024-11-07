<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">Sistem Informasi Pengajuan Data</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Tools & Components
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>


            <?php if (session()->get('level') == 'prodi') : ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/prodi/pdm">
                        <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">PDM</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/prodi/pdl">
                        <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">PDL</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a data-bs-target="#multi" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-right-down align-middle">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg> <span class="align-middle">PDL</span>
                    </a>
                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a data-bs-target="#pas" data-bs-toggle="collapse" class="sidebar-link ms-4 collapsed" aria-expanded="false">Perubahan Antar Status</a>
                            <ul id="pas" class="collapse list-unstyled ms-4">
                                <li>
                                    <a href="/prodi/pdl/putus_studi" class="sidebar-link">Putus Studi ke Lulus</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Wafat/Selesai Pendidikan Non Gelar ke Lulus</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a data-bs-target="#reactivation" data-bs-toggle="collapse" class="sidebar-link ms-4 collapsed" aria-expanded="false">Pengaktifan Kembali</a>
                            <ul id="reactivation" class="collapse list-unstyled ms-4">
                                <li>
                                    <a href="" class="sidebar-link">Lulus ke Aktif</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Mutasi ke Aktif</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Dikeluarkan ke Aktif</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Mengundurkan Diri ke Aktif</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Putus Studi ke Aktif</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="/prodi/pdl/pddsk" class="sidebar-link">Perubahan Detail Data Status Keluar</a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="sidebar-item">
                    <a class="sidebar-link" href="/panel/pengaduan">
                        <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">Data Pengaduan</span>
                    </a>
                </li> -->
            <?php endif; ?>
            <?php if (session()->get('level') == 'puskom') : ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/puskom/pdm">
                        <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">PDM</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/puskom/pdl">
                        <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">PDL</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a data-bs-target="#multi" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-right-down align-middle">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg> <span class="align-middle">PDL</span>
                    </a>
                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a data-bs-target="#pas" data-bs-toggle="collapse" class="sidebar-link ms-4 collapsed" aria-expanded="false">Perubahan Antar Status</a>
                            <ul id="pas" class="collapse list-unstyled ms-4">
                                <li>
                                    <a href="/puskom/pdl/putus_studi" class="sidebar-link">Putus Studi ke Lulus</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Wafat/Selesai Pendidikan Non Gelar ke Lulus</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a data-bs-target="#reactivation" data-bs-toggle="collapse" class="sidebar-link ms-4 collapsed" aria-expanded="false">Pengaktifan Kembali</a>
                            <ul id="reactivation" class="collapse list-unstyled ms-4">
                                <li>
                                    <a href="" class="sidebar-link">Lulus ke Aktif</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Mutasi ke Aktif</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Dikeluarkan ke Aktif</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Mengundurkan Diri ke Aktif</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Putus Studi ke Aktif</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="/puskom/pdl/pddsk" class="sidebar-link">Perubahan Detail Data Status Keluar</a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="sidebar-item">
                    <a class="sidebar-link" href="/panel/pengaduan">
                        <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">Data Pengaduan</span>
                    </a>
                </li> -->
            <?php endif; ?>
            <?php if (session()->get('level') == 'pimpinan') : ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/pimpinan/pdm">
                        <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">PDM</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a data-bs-target="#multi" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-right-down align-middle">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg> <span class="align-middle">PDL</span>
                    </a>
                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a data-bs-target="#pas" data-bs-toggle="collapse" class="sidebar-link ms-4 collapsed" aria-expanded="false">Perubahan Antar Status</a>
                            <ul id="pas" class="collapse list-unstyled ms-4">
                                <li>
                                    <a href="/pimpinan/pdl/putus_studi" class="sidebar-link">Putus Studi ke Lulus</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Wafat/Selesai Pendidikan Non Gelar ke Lulus</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a data-bs-target="#reactivation" data-bs-toggle="collapse" class="sidebar-link ms-4 collapsed" aria-expanded="false">Pengaktifan Kembali</a>
                            <ul id="reactivation" class="collapse list-unstyled ms-4">
                                <li>
                                    <a href="" class="sidebar-link">Lulus ke Aktif</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Mutasi ke Aktif</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Dikeluarkan ke Aktif</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Mengundurkan Diri ke Aktif</a>
                                </li>
                                <li>
                                    <a href="" class="sidebar-link">Putus Studi ke Aktif</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="/pimpinan/pdl/pddsk" class="sidebar-link">Perubahan Detail Data Status Keluar</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

        </ul>



    </div>
</nav>
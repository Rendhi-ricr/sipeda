<?php

namespace App\Controllers\Prodi\Pdl;

use App\Controllers\BaseController;
use App\Models\PdlModels;
use App\Models\BerkasPdlModels;
use App\Models\JenisPengajuanPdlModels;

class Pddsk_backup extends BaseController
{
    protected $pdl, $bpm, $jppm;
    public function __construct()
    {
        $this->pdl = new PdlModels();
        $this->bpm = new BerkasPdlModels();
        $this->jppm = new JenisPengajuanPdlModels();
    }

    public function index()
    {
        $prodi = session()->get('prodi');

        // Ambil data dengan jenis pengajuan yang ditentukan
        $data['pdl'] = $this->pdl->getPdlWithBerkasAndJenis([
            'Perubahan Tanggal Keluar',
            'Periode Keluar',
            'Tanggal SK',
            'Nomor SK',
            'IPK',
            'No Ijazah Atau No Sertifikat Profesi'
        ], $prodi);

        // Tampilkan ke view
        return view('prodi/pdl/pddsk/index', $data);
    }

    public function detail($id_pdl)
    {
        $pdl = $this->pdl->getPdlWithBerkas($id_pdl);
        $berkas = $this->bpm->getBerkasByPdl($id_pdl);
        $jenis = $this->pdl->getPdlWithBerkasAndJenis($id_pdl);

        if ($pdl) {
            // Jenis surat yang ingin ditampilkan di awal
            $jenisSuratDiAwal = 'Surat';

            // Mengurutkan array berkas agar jenis surat yang diinginkan muncul di awal
            usort($berkas, function ($a, $b) use ($jenisSuratDiAwal) {
                if ($a['jenis'] === $jenisSuratDiAwal) {
                    return -1;
                } elseif ($b['jenis'] === $jenisSuratDiAwal) {
                    return 1;
                }
                return 0;
            });

            $data = [
                'title' => 'Lihat Berkas',
                'pdl' => $pdl,
                'bpm' => $berkas,  // Berkas sudah diurutkan
                'jenis' => $jenis
            ];

            return view('prodi/pdl/pddsk/berkas', $data);
        } else {
            return redirect()->to('/prodi/pdl/pddsk')->with('error', 'Transaksi tidak ditemukan.');
        }
    }

    public function tambah()
    {
        // Ambil prodi dari sesi
        $prodi = session()->get('prodi'); // Pastikan prodi sudah disimpan saat login

        // Kirimkan prodi ke view
        $data = [
            'prodi' => $prodi // Mengirimkan data prodi ke view
        ];

        return view('prodi/pdl/pddsk/tambah', $data);
    }


    public function simpan()
    {
        date_default_timezone_set('Asia/Jakarta'); // Ganti dengan zona waktu yang sesuai
        if ($this->request->getMethod() === 'post') {
            // Aturan validasi
            $validationRule = [
                'npm' => 'required',
                'nama' => 'required',
                'file' => 'uploaded[file]|max_size[file,200]|ext_in[file,pdf]'
            ];

            // Validate input data
            if ($this->validate($validationRule)) {
                // Tangkap data dari formulir
                $npm = $this->request->getPost('npm');
                $nama = $this->request->getPost('nama');
                $angkatan = $this->request->getPost('angkatan');
                $prodi = session()->get('prodi'); // Ambil prodi dari sesi
                // $jp = $this->request->getPost('jenis_pengajuan'); // Jenis pengajuan
                // $da = $this->request->getPost('data_awal'); // Data awal
                // $du = $this->request->getPost('data_diusulkan'); // Data diusulkan
                $pdf = $this->request->getFiles('file'); // Mengambil file yang diupload

                // Simpan data transaksi
                $this->pdl->save([
                    'npm' => $npm,
                    'nama' => $nama,
                    'angkatan' => $angkatan,
                    'prodi' => $prodi,
                ]);

                $id_pdl = $this->pdl->insertID();

                $this->jppm->save([
                    'id_pdl' => $id_pdl,
                    'jenis_pengajuan' => $this->request->getPost('jenis_pengajuan'),
                    'data_awal' => $this->request->getPost('data_awal'),
                    'data_diusulkan' => $this->request->getPost('data_diusulkan'),
                ]);

                // Simpan detail transaksi
                if (!empty($pdf['file'])) { // Pastikan ada file yang diupload
                    $u = 0;
                    $jenis_berkas = '';
                    foreach ($pdf['file'] as $file) {
                        switch ($u) {
                            case 0:
                                $jenis_berkas = 'Ijazah dan Transkrip';
                                break;
                            case 1:
                                $jenis_berkas = 'SK Yudisium';
                                break;
                        }

                        // Pastikan file diupload dan valid
                        if ($file && $file->isValid() && !$file->hasMoved()) {
                            $newFileName = 'pdl_' . $npm . '' . $jenis_berkas . '' . time() . '.' . $file->getClientExtension(); // Buat nama file baru
                            $file->move(WRITEPATH . 'uploads/pdl/pddsk', $newFileName); // Pindahkan file ke folder

                            $this->bpm->save([
                                'id_pdl' => $id_pdl,
                                'file' => $newFileName, // Simpan nama file yang baru
                                'jenis' => $jenis_berkas
                            ]);
                        }

                        $u++;
                    }
                } else {
                    session()->setFlashdata('error', 'Tidak ada file yang diupload.');
                    return redirect()->to('/prodi/pdl/pddsk/tambah');
                }

                session()->setFlashdata('message', 'Data berhasil disimpan');
                return redirect()->to('/prodi/pdl/pddsk');
            } else {
                // Jika validasi gagal, ambil error
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->to('/prodi/pdl/pddsk/tambah');
            }
        } else {
            session()->setFlashdata('error', 'Data gagal disimpan');
            return redirect()->to('/prodi/pdl/pddsk/tambah');
        }
    }

    // public function generateSurat($id_pdl)
    // {

    //     // Mengambil data jenis pengajuan berdasarkan id_pdl
    //     $data['srt'] = $this->pdl->getJenisByPdl($id_pdl);

    //     // Mengirim data ke view untuk di-render
    //     return view('prodi/pdl/pddsk/surat', $data);
    // }

    // public function generateAndSaveSurat($id_pdl, $npm)
    // {
    //     try {
    //         // Ambil data surat berdasarkan id_pdm
    //         $data['srt'] = $this->pdl->getJenisByPdl($id_pdl);

    //         if (!$data['srt']) {
    //             throw new \Exception("Data tidak ditemukan untuk ID PDL: $id_pdl");
    //         }

    //         // Path gambar kop surat
    //         $pathKop = FCPATH . 'uploads/kop_surat/kop.png';
    //         $pathTtd = FCPATH . 'uploads/kop_surat/ttd_pdl.png';

    //         // Validasi file gambar
    //         if (!file_exists($pathKop) || !file_exists($pathTtd)) {
    //             throw new \Exception('File kop surat atau tanda tangan tidak ditemukan.');
    //         }

    //         // Konversi gambar ke Base64
    //         $typeKop = pathinfo($pathKop, PATHINFO_EXTENSION);
    //         $typeTtd = pathinfo($pathTtd, PATHINFO_EXTENSION);
    //         $dataImageKop = file_get_contents($pathKop);
    //         $dataImageTtd = file_get_contents($pathTtd);
    //         $base64Kop = 'data:image/' . $typeKop . ';base64,' . base64_encode($dataImageKop);
    //         $base64Ttd = 'data:image/' . $typeTtd . ';base64,' . base64_encode($dataImageTtd);

    //         // Kirimkan base64 ke view
    //         $data['kop_surat_base64'] = $base64Kop;
    //         $data['ttdAll'] = $base64Ttd;

    //         // Load the view as a string
    //         $html = view('prodi/pdl/pddsk/surat', $data);

    //         // Bersihkan elemen kosong di HTML
    //         $html = preg_replace('/<[^\/>]*>([\s]?)*<\/[^>]*>/', '', $html);

    //         // Generate PDF menggunakan Dompdf
    //         $dompdf = new \Dompdf\Dompdf();
    //         $dompdf->loadHtml($html);

    //         // Atur ukuran kertas dan orientasi
    //         $dompdf->setPaper('A4', 'portrait');

    //         // Opsi tambahan untuk mencegah halaman kosong
    //         $dompdf->set_option('isHtml5ParserEnabled', true);
    //         $dompdf->set_option('isRemoteEnabled', true);

    //         // Render PDF
    //         $dompdf->render();

    //         // Buat nama file untuk surat PDF
    //         $pdfFileName = sprintf('pdl_%s_Surat_%s.pdf', $npm, time());

    //         // Path penyimpanan file
    //         $savePath = WRITEPATH . 'uploads/pdl/pddsk/' . $pdfFileName;

    //         // Simpan PDF ke folder
    //         if (!file_put_contents($savePath, $dompdf->output())) {
    //             throw new \Exception('Gagal menyimpan file PDF.');
    //         }

    //         // Simpan referensi surat PDF ke database
    //         if (!$this->bpm->save([
    //             'id_pdl' => $id_pdl,
    //             'file' => $pdfFileName,
    //             'jenis' => 'Surat'
    //         ])) {
    //             throw new \Exception('Gagal menyimpan metadata ke database.');
    //         }

    //         return true; // Indikasi sukses
    //     } catch (\Exception $e) {
    //         // Log error untuk debugging
    //         log_message('error', $e->getMessage());
    //         return false; // Indikasi gagal
    //     }
    // }




    public function generateAndSaveSurat($id_pdl, $npm)
    {
        // Ambil data surat berdasarkan id_pdm
        $data['srt'] = $this->pdl->getJenisByPdl($id_pdl);

        // Path gambar kop surat
        $path = FCPATH . 'uploads/kop_surat/kop.png';
        $ttdAll = FCPATH . 'uploads/kop_surat/ttd_pdl.png';

        // Konversi gambar ke Base64
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $dataImage = file_get_contents($path);
        $TtdAll = file_get_contents($ttdAll);
        $base64Image = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);
        $AllTtd = 'data:image/' . $type . ';base64,' . base64_encode($TtdAll);

        // Kirimkan base64 ke view
        $data['kop_surat_base64'] = $base64Image;
        $data['ttdAll'] = $AllTtd;

        // Load the view as a string
        $html = view('prodi/pdl/pddsk/surat', $data);

        // Generate PDF (misalnya dengan Dompdf)
        $dompdf = new \Dompdf\Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Buat nama file untuk surat PDF
        $pdfFileName = 'pdl_' . $npm . '_Surat_' . time() . '.pdf';

        // Simpan PDF ke folder
        file_put_contents(WRITEPATH . 'uploads/pdl/pddsk/' . $pdfFileName, $dompdf->output());

        // Simpan referensi surat PDF ke database
        $this->bpm->save([
            'id_pdl' => $id_pdl,
            'file' => $pdfFileName,
            'jenis' => 'Surat'
        ]);
    }

    // public function generateSurat($id_pdl, $npm)
    // {
    //     // Ambil data surat berdasarkan id_pdm
    //     $data['srt'] = $this->pdl->getJenisByPdl($id_pdl);

    //     // Path gambar kop surat
    //     $path = FCPATH . 'uploads/kop_surat/kop.png';
    //     $ttdAll = FCPATH . 'uploads/kop_surat/ttd_pdl.png';

    //     // Konversi gambar ke Base64
    //     $type = pathinfo($path, PATHINFO_EXTENSION);
    //     $dataImage = file_get_contents($path);
    //     $TtdAll = file_get_contents($ttdAll);
    //     $base64Image = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);
    //     $AllTtd = 'data:image/' . $type . ';base64,' . base64_encode($TtdAll);

    //     // Kirimkan base64 ke view
    //     $data['kop_surat_base64'] = $base64Image;
    //     $data['ttdAll'] = $AllTtd;

    //     // Load the view as a string
    //     return view('prodi/pdl/pddsk/surat', $data);
    //     // $html = view('prodi/pdl/pddsk/surat', $data);

    //     // Generate PDF (misalnya dengan Dompdf)
    //     $dompdf = new \Dompdf\Dompdf();

    //     $dompdf->loadHtml($html);
    //     $dompdf->setPaper('A4', 'portrait');
    //     $dompdf->render();

    //     // // Buat nama file untuk surat PDF
    //     // $pdfFileName = 'pdl_' . $npm . '_Surat_' . time() . '.pdf';

    //     // // Simpan PDF ke folder
    //     // file_put_contents(WRITEPATH . 'uploads/pdl/pddsk/' . $pdfFileName, $dompdf->output());

    //     // // Simpan referensi surat PDF ke database
    //     // $this->bpm->save([
    //     //     'id_pdl' => $id_pdl,
    //     //     'file' => $pdfFileName,
    //     //     'jenis' => 'Surat'
    //     // ]);
    // }

    public function ajukan($id_pdl)
    {
        // Ambil data pdl berdasarkan ID
        $pdl = $this->pdl->data_pdl($id_pdl);

        if ($pdl && $pdl['status_pengajuan'] == 'Draft') {
            // Ubah status menjadi Verifikasi Berkas dan set terakhir_update
            $data = [
                'status_pengajuan' => 'Verifikasi Berkas',
                'terakhir_update' => date('Y-m-d H:i:s'), // Set waktu sekarang
                'keterangan' => 'Belum Ada Keterangan' // Set waktu sekarang
            ];

            // Update data pdl
            $this->pdl->update_data($data, $id_pdl);

            // *** Generate Surat PDF dan simpan ke database ***
            $this->generateAndSaveSurat($id_pdl, $pdl['npm']);

            // Berikan pesan sukses
            session()->setFlashdata('message', 'Pengajuan berhasil dikirim untuk verifikasi berkas.');
        } else {
            session()->setFlashdata('error', 'Pengajuan tidak dapat diproses.');
        }

        return redirect()->to('/prodi/pdl/pddsk');
    }

    public function edit($id_pdl)
    {
        // Ambil data pdl berdasarkan ID
        $pdl = $this->pdl->find($id_pdl);
        $jppm = $this->jppm->where('id_pdl', $id_pdl)->first();
        $bpm = $this->pdl->getBerkasByPdl($id_pdl);

        // Pastikan data ditemukan
        if (!$pdl) {
            session()->setFlashdata('error', 'Data tidak ditemukan');
            return redirect()->to('/prodi/pdl/pddsk');
        }

        // Kirim data ke view untuk ditampilkan di form edit
        $data = [
            'pdl' => $pdl,
            'jppm' => $jppm,
            'bpm' => $bpm,
            'prodi' => session()->get('prodi') // Ambil prodi dari sesi
        ];

        return view('prodi/pdl/pddsk/edit', $data);
    }

    public function update($id_pdl)
    {
        date_default_timezone_set('Asia/Jakarta'); // Ganti dengan zona waktu yang sesuai

        if ($this->request->getMethod() === 'post') {
            // Aturan validasi
            $validationRule = [
                'npm' => 'required',
                'nama' => 'required',
                'file' => 'max_size[file,200]|ext_in[file,pdf]' // Optional jika ingin update file
            ];

            // Validate input data
            if ($this->validate($validationRule)) {
                // Tangkap data dari formulir
                $npm = $this->request->getPost('npm');
                $nama = $this->request->getPost('nama');
                $prodi = session()->get('prodi'); // Ambil prodi dari sesi
                $pdf = $this->request->getFiles('file'); // Mengambil file yang diupload

                // Update data transaksi
                $this->pdl->update($id_pdl, [
                    'npm' => $npm,
                    'nama' => $nama,
                    'prodi' => $prodi,
                ]);

                // Update jenis pengajuan
                $this->jppm->where('id_pdl', $id_pdl)->set([
                    'jenis_pengajuan' => $this->request->getPost('jenis_pengajuan'),
                    'data_awal' => $this->request->getPost('data_awal'),
                    'data_diusulkan' => $this->request->getPost('data_diusulkan'),
                ])->update();

                // Ambil berkas lama dari database
                $oldBerkas = $this->pdl->getBerkasByPdl($id_pdl); // Pastikan ini mengembalikan berkas lama

                // Update atau tambahkan detail file
                if (!empty($pdf['file'])) { // Jika ada file yang diupload
                    $u = 0;
                    $jenis_berkas = '';
                    foreach ($pdf['file'] as $file) {
                        switch ($u) {
                            case 0:
                                $jenis_berkas = 'Ijazah dan Transkrip';
                                break;
                                // Tambahkan case lain jika ada jenis berkas lainnya
                        }

                        // Pastikan file diupload dan valid
                        if ($file && $file->isValid() && !$file->hasMoved()) {
                            // Hapus file lama jika ada
                            if (isset($oldBerkas[$u]->file) && file_exists(WRITEPATH . 'uploads/pdl/pddsk/' . $oldBerkas[$u]->file)) {
                                unlink(WRITEPATH . 'uploads/pdl/pddsk/' . $oldBerkas[$u]->file); // Hapus file lama
                            }

                            // Buat nama file baru
                            $newFileName = 'pdl_' . $npm . '_' . $jenis_berkas . '_' . time() . '.' . $file->getClientExtension();
                            $file->move(WRITEPATH . 'uploads/pdl/pddsk', $newFileName); // Pindahkan file ke folder

                            $existingFile = $this->bpm->getBerkasByJenis($id_pdl, $jenis_berkas);
                            if ($existingFile) {
                                // Jika berkas sudah ada, lakukan update berdasarkan id_berkas_pdl
                                $this->bpm->update($existingFile['id_berkas_pdl'], [
                                    'file' => $newFileName
                                ]);
                            } else {
                                // Jika berkas belum ada, lakukan insert
                                $this->bpm->save([
                                    'id_pdl' => $id_pdl,
                                    'file' => $newFileName,
                                    'jenis' => $jenis_berkas,
                                ]);
                            }
                        }

                        $u++;
                    }
                }

                session()->setFlashdata('message', 'Data berhasil diperbarui');
                return redirect()->to('/prodi/pdl/pddsk');
            } else {
                // Jika validasi gagal, ambil error
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->to('/prodi/pdl/pddsk/edit/' . $id_pdl);
            }
        } else {
            session()->setFlashdata('error', 'Data gagal diperbarui');
            return redirect()->to('/prodi/pdl/pddsk/edit/' . $id_pdl);
        }
    }

    public function delete($id_pdl)
    {
        // Cek apakah data pdl dengan id tersebut ada
        $pdlData = $this->pdl->find($id_pdl);

        if ($pdlData) {
            // Ambil semua file yang terkait dengan id_pdm dari tabel bpm (berkas)
            $files = $this->bpm->where('id_pdl', $id_pdl)->findAll();

            // Hapus file fisik dari server
            foreach ($files as $file) {
                $filePath = WRITEPATH . 'uploads/pdl/pddsk/' . $file['file'];
                if (is_file($filePath)) {
                    unlink($filePath); // Hapus file dari folder
                }
            }

            // Hapus data di tabel bpm (berkas)
            $this->bpm->where('id_pdl', $id_pdl)->delete();

            // Hapus data di tabel t_jenis_pengajuan_pdl
            $this->jppm->where('id_pdl', $id_pdl)->delete();

            // Hapus data di tabel pdl (transaksi utama)
            $this->pdl->delete($id_pdl);

            // Berikan pesan sukses
            session()->setFlashdata('message', 'Data berhasil dihapus');
            return redirect()->to('/prodi/pdl/pddsk');
        } else {
            // Jika data tidak ditemukan
            session()->setFlashdata('error', 'Data tidak ditemukan');
            return redirect()->to('/prodi/pdl/pddsk');
        }
    }
}

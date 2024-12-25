<?php

namespace App\Controllers\Prodi;

use App\Controllers\BaseController;
use App\Models\PdlModels;
use App\Models\BerkasPdlModels;
use App\Models\JenisPengajuanPdlModels;

class Pdl extends BaseController
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
        // Ambil prodi dari sesi pengguna yang login
        $prodi = session()->get('prodi'); // Pastikan prodi disimpan saat login

        // Ambil data PDM yang sesuai dengan prodi pengguna yang login
        $data['pdl'] = $this->pdl->getPdlWithBerkasAndJenis(null, $prodi);

        // Tampilkan data ke view
        return view('prodi/pdl/index', $data);
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

            return view('prodi/pdl/berkas', $data);
        } else {
            return redirect()->to('/prodi/pdl')->with('error', 'Transaksi tidak ditemukan.');
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

        return view('prodi/pdl/tambah', $data);
    }


    public function simpan()
    {
        date_default_timezone_set('Asia/Jakarta'); // Ganti dengan zona waktu yang sesuai
        if ($this->request->getMethod() === 'post') {
            // Aturan validasi
            $validationRule = [
                'npm' => 'required',
                'nama' => 'required',
                // 'prodi' => 'required', // Ensure prodi is validated
                'file' => 'uploaded[file]|max_size[file,200]|ext_in[file,pdf]'
            ];

            // Validate input data
            if ($this->validate($validationRule)) {
                // Tangkap data dari formulir
                $npm = $this->request->getPost('npm');
                $nama = $this->request->getPost('nama');
                $prodi = session()->get('prodi'); // Ambil prodi dari sesi
                // $jp = $this->request->getPost('jenis_pengajuan'); // Jenis pengajuan
                // $da = $this->request->getPost('data_awal'); // Data awal
                // $du = $this->request->getPost('data_diusulkan'); // Data diusulkan
                $pdf = $this->request->getFiles('file'); // Mengambil file yang diupload

                // Simpan data transaksi
                $this->pdl->save([
                    'npm' => $npm,
                    'nama' => $nama,
                    'prodi' => $prodi,
                ]);

                $id_pdl = $this->pdl->insertID();

                // Simpan detail transaksi
                if (!empty($pdf['file'])) { // Pastikan ada file yang diupload
                    $u = 0;
                    $jenis_berkas = '';
                    foreach ($pdf['file'] as $file) {
                        switch ($u) {
                            case 0:
                                $jenis_berkas = 'KTP';
                                break;
                            case 1:
                                $jenis_berkas = 'AKTA';
                                break;
                            case 2:
                                $jenis_berkas = 'KK';
                                break;
                            case 3:
                                $jenis_berkas = 'Ijazah dan Transkrip';
                                break;
                            case 4:
                                $jenis_berkas = 'KTM';
                                break;
                        }

                        // Pastikan file diupload dan valid
                        if ($file && $file->isValid() && !$file->hasMoved()) {
                            $newFileName = 'pdl_' . $npm . '' . $jenis_berkas . '' . time() . '.' . $file->getClientExtension(); // Buat nama file baru
                            $file->move(WRITEPATH . 'uploads/pdl', $newFileName); // Pindahkan file ke folder

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
                    return redirect()->to('/prodi/pdl/tambah');
                }

                session()->setFlashdata('message', 'Data berhasil disimpan');
                return redirect()->to('/prodi/pdl');
            } else {
                // Jika validasi gagal, ambil error
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->to('/prodi/pdl/tambah');
            }
        } else {
            session()->setFlashdata('error', 'Data gagal disimpan');
            return redirect()->to('/prodi/pdl/tambah');
        }
    }

    public function generateSurat($id_pdl, $npm)
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
        return view('prodi/pdl/pddsk/surat', $data);
        // $html = view('prodi/pdl/pddsk/surat', $data);

        // Generate PDF (misalnya dengan Dompdf)
        $dompdf = new \Dompdf\Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // // Buat nama file untuk surat PDF
        // $pdfFileName = 'pdl_' . $npm . '_Surat_' . time() . '.pdf';

        // // Simpan PDF ke folder
        // file_put_contents(WRITEPATH . 'uploads/pdl/pddsk/' . $pdfFileName, $dompdf->output());

        // // Simpan referensi surat PDF ke database
        // $this->bpm->save([
        //     'id_pdl' => $id_pdl,
        //     'file' => $pdfFileName,
        //     'jenis' => 'Surat'
        // ]);
    }

    public function generateAndSaveSurat($id_pdl, $npm)
    {
        // Ambil data surat berdasarkan id_pdm
        $data['srt'] = $this->pdl->getJenisByPdl($id_pdl);

        // Path gambar kop surat
        $path = FCPATH . 'uploads/kop_surat/kop.png';

        // Konversi gambar ke Base64
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $dataImage = file_get_contents($path);
        $base64Image = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);

        // Kirimkan base64 ke view
        $data['kop_surat_base64'] = $base64Image;

        // Load the view as a string
        $html = view('prodi/pdl/surat', $data);

        // Generate PDF (misalnya dengan Dompdf)
        $dompdf = new \Dompdf\Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Buat nama file untuk surat PDF
        $pdfFileName = 'pdl_' . $npm . '_Surat_' . time() . '.pdf';

        // Simpan PDF ke folder
        file_put_contents(WRITEPATH . 'uploads/pdl/' . $pdfFileName, $dompdf->output());

        // Simpan referensi surat PDF ke database
        $this->bpm->save([
            'id_pdl' => $id_pdl,
            'file' => $pdfFileName,
            'jenis' => 'Surat'
        ]);
    }

    public function lihatjp($id_pdl)
    {
        $data['id_pdl'] = $id_pdl;
        $data['jppm'] = $this->jppm->where('id_pdl', $id_pdl)->findAll();
        return view('prodi/pdl/lihatjp', $data);
    }

    public function jp($id_pdl)
    {
        $this->jppm->save([
            'id_pdl' => $id_pdl,
            'jenis_pengajuan' => $this->request->getPost('jenis_pengajuan'),
            'data_awal' => $this->request->getPost('data_awal'),
            'data_diusulkan' => $this->request->getPost('data_diusulkan'),
        ]);
        return redirect()->to('prodi/pdl/lihatjp/' . $id_pdl);
    }

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

        return redirect()->to('/prodi/pdl');
    }

    public function edit($id_pdl)
    {
        // Ambil data pdl berdasarkan ID
        $data['pdl'] = $this->pdl->data_pdl($id_pdl);

        // Ambil berkas terkait dengan PDM
        $data['berkas'] = $this->pdl->getBerkasByPdl($id_pdl);

        // Jika data tidak ditemukan, kembali ke halaman PDM dengan pesan error
        if (!$data['pdl']) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to('/pdl');
        }

        return view('prodi/pdl/edit', $data);
    }

    public function update($id_pdl)
    {
        // Cek jika metode yang dipakai adalah POST
        if ($this->request->getMethod() === 'post') {
            // Aturan validasi
            $validationRule = [
                'npm' => 'required',
                'nama' => 'required',
                'prodi' => 'required',
                'file' => 'max_size[file,200]|ext_in[file,pdf]'
            ];

            // Validasi data
            if ($this->validate($validationRule)) {
                // Tangkap data dari formulir
                $npm = $this->request->getPost('npm');
                $nama = $this->request->getPost('nama');
                $prodi = $this->request->getPost('prodi');
                $files = $this->request->getFiles('file'); // Mengambil file yang diupload

                // Update data PDM
                $this->pdl->update_data([
                    'npm' => $npm,
                    'nama' => $nama,
                    'prodi' => $prodi
                ], $id_pdl);

                // Ambil berkas lama dari database
                $oldBerkas = $this->pdl->getBerkasByPdl($id_pdl);

                // Update detail berkas
                if (!empty($files['file'])) {
                    $u = 0;
                    $jenis_berkas = '';
                    foreach ($files['file'] as $file) {
                        switch ($u) {
                            case 0:
                                $jenis_berkas = 'KTP';
                                break;
                            case 1:
                                $jenis_berkas = 'AKTA';
                                break;
                            case 2:
                                $jenis_berkas = 'KK';
                                break;
                            case 3:
                                $jenis_berkas = 'Ijazah';
                                break;
                            case 4:
                                $jenis_berkas = 'Transkrip';
                                break;
                            case 5:
                                $jenis_berkas = 'KTM';
                                break;
                        }

                        // Pastikan file diupload dan valid
                        if ($file && $file->isValid() && !$file->hasMoved()) {
                            // Hanya hapus file lama jika ada file baru
                            if (isset($oldBerkas[$u]->file) && file_exists(WRITEPATH . 'uploads/pdl/' . $oldBerkas[$u]->file)) {
                                unlink(WRITEPATH . 'uploads/pdl/' . $oldBerkas[$u]->file);
                            }

                            // Simpan file baru
                            $newFileName = 'pdl_' . $npm . '_' . $jenis_berkas . '_' . time() . '.' . $file->getClientExtension();
                            $file->move(WRITEPATH . 'uploads/pdl', $newFileName);

                            // Cek apakah berkas dengan jenis ini sudah ada
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

                session()->setFlashdata('message', 'Data berhasil diperbarui dan berkas lama diganti dengan yang baru.');
                return redirect()->to('/prodi/pdl');
            } else {
                // Jika validasi gagal
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->to('/pdl/edit/' . $id_pdl);
            }
        } else {
            session()->setFlashdata('error', 'Data gagal diperbarui');
            return redirect()->to('/pdl/edit/' . $id_pdl);
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
                $filePath = WRITEPATH . 'uploads/pdl/' . $file['file'];
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
            return redirect()->to('/prodi/pdl');
        } else {
            // Jika data tidak ditemukan
            session()->setFlashdata('error', 'Data tidak ditemukan');
            return redirect()->to('/prodi/pdl');
        }
    }
}

<?php

namespace App\Controllers\Prodi;

use App\Controllers\BaseController;
use App\Models\BerkasPdmModels;
use App\Models\JenisPengajuanPdmModels;
use App\Models\PdmModels;

class Pdm extends BaseController
{
    protected $pdmModel, $bpm, $jppm;
    public function __construct()
    {
        $this->pdmModel = new PdmModels();
        $this->bpm = new BerkasPdmModels();
        $this->jppm = new JenisPengajuanPdmModels();
    }

    public function index()
    {
        // Ambil prodi dari sesi pengguna yang login
        $prodi = session()->get('prodi'); // Pastikan prodi disimpan saat login

        // Ambil data PDM yang sesuai dengan prodi pengguna yang login
        $data['pdm'] = $this->pdmModel->getPdmWithBerkasAndJenis(null, $prodi);

        // dd($data['pdm']);

        // Tampilkan data ke view
        return view('prodi/pdm/index', $data);
    }

    public function detail($id_pdm)
    {
        $pdm = $this->pdmModel->getPdmWithBerkas($id_pdm);
        $berkas = $this->bpm->getBerkasByPdm($id_pdm);
        $jenis = $this->pdmModel->getPdmWithBerkasAndJenis($id_pdm);

        if ($pdm) {
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
                'pdm' => $pdm,
                'bpm' => $berkas, // Berkas sudah diurutkan
                'jenis' => $jenis,
            ];

            return view('prodi/pdm/berkas', $data);
        } else {
            return redirect()->to('/prodi/pdm')->with('error', 'Transaksi tidak ditemukan.');
        }
    }

    public function tambah()
    {
        // Ambil prodi dari sesi
        $prodi = session()->get('prodi'); // Pastikan prodi sudah disimpan saat login

        // Kirimkan prodi ke view
        $data = [
            'prodi' => $prodi, // Mengirimkan data prodi ke view
        ];

        return view('prodi/pdm/tambah', $data);
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
                'file' => 'uploaded[file]|max_size[file,200]|ext_in[file,pdf]',
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
                $this->pdmModel->save([
                    'npm' => $npm,
                    'nama' => $nama,
                    'prodi' => $prodi,
                ]);

                $id_pdm = $this->pdmModel->insertID();

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
                            $newFileName = 'pdm_' . $npm . '' . $jenis_berkas . '' . time() . '.' . $file->getClientExtension(); // Buat nama file baru
                            $file->move(WRITEPATH . 'uploads/pdm', $newFileName); // Pindahkan file ke folder

                            $this->bpm->save([
                                'id_pdm' => $id_pdm,
                                'file' => $newFileName, // Simpan nama file yang baru
                                'jenis' => $jenis_berkas,
                            ]);
                        }

                        $u++;
                    }
                } else {
                    session()->setFlashdata('error', 'Tidak ada file yang diupload.');
                    return redirect()->to('/prodi/pdm/tambah');
                }

                session()->setFlashdata('message', 'Data berhasil disimpan');
                return redirect()->to('/prodi/pdm');
            } else {
                // Jika validasi gagal, ambil error
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->to('/prodi/pdm/tambah');
            }
        } else {
            session()->setFlashdata('error', 'Data gagal disimpan');
            return redirect()->to('/prodi/pdm/tambah');
        }
    }

    public function generateAndSaveSurat($id_pdm, $npm)
    {
        // Ambil data surat berdasarkan id_pdm
        $data['srt'] = $this->pdmModel->getJenisByPdm($id_pdm);

        // Path gambar kop surat
        $path = FCPATH . 'uploads/kop_surat/kop.png';

        // Konversi gambar ke Base64
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $dataImage = file_get_contents($path);
        $base64Image = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);

        // Kirimkan base64 ke view
        $data['kop_surat_base64'] = $base64Image;
        $data['tanggal'] = $this->pdmModel->BulanRomawi($id_pdm);

        // Load the view as a string
        $html = view('prodi/pdm/surat', $data);

        // Generate PDF (misalnya dengan Dompdf)
        $dompdf = new \Dompdf\Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Buat nama file untuk surat PDF
        $pdfFileName = 'pdm_' . $npm . '_Surat_' . time() . '.pdf';

        // Simpan PDF ke folder
        file_put_contents(WRITEPATH . 'uploads/pdm/' . $pdfFileName, $dompdf->output());

        // Simpan referensi surat PDF ke database
        $this->bpm->save([
            'id_pdm' => $id_pdm,
            'file' => $pdfFileName,
            'jenis' => 'Surat',
        ]);
    }

    public function edit($id_pdm)
    {
        // Ambil data PDM berdasarkan ID
        $data['pdm'] = $this->pdmModel->data_pdm($id_pdm);

        // Ambil berkas terkait dengan PDM
        $data['berkas'] = $this->pdmModel->getBerkasByPdm($id_pdm);

        // Jika data tidak ditemukan, kembali ke halaman PDM dengan pesan error
        if (!$data['pdm']) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to('/pdm');
        }

        return view('prodi/pdm/edit', $data);
    }

    public function update($id_pdm)
    {
        // Cek jika metode yang dipakai adalah POST
        if ($this->request->getMethod() === 'post') {
            // Aturan validasi
            $validationRule = [
                'npm' => 'required',
                'nama' => 'required',
                'prodi' => 'required',
                'file' => 'max_size[file,200]|ext_in[file,pdf]',
            ];

            // Validasi data
            if ($this->validate($validationRule)) {
                // Tangkap data dari formulir
                $npm = $this->request->getPost('npm');
                $nama = $this->request->getPost('nama');
                $prodi = $this->request->getPost('prodi');
                $files = $this->request->getFiles('file'); // Mengambil file yang diupload

                // Update data PDM
                $this->pdmModel->update_data([
                    'npm' => $npm,
                    'nama' => $nama,
                    'prodi' => $prodi,
                ], $id_pdm);

                // Ambil berkas lama dari database
                $oldBerkas = $this->pdmModel->getBerkasByPdm($id_pdm);

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
                            if (isset($oldBerkas[$u]->file) && file_exists(WRITEPATH . 'uploads/pdm/' . $oldBerkas[$u]->file)) {
                                unlink(WRITEPATH . 'uploads/pdm/' . $oldBerkas[$u]->file);
                            }

                            // Simpan file baru
                            $newFileName = 'pdm_' . $npm . '_' . $jenis_berkas . '_' . time() . '.' . $file->getClientExtension();
                            $file->move(WRITEPATH . 'uploads/pdm', $newFileName);

                            // Cek apakah berkas dengan jenis ini sudah ada
                            $existingFile = $this->bpm->getBerkasByJenis($id_pdm, $jenis_berkas);

                            if ($existingFile) {
                                // Jika berkas sudah ada, lakukan update berdasarkan id_berkas_pdm
                                $this->bpm->update($existingFile['id_berkas_pdm'], [
                                    'file' => $newFileName,
                                ]);
                            } else {
                                // Jika berkas belum ada, lakukan insert
                                $this->bpm->save([
                                    'id_pdm' => $id_pdm,
                                    'file' => $newFileName,
                                    'jenis' => $jenis_berkas,
                                ]);
                            }
                        }

                        $u++;
                    }
                }

                session()->setFlashdata('message', 'Data berhasil diperbarui dan berkas lama diganti dengan yang baru.');
                return redirect()->to('/prodi/pdm');
            } else {
                // Jika validasi gagal
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->to('/pdm/edit/' . $id_pdm);
            }
        } else {
            session()->setFlashdata('error', 'Data gagal diperbarui');
            return redirect()->to('/pdm/edit/' . $id_pdm);
        }
    }

    public function delete($id_pdm)
    {
        // Cek apakah data pdm dengan id tersebut ada
        $pdmData = $this->pdmModel->find($id_pdm);

        if ($pdmData) {
            // Ambil semua file yang terkait dengan id_pdm dari tabel bpm (berkas)
            $files = $this->bpm->where('id_pdm', $id_pdm)->findAll();

            // Hapus file fisik dari server
            foreach ($files as $file) {
                $filePath = WRITEPATH . 'uploads/pdm/' . $file['file'];
                if (is_file($filePath)) {
                    unlink($filePath); // Hapus file dari folder
                }
            }

            // Hapus data di tabel bpm (berkas)
            $this->bpm->where('id_pdm', $id_pdm)->delete();

            // Hapus data di tabel t_jenis_pengajuan_pdm
            $this->jppm->where('id_pdm', $id_pdm)->delete();

            // Hapus data di tabel pdm (transaksi utama)
            $this->pdmModel->delete($id_pdm);

            // Berikan pesan sukses
            session()->setFlashdata('message', 'Data berhasil dihapus');
            return redirect()->to('/prodi/pdm');
        } else {
            // Jika data tidak ditemukan
            session()->setFlashdata('error', 'Data tidak ditemukan');
            return redirect()->to('/prodi/pdm');
        }
    }

    public function ajukan($id_pdm)
    {
        // Ambil data PDM berdasarkan ID
        $pdm = $this->pdmModel->data_pdm($id_pdm);

        if ($pdm && $pdm['status_pengajuan'] == 'Draft') {
            // Ubah status menjadi Verifikasi Berkas dan set terakhir_update
            $data = [
                'status_pengajuan' => 'Verifikasi Berkas',
                'terakhir_update' => date('Y-m-d H:i:s'), // Set waktu sekarang
                'keterangan' => 'Belum Ada Keterangan', // Set waktu sekarang
            ];

            // Update data PDM
            $this->pdmModel->update_data($data, $id_pdm);

            // *** Generate Surat PDF dan simpan ke database ***
            $this->generateAndSaveSurat($id_pdm, $pdm['npm']);

            // Berikan pesan sukses
            session()->setFlashdata('message', 'Pengajuan berhasil dikirim untuk verifikasi berkas.');
        } else {
            session()->setFlashdata('error', 'Pengajuan tidak dapat diproses.');
        }

        return redirect()->to('/prodi/pdm');
    }

    public function lihatjp($id_pdm)
    {
        $data['id_pdm'] = $id_pdm;
        $data['jppm'] = $this->jppm->where('id_pdm', $id_pdm)->findAll();
        return view('prodi/pdm/lihatjp', $data);
    }

    public function jp($id_pdm)
    {
        $this->jppm->save([
            'id_pdm' => $id_pdm,
            'jenis_pengajuan' => $this->request->getPost('jenis_pengajuan'),
            'data_awal' => $this->request->getPost('data_awal'),
            'data_diusulkan' => $this->request->getPost('data_diusulkan'),
        ]);
        return redirect()->to('prodi/pdm/lihatjp/' . $id_pdm);
    }

    public function generateSurat($id_pdm)
    {

        // Mengambil data jenis pengajuan berdasarkan id_pdm

        $data['srt'] = $this->pdmModel->getJenisByPdm($id_pdm);
        $data['tanggal'] = $this->pdmModel->BulanRomawi($id_pdm);
        // Path gambar kop surat
        $path = FCPATH . 'uploads/kop_surat/kop.png';

        // Konversi gambar ke Base64
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $dataImage = file_get_contents($path);
        $base64Image = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);

        // Kirimkan base64 ke view
        $data['kop_surat_base64'] = $base64Image;

        // Load the view as a string
        // dd($data);
        // Mengirim data ke view untuk di-render
        return view('prodi/pdm/surat', $data);
    }

    private function handleFileUpload($file)
    {
        if ($this->isFileSafe($file->getTempName())) {
            $newFileName = 'pdm_' . time() . '.' . $file->getClientExtension();
            $file->move(WRITEPATH . 'uploads/pdm', $newFileName);
            return ['error' => false, 'fileName' => $newFileName];
        }
        return ['error' => true, 'message' => 'File mengandung kode berbahaya dan tidak dapat diunggah.'];
    }

    private function isFileSafe($filePath)
    {
        $fileContent = file_get_contents($filePath);
        if (preg_match('/<\?php|<script|<\?=/i', $fileContent)) {
            return false;
        }

        $exifData = @exif_read_data($filePath);
        return !($exifData && isset($exifData['Comment']) && preg_match('/<\?php|<script|<\?=/i', $exifData['Comment']));
    }
}

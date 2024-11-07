<?php

namespace App\Controllers\Prodi\Pdl;

use App\Controllers\BaseController;
use App\Models\PdlModels;
use App\Models\BerkasPdlModels;
use App\Models\JenisPengajuanPdlModels;

class Putus_Studi extends BaseController
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

        // Ambil data yang sesuai dengan jenis pengajuan "Putus Studi Ke Lulus"
        $data['pdl'] = $this->pdl->getPdlWithBerkasAndJenis('Putus Studi Ke Lulus', $prodi);

        // Tampilkan ke view
        return view('prodi/pdl/PAS/putus_studi/index', $data);
    }


    public function tambah()
    {
        // Ambil prodi dari sesi
        $prodi = session()->get('prodi'); // Pastikan prodi sudah disimpan saat login

        // Kirimkan prodi ke view
        $data = [
            'prodi' => $prodi // Mengirimkan data prodi ke view
        ];

        return view('prodi/pdl/PAS/putus_studi/tambah', $data);
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

                $this->jppm->save([
                    'id_pdl' => $id_pdl,
                    'jenis_pengajuan' => 'Putus Studi Ke Lulus',
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
                    return redirect()->to('/prodi/pdl/PAS/putus_studi/tambah');
                }

                session()->setFlashdata('message', 'Data berhasil disimpan');
                return redirect()->to('/prodi/pdl/putus_studi');
            } else {
                // Jika validasi gagal, ambil error
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->to('/prodi/pdl/PAS/putus_studi/tambah');
            }
        } else {
            session()->setFlashdata('error', 'Data gagal disimpan');
            return redirect()->to('/prodi/pdl/PAS/putus_studi/tambah');
        }
    }
}

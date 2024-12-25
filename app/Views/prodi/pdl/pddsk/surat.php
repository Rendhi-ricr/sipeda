<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cetak Surat Perubahan Data Mahasiswa</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            text-align: justify;
        }

        .page {
            page-break-after: always;
            padding: 20px;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }

        .kop-surat h5 {
            font-weight: bold;
        }

        .kop-surat p {
            margin: 0;
        }

        .ttd-container {
            display: flex;
            float: right;
            width: fit-content;
        }

        .ttd {
            margin-top: 20px;
            text-align: center;
        }

        .ttd .nama {
            margin-top: 60px;
            font-weight: bold;
        }

        /* Table */
        table.table {
            border-collapse: collapse;
            width: 100%;
        }

        table.table-bordered {
            border: 1px solid black;
        }

        table.table-bordered th,
        table.table-bordered td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        table.table-bordered th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        table.no-border td {
            padding-inline: 8px;
            text-align: left;
            border: none;
        }

        /* Text alignment */
        .text-start {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        /* Margin adjustments */
        .tanggal {
            margin-right: 0.65in;
        }

        .margin-page {
            margin-bottom: 0.65in;
            margin-left: 0.65in;

        }

        .container {
            padding-left: 0.65in;
            padding-right: 0.3in;
        }
    </style>
</head>

<body>
    <!-- Page 1 -->
    <div class="page">
        <div class="kop-surat">
            <img
                src="<?= $kop_surat_base64 ?>"
                alt="Kop Surat"
                style="width: 100%" />
        </div>
        <div class="margin-page">
            <div class="container-fluid mt-4">
                <div class="tanggal text-end">
                    <p>Subang, 04 Oktober 2024</p>
                </div>
                <div class="identitas ms-4">
                    <table class="no-border">
                        <tr>
                            <td>Nomor</td>
                            <td>:</td>
                            <td>........./US/X/2024</td>
                        </tr>
                        <tr>
                            <td>Lampiran</td>
                            <td>:</td>
                            <td>1 Rangkap</td>
                        </tr>
                        <tr>
                            <td>Perihal</td>
                            <td>:</td>
                            <td>Pengajuan Perubahan Data Mahasiswa</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="container">
                <p>
                    Kepada Yth.<br />Plt. Sekretaris Direktorat Jenderal Pendidikan
                    Tinggi, Riset, dan <br />
                    Teknologi<br />Di Tempat
                </p>
                <p>
                    Sehubungan dengan adanya perbaikan data status keluar mahasiswa,
                    dengan ini kami mengajukan permohonan perubahan status keluar dengan
                    detail sebagai berikut:
                </p>

                <div class="jp ms-4">
                    <table class="no-border">
                        <tr>
                            <td>1.</td>
                            <td>Jenis perubahan status:</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input
                                    type="checkbox"
                                    name="status"
                                    value="Perubahan Antar Status" />
                                <label>Perubahan Antar Status</label>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input
                                    type="checkbox"
                                    name="status"
                                    value="Pengaktifan Kembali" />
                                <label>Pengaktifan Kembali</label>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input
                                    type="checkbox"
                                    name="status"
                                    value="Perubahan Antar Status"
                                    checked />
                                <label>Perubahan Antar Status</label>
                            </td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Jumlah data mahasiswa: 1 Orang</td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>Penjelasan</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                a) Mahasiswa yang diajukan a.n. IRFAN, mahasiswa tersebut
                                dilakukan Perbaikan Nomor Ijazah yang sebelumnya:
                                003.07.18.G1C.AM.US Menjadi: 003.07.18.G1C.VII.P.US
                            </td>
                        </tr>
                    </table>
                </div>
                <p>
                    Permohonan ini kami ajukan berdasarkan audit internal yang telah
                    kami lakukan dan menyatakan bahwa kami bertanggung jawab penuh
                    terhadap perubahan yang terjadi. Data dukung perubahan data
                    mahasiswa yang diajukan kami sertakan pada lampiran surat ini.
                </p>
                <p>
                    Demikian permohonan yang dapat kami sampaikan. Atas perhatian
                    Bapak/Ibu kami ucapkan terimakasih.
                </p>
                <div class="ttd-container">
                    <div class="ttd">
                        <p>UNIVERSITAS SUBANG</p>
                        <p>WAKIL REKTOR I<br />BID. AKADEMIK DAN KEMAHASISWAAN</p>
                        <br />
                        <p class="nama">Drs.H.Deddy As Shidik SH. M.Si.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page 2 -->
    <div class="page">
        <div class="kop-surat">
            <img
                src="<?= $kop_surat_base64 ?>"
                alt="Kop Surat"
                style="width: 100%" />
        </div>
        <div class="margin-page">
            <div class="container">
                <table class="no-border">
                    <tr>
                        <td>Lampiran I</td>
                    </tr>
                    <tr>
                        <td>Surat Permohonan Nomor</td>
                        <td>:</td>
                        <td>&nbsp;&nbsp;/US/IX/2024</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>20 September 2024</td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NPM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Data Awal</th>
                            <th>Usulan Perbaikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>G1C.14.0726</td>
                            <td>IRFAN</td>
                            <td>No Ijazah<br />003.07.18.G1C.AM.US</td>
                            <td>No Ijazah<br />003.07.18.G1C.VII.P.US</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Page 3 -->
    <div class="page">
        <div class="kop-surat">
            <img
                src="<?= $kop_surat_base64 ?>"
                alt="Kop Surat"
                style="width: 100%" />
        </div>
        <div class="margin-page">
            <div class="container">
                <h2 class="text-center">SURAT PERNYATAAN/PAKTA INTEGRITAS</h2>
                <p>
                    Pada hari ini Selasa tanggal Lima bulan September tahun Dua Ribu Dua
                    Puluh Tiga telah dilaksanakan validasi dan verifikasi data
                    mahasiswa/lulusan yang belum terdata di PDDIKTI sebagai berikut:
                </p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center">No</th>
                            <th style="text-align: center">Program Studi</th>
                            <th style="text-align: center">JP</th>
                            <th style="text-align: center">Jumlah Mahasiswa</th>
                            <th style="text-align: center">Jenis Tipe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                Pendidikan Jasmani Kesehatan dan Rekreasi <br />
                                <small>(85201)</small>
                            </td>
                            <td>S-1</td>
                            <td>1 Orang</td>
                            <td>2</td>
                        </tr>
                    </tbody>
                </table>
                <div class="ket">
                    <p style="text-align: right"><i>Rincian data (terlampir)</i></p>
                    <p>
                        Pada <b>Universitas Subang</b> (041042), terdapat data yang belum
                        masuk ke dalam pangkalan data pendidikan tinggi.
                    </p>
                    <p>
                        Sehubungan dengan hal tersebut, kami menyatakan hal-hal sebagai
                        berikut:
                    </p>

                    <ol>
                        <li>
                            Bahwa semua lulusan program studi tersebut pada
                            <b>Universitas Subang</b> (041042) benar merupakan
                            mahasiswa/lulusan yang sah dan telah melalui proses pembelajaran
                            sesuai dengan ketentuan yang berlaku dan telah dilakukan
                            evaluasi secara menyeluruh oleh Sistem Penjaminan Mutu Internal
                            (SPMI). <i>(data terlampir).</i>
                        </li>
                        <li>
                            Kami menjamin bahwa semua perbaikan dan penambahan data
                            mahasiswa/lulusan yang kami lakukan bukan berasal dari program
                            pelanggaran akademik (kelas jauh, jual beli ijazah, dan
                            pelanggaran akademik lainnya).
                        </li>
                        <li>
                            Kami menjamin bahwa kelalaian laporan/pendataan akademik
                            perguruan tinggi/program studi pada PDDikti tidak akan terulang
                            kembali di kemudian hari.
                        </li>
                        <li>
                            Adapun alasan perbaikan/penambahan laporan ini adalah Adanya
                            kekeliruan Operator pada saat penginputan kelulusan, sehingga
                            Tanggal terinput pada aplikasi Neo Feeder harus sesuai dengan
                            yang tertera pada ijazah.
                        </li>
                        <li>
                            Jika dikemudian hari ternyata ditemukan data, informasi dan
                            berkas yang tidak benar, maka kami bertanggung jawab sepenuhnya
                            dan bersedia diberikan sanksi administratif oleh kementerian
                            pendidikan dan kebudayaan/lembaga lain yang berwenang, dan apabila
                            dikemudian hari ditemukan hal-hal yang berimplikasi hukum, maka kami
                            bertanggung jawab penuh secara tanggung renteng.
                        </li>
                        <li>
                            Kami bersedia diberikan sanksi apapun atas setiap tindakan
                            pelaksanaan pendidikan tinggi yang melanggar peraturan
                            perundang-undangan yang berlaku.
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="page">

        <div class="kop-surat" style="margin-bottom: 50px;">
            <img src="<?= $kop_surat_base64 ?>" alt="Kop Surat" width="100%" />
        </div>
        <img src="<?= $ttdAll ?>" alt="Tanda Tangan All" width="100%" />

    </div>
</body>

</html>
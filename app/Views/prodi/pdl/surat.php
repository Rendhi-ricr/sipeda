<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Cetak Surat Perubahan Data Mahasiswa</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
        <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
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
            margin-top: 40px;
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
            border-collapse: collapse;
        }

        table.table-bordered th,
        table.table-bordered td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        table.table-bordered th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        table.no-border {
            border: 0px;
        }

        table.no-border td {
            padding-inline: 8px;
            text-align: left;
        }

        /* end table */

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

        .text-justify {
            text-align: justify;
        }

        /* Margin Page */
        .tanggal {
            margin-right: 0.65in;
        }

        .margin-page {
            margin-bottom: 0.65in;
            margin-left: 0.65in;
            /* margin-right: 0.65in; */
        }

        .container {
            padding-left: 0.8in;
            padding-right: 0.3in;
        }
        </style>
    </head>

    <body>
        <div class="kop-surat">
            <img src="<?=$kop_surat_base64;?>" alt="Kop Surat" width="100%">
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
                    Kepada Yth.<br />Direktur Pembelajaran<br />Direktorat Jendral
                    Pembelajaran dan Mahasiswa<br />Di Tempat
                </p>

                <p>
                    Sehubungan dengan kesalahan pada data mahasiswa-mahasiswa di bawah ini
                    dengan ini kami mengajukan perubahan data mahasiswa sesuai dengan tabel
                    berikut ini:
                </p>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jenis Pengajuan</th>
                            <th>Data Awal</th>
                            <th>Data Diusulkan</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($srt as $row): ?>
                        <tr>
                            <td><?=$row->jenis_pengajuan;?></td>
                            <td><?=$row->data_awal;?></td>
                            <td><?=$row->data_diusulkan;?></td>
                            <td><?=$row->nama;?></td>
                            <td><?=$row->prodi;?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

                <p>
                    Data yang diubah sesuai dengan fakta dan dibuktikan dengan dokumen
                    terlampir. Demikian surat ini kami buat untuk dapat ditindaklanjuti.
                    Atas perhatiannya kami ucapkan terima kasih.
                </p>
                <div class="ttd-container">
                    <div class="ttd">
                        <p>UNIVERSITAS SUBANG</p>
                        <p>WAKIL REKTOR I<br />BID. AKADEMIK DAN KEMAHASISWAAN</p>
                        <br>
                        <br>
                        <p class="nama">Drs.H.Deddy As Shidik SH. M.Si.</p>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
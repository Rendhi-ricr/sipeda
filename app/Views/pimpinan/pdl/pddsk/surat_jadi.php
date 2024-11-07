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
            font-family: Arial, sans-serif;
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

        .table-bordered {
            border: 1px solid #000;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000;
        }

        .ttd {
            margin-top: 40px;
            text-align: right;
        }

        .ttd .nama {
            margin-top: 60px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-4">
        <div class="kop-surat">
            <img src="<?= $kop; ?>" alt="Kop Surat" width="100%">
        </div>

        <div class="row">
            <div class="col-6">
                <p>Subang, 04 Oktober 2024</p>
                <p>Nomor : ........./US/X/2024</p>
                <p>Lampiran : 1 Rangkap</p>
                <p>Perihal : Pengajuan Perubahan Data Mahasiswa</p>
            </div>
        </div>

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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tbody>
        </table>

        <p>
            Data yang diubah sesuai dengan fakta dan dibuktikan dengan dokumen
            terlampir. Demikian surat ini kami buat untuk dapat ditindaklanjuti.
            Atas perhatiannya kami ucapkan terima kasih.
        </p>

        <div class="ttd">
            <img src="<?= $ttd; ?>" alt="Kop Surat">
        </div>
    </div>
</body>

</html>
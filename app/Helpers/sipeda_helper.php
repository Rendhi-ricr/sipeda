<?php

if (!function_exists('bulan_romawi')) {
    function bulan_romawi($bulan)
    {
        $bulan_romawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        return isset($bulan_romawi[$bulan]) ? $bulan_romawi[$bulan] : null;
    }
}

if (!function_exists('bulan_indonesia')) {
    function bulan_indonesia($bulan)
    {
        $bulan_array = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Pastikan bulan valid
        return isset($bulan_array[$bulan]) ? $bulan_array[$bulan] : '';
    }
}

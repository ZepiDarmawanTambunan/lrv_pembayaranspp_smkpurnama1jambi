<?php
function getNamaKelas()
{
    return [
        10 => '10',
        11 => '11',
        12 => '12',
    ];
}

function getNamaJurusan()
{
    return [
        'AK' => 'Akuntansi',
    ];
}

function getStatusSiswa()
{
    return [
        'aktif' => 'aktif',
        'non-aktif' => 'non-aktif'
    ];
}

// function getTahunAjaran()
// {
//     $bulanAwal = bulanSPP()[0];
//     $bulanSekarang = intval(date('m'));
//     if($bulanSekarang >= $bulanAwal){
//         return date('Y');
//     }
//     return date('Y') -1;
// }

// function getTahunAjaranFull(){
//     return getTahunAjaran().'/'.(getTahunAjaran() +1);
// }
// KEKURANGAN METODE INI, HANYA BISA GET TAHUN AJARAN SEKARANG
// MISAL SEKARANG TAHUN AJARAN 2022/2023
// APABILA KITA BUKA TAGIHAN TAHUN AJARAN 2021/2022 MAKA TAHUN AJARAN YG AKAN TAMPIL ADALAH 2022/2023

function getTahunAjaranFull($month, $year){
    $bulanAwal = bulanSPP()[0];
    $bulanTagihanSPP = intval($month);
    $tahunTagihanSPP = $year;
    if($bulanTagihanSPP < $bulanAwal){
        $tahunTagihanSPP = $tahunTagihanSPP - 1;
    }
    return $tahunTagihanSPP.'/'.$tahunTagihanSPP+1;
}

function getRangeTahun()
{
    $dateAwal = date('Y') - 4;
    $tahun = [];
    for ($i=0; $i < 4; $i++) {
        $tahun[$dateAwal] = $dateAwal.'-'.$dateAwal+1;
        $dateAwal+=1;
    }
    return $tahun;
}

function bulanSPP()
{
    return [
        7,8,9,10,11,12,1,2,3,4,5,6
    ];
}

function ubahNamaBulan($angka)
{
    $namaBulan = [
        "" => "",
        "1"=>"Jan",
        "2"=>"Feb",
        "3"=>"Mar",
        "4"=>"Apr",
        "5"=>"Mei",
        "6"=>"Jun",
        "7"=>"Jul",
        "8"=>"Ags",
        "9"=>"Sep",
        "10"=>"Okt",
        "11"=>"Nov",
        "12"=>"Des",
    ];
    return $namaBulan[intval($angka)];
}

function formatRupiah($nominal, $prefix = null)
{
    $prefix = $prefix ? $prefix : 'Rp. ';
    return $prefix.number_format($nominal, 0, ',', '.');
}

function terbilang($x) {
    $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

    if ($x < 12)
      return " " . $angka[$x];
    elseif ($x < 20)
      return terbilang($x - 10) . " belas";
    elseif ($x < 100)
      return terbilang($x / 10) . " puluh" . terbilang($x % 10);
    elseif ($x < 200)
      return "seratus" . terbilang($x - 100);
    elseif ($x < 1000)
      return terbilang($x / 100) . " ratus" . terbilang($x % 100);
    elseif ($x < 2000)
      return "seribu" . terbilang($x - 1000);
    elseif ($x < 1000000)
      return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
    elseif ($x < 1000000000)
      return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
}

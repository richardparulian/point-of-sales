<?php
defined('BASEPATH') or exit('No direct script access allowed');

function is_logged_in()
{
    $ci             = get_instance();
    $is_Logged_in   = $ci->session->userdata('Status');

    if (!isset($is_Logged_in) || $is_Logged_in != "success") {
        redirect(base_url('sign-in'));
    }
}

if (!function_exists('format_indo')) {
    function format_indo($date)
    {
        date_default_timezone_set('Asia/Jakarta');

        //$Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        $Bulan = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);
        $waktu = substr($date, 11, 5);
        //$hari = date("w", strtotime($date));
        //$result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;
        $result = $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;

        return $result;
    }
}

if (!function_exists('format_waktu')) {
    function format_waktu($date)
    {
        date_default_timezone_set('Asia/Jakarta');

        $waktu = substr($date, 0, 8);

        $result = $waktu;

        return $result;
    }
}

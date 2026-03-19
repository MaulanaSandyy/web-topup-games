<?php
// ============================================
// FILE: koneksi.php
// DESKRIPSI: File koneksi ke database
// ============================================

// --- KONFIGURASI DATABASE ---
$db_host = "localhost";     // Host database (biasanya localhost)
$db_user = "root";          // Username database (default XAMPP: root)
$db_pass = "";              // Password database (default XAMPP: kosong)
$db_name = "db_topup_game"; // Nama database yang kita buat

// --- MEMBUAT KONEKSI ---
// Fungsi mysqli_connect untuk koneksi ke MySQL
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// --- CEK KONEKSI ---
// Jika koneksi gagal, tampilkan pesan error dan hentikan script
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// --- SETTING CHARSET ---
// Agar bisa membaca karakter Indonesia dengan benar
mysqli_set_charset($koneksi, "utf8");

// --- FUNGSI SEDERHANA UNTUK QUERY ---
// Fungsi ini untuk memudahkan siswa dalam menjalankan query
function query($sql) {
    global $koneksi;
    return mysqli_query($koneksi, $sql);
}

// Fungsi untuk mengambil semua data (array asosiatif)
function fetch_all($result) {
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fungsi untuk mengambil satu data
function fetch_one($result) {
    return mysqli_fetch_assoc($result);
}

// Fungsi untuk menghitung baris
function count_rows($result) {
    return mysqli_num_rows($result);
}

// Fungsi untuk mengamankan input (mencegah SQL Injection sederhana)
function bersihkan_input($data) {
    global $koneksi;
    $data = trim($data);                 // Hapus spasi di awal/akhir
    $data = stripslashes($data);         // Hapus garis miring
    $data = htmlspecialchars($data);     // Ubah karakter HTML
    $data = mysqli_real_escape_string($koneksi, $data); // Escape untuk SQL
    return $data;
}

// Untuk memulai session
session_start();

// ============================================
// CATATAN: File ini harus di-include di setiap halaman
// yang membutuhkan koneksi database
// Contoh: include 'config/koneksi.php';
// ============================================
?>
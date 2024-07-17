<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_anggota = $_POST["kode_anggota"];
    $nama = $_POST["nama"];
    $jeniskelamin = $_POST["jeniskelamin"];
    $alamat = $_POST["alamat"];
    $status = $_POST["status"];

    // Memproses upload foto
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi file foto
    if (getimagesize($_FILES["foto"]["tmp_name"]) === false) {
        die("File bukan gambar.");
    }

    // Cek jika file sudah ada
    if (file_exists($target_file)) {
        die("Maaf, file sudah ada.");
    }

    // Batasi ukuran file (misalnya 2MB)
    if ($_FILES["foto"]["size"] > 2000000) {
        die("Maaf, file terlalu besar.");
    }

    // Batasi jenis file
    $allowed_types = ["jpg", "png", "jpeg", "gif"];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.");
    }

    // coba upload file
    if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        die("Maaf, terjadi kesalahan saat mengupload file. Kesalahan: " . $_FILES["foto"]["error"]);
    }

    // Menambah data 
    $sql = "INSERT INTO tbanggota (kode_anggota, nama, jeniskelamin, alamat, status, foto, waktu_dibuat) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        die("Error dalam menyiapkan statement: " . $db->error);
    }
    $stmt->bind_param("ssssss", $kode_anggota, $nama, $jeniskelamin, $alamat, $status, $target_file);

    if ($stmt->execute()) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
?>

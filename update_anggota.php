<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $kode_anggota = $_POST["kode_anggota"];
    $nama = $_POST["nama"];
    $jeniskelamin = $_POST["jeniskelamin"];
    $alamat = $_POST["alamat"];
    $status = $_POST["status"];

    // Jika ada foto yang diunggah, proses upload foto
    if ($_FILES["foto"]["error"] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi file foto
        if (getimagesize($_FILES["foto"]["tmp_name"]) === false) {
            die("File bukan gambar.");
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

        // Jika semuanya ok, coba upload file
        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            die("Maaf, terjadi kesalahan saat mengupload file.");
        }

        // Update data ke database dengan foto
        $sql = "UPDATE tbanggota SET kode_anggota=?, nama=?, jeniskelamin=?, alamat=?, status=?, foto=? WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssssssi", $kode_anggota, $nama, $jeniskelamin, $alamat, $status, $target_file, $id);
    } else {
        // Update data ke database tanpa foto
        $sql = "UPDATE tbanggota SET kode_anggota=?, nama=?, jeniskelamin=?, alamat=?, status=? WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssssi", $kode_anggota, $nama, $jeniskelamin, $alamat, $status, $id);
    }

    if ($stmt->execute()) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
?>
<br>
<a href="anggota-read.php">Kembali</a>

<?php
require 'koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Query untuk mendapatkan nama file foto untuk dihapus
    $sql_select = "SELECT foto FROM tbanggota WHERE id = ?";
    $stmt_select = $db->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $anggota = $result->fetch_assoc();
    if ($anggota) {
        // Hapus file foto jika ada
        if (file_exists($anggota['foto'])) {
            unlink($anggota['foto']);
        }

        // Query untuk menghapus data anggota
        $sql_delete = "DELETE FROM tbanggota WHERE id = ?";
        $stmt_delete = $db->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            echo "Data berhasil dihapus.";
        } else {
            echo "Error: " . $stmt_delete->error;
        }

        $stmt_delete->close();
    } else {
        echo "Data tidak ditemukan.";
    }

    $stmt_select->close();
    $db->close();
} else {
    die("ID tidak diberikan");
}
?>
<br>
<a href="anggota-read.php">Kembali</a>

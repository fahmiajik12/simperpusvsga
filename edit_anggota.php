<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT id, kode_anggota, nama, jeniskelamin, alamat, status, foto, waktu_dibuat FROM tbanggota WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $anggota = $result->fetch_assoc();

    if (!$anggota) {
        die("Data tidak ditemukan");
    }
} else {
    die("ID tidak diberikan");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota</title>
</head>
<body>
    <h1>Edit Anggota</h1>
    <form action="update_anggota.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">
        
        <label for="kode_anggota">Kode Anggota:</label>
        <input type="text" id="kode_anggota" name="kode_anggota" value="<?php echo $anggota['kode_anggota']; ?>" required><br><br>

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo $anggota['nama']; ?>" required><br><br>

        <label for="jeniskelamin">Jenis Kelamin:</label>
        <select id="jeniskelamin" name="jeniskelamin" required>
            <option value="Pria" <?php if ($anggota['jeniskelamin'] == 'Pria') echo 'selected'; ?>>Pria</option>
            <option value="Wanita" <?php if ($anggota['jeniskelamin'] == 'Wanita') echo 'selected'; ?>>Wanita</option>
        </select><br><br>

        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" value="<?php echo $anggota['alamat']; ?>" required><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="0" <?php if ($anggota['status'] == '0') echo 'selected'; ?>>Tidak Meminjam</option>
            <option value="1" <?php if ($anggota['status'] == '1') echo 'selected'; ?>>Sedang Meminjam</option>
        </select><br><br>

        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto"><br>
        <img src="<?php echo $anggota['foto']; ?>" alt="Foto Anggota" width="100"><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota</title>
</head>
<body>
    <h1>Tambah Anggota</h1>
    <form action="anggota_act.php" method="post" enctype="multipart/form-data">
        <label for="kode_anggota">Kode Anggota:</label>
        <input type="text" id="kode_anggota" name="kode_anggota" required><br><br>

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="jeniskelamin">Jenis Kelamin:</label>
        <select id="jeniskelamin" name="jeniskelamin" required>
            <option value="Pria">Pria</option>
            <option value="Wanita">Wanita</option>
        </select><br><br>

        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" required><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="0">Tidak Meminjam</option>
            <option value="1">Sedang Meminjam</option>
        </select><br><br>

        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" required><br><br>

        <input type="submit" value="Tambah">
    </form>
</body>
</html>

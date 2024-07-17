<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota</title>
</head>
<body>
    <h1>Data Anggota</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Kode Anggota</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Status</th>
            <th>Foto</th>
            <th>Waktu Dibuat</th>
            <th>Aksi</th>
        </tr>
        <?php
        include 'koneksi.php';
        $sql = "SELECT id, kode_anggota, nama, jeniskelamin, alamat, status, foto, waktu_dibuat FROM tbanggota";
        $result = $db->query($sql);

        // Mengumpulkan hasil query ke dalam array
        $anggota = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $anggota[] = $row;
            }
        }

        // Menampilkan data menggunakan foreach
        if (!empty($anggota)) {
            foreach ($anggota as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["kode_anggota"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nama"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["jeniskelamin"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["alamat"]) . "</td>";
                echo "<td>" . ($row["status"] == 1 ? "Sedang Meminjam" : "Tidak Meminjam") . "</td>";
                echo "<td><img src='" . htmlspecialchars($row["foto"]) . "' alt='Foto Anggota' width='100'></td>";
                echo "<td>" . htmlspecialchars($row["waktu_dibuat"]) . "</td>";
                echo "<td>
                        <a href='edit_anggota.php?id=" . htmlspecialchars($row["id"]) . "'>Edit</a> ||
                        <a href='delete.php?id=" . htmlspecialchars($row["id"]) . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini? (" . htmlspecialchars($row["nama"]) . ")\")'>Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Tidak ada data</td></tr>";
        }

        $db->close();
        ?>
    </table>
</body>
</html>

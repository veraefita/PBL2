<?php
// Cek apakah pengguna sudah login dan memiliki role 'admin'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php'); // Arahkan ke halaman login jika bukan admin
    exit;
}

// Menambahkan fitur logout
if (isset($_GET['logout'])) {
    session_destroy();  // Hapus sesi
    header('Location: ../../login.php'); // Arahkan ke halaman login setelah logout
    exit;
}
?>

<style>
    th, td {
        padding: 5px;
        font-size: 14px;
    }

    table {
        width: 100%;
        margin-bottom: 20px;
    }

    th {
        background-color: #004080;
        color: white;
        text-align: left;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    .btn-blue {
        background-color: lightblue;
        color: black;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        text-decoration: none;
        font-size: 12px;
    }

    .btn-blue:hover {
        background-color: #003060;
        color: white;
    }
</style>
<?php

echo '<div style="background-color: #ffffff; padding: 20px; padding-bottom: 30px; margin: 0; border-radius: 8px; width: calc(100% - 0px); height: 100%; box-sizing: border-box;">';

// Membungkus judul dan tombol dalam satu div
echo '<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; margin-top: 0px;">';

// Judul Daftar Data Pelanggaran
echo '<h2 style="margin: 0px;">Daftar Data Pelanggaran</h2>';

// Tombol Tambah Pelanggaran
echo '<a href="admin_dashboard.php?page=tambah_pelanggaran" style="text-decoration: none; background-color: #004080; color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold;">Tambah Pelanggaran</a>';
echo '</div>';
echo '<p>Menampilkan seluruh data Pelanggaran</p>';
echo '<table border="1" cellpadding="10" cellspacing="0">';
echo '<tr>
        <th style="text-align: center; padding: 10px;">No.</th>
        <th style=" padding: 10px;">Deskripsi</th>
        <th style="width:100px;  padding: 10px;">Tingkat Sanksi</th>
    </tr>';

$no = 1; // Inisialisasi nomor urut

// Query untuk mengambil data pelanggaran dan tingkat_sanksi
$query = "
    SELECT p.id, p.deskripsi, t.tingkat
    FROM pelanggaran p
    JOIN tingkat t ON p.tingkat_sanksi = t.tingkat
";
$result = sqlsrv_query($conn, $query);

if( $result === false ) {
    die( print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
}

while ($data_pelanggaran = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td style="text-align: center;">' . $no . '</td>'; // Menampilkan nomor urut
    echo '<td>' . htmlspecialchars($data_pelanggaran['deskripsi']) . '</td>';
    echo '<td style="text-align: center;">' . htmlspecialchars($data_pelanggaran['tingkat']) . '</td>';


    echo '</tr>';
    $no++; // Increment nomor urut
}

echo '</table>';
echo '<br>';
echo '</div>';
?>

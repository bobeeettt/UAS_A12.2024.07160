<?php
    require 'cek_session.php';
    include "koneksi.php";
    $data = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #8B7355;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            border: 3px solid #6B5444;
        }
        
        .identity {
            background: #6B5444;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            border: 2px solid #5A463A;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        h2 {
            color: #5A463A;
            font-size: 28px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: #6B5444;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn:hover {
            background: #5A463A;
            box-shadow: 0 4px 12px rgba(107, 84, 68, 0.3);
        }
        
        .btn-logout {
            background: #ff0000ff;
        }
        
        .btn-logout:hover {
            background: #971111ff;
        }
        
        .table-wrapper {
            overflow-x: auto;
            margin-top: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-radius: 10px;
            overflow: hidden;
        }
        
        th {
            background: #6B5444;
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            color: #555;
            font-size: 14px;
        }
        
        tr:hover {
            background-color: #FAF8F5;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        td a {
            color: #6B5444;
            text-decoration: none;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 4px;
            transition: all 0.2s;
        }
        
        td a:hover {
            background: #FAF8F5;
            color: #5A463A;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 16px;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .identity {
                font-size: 14px;
            }
            
            h2 {
                font-size: 22px;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .btn-group {
                width: 100%;
            }
            
            .btn {
                flex: 1;
                text-align: center;
            }
            
            table {
                font-size: 12px;
            }
            
            th, td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="identity">
            Sistem Inventaris Barang oleh Robert Ang | A12.2024.07160
        </div>

        <div class="header">
            <h2>Daftar Data Barang</h2>
            <div class="btn-group">
                <a href="tambahDataBrg.php" class="btn">Tambah Data</a>
                <a href="cetakpdf.php" class="btn">Cetak PDF</a>
                <a href="logout.php" class="btn btn-logout">Logout</a>
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Barang</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Merk</th>
                        <th>Kondisi</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Keterangan</th>
                        <th colspan="2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($data) > 0) {
                        while ($row = mysqli_fetch_assoc($data)) :
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><strong><?= $row['kode_brg'] ?></strong></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['kategori'] ?></td>
                        <td><?= $row['merk'] ?></td>
                        <td><?= $row['kondisi'] ?></td>
                        <td><?= $row['jumlah'] ?></td>
                        <td><?= $row['satuan'] ?></td>
                        <td><?= $row['keterangan'] ?></td>
                        <td><a href="koreksiDataBrg.php?id=<?= $row['id'] ?>">Edit</a></td>
                        <td><a href="hapusDataBrg.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a></td>
                    </tr>
                    <?php
                        endwhile;
                    } else {
                        echo '<tr><td colspan="11" class="no-data">Tidak ada data barang tersedia.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const kodeBarang = document.querySelector('input[name="kode_brg"]').value;
    const namaBarang = document.querySelector('input[name="nama"]').value;
    const password = document.querySelector('input[name="password"]').value;
    
    let pesanKonfirmasi = `Apakah Anda yakin ingin mengupdate data barang?\n\n`;
    pesanKonfirmasi += `Kode Barang: ${kodeBarang}\n`;
    pesanKonfirmasi += `Nama: ${namaBarang}\n`;
    
    if (password) {
        pesanKonfirmasi += `\nPERHATIAN: Password akan diubah!`;
    }
    
    if (confirm(pesanKonfirmasi)) {
        this.submit();
    }
});
</script>

</body>
</html>

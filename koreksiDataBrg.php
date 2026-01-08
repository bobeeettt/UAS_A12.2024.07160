<?php
    require 'cek_session.php';
    include 'koneksi.php';
    
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    
    $query = "SELECT * FROM barang WHERE id = $id";
    $result = mysqli_query($koneksi, $query);
    
    if (!$result) {
        die("Error query: " . mysqli_error($koneksi));
    }
    
    $data = mysqli_fetch_assoc($result);
    
    if (!$data) {
        die("Data tidak ditemukan dengan ID: " . $id);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Barang</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #8B7355;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }
        
        * {
            box-sizing: border-box;
        }
        
        .container {
            max-width: 700px;
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
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            border: 2px solid #5A463A;
        }
        
        h2 {
            color: #5A463A;
            text-align: center;
            margin-bottom: 25px;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .form-group {
            margin-bottom: 18px;
        }
        
        label {
            display: block;
            color: #5A463A;
            font-weight: 600;
            margin-bottom: 6px;
            font-size: 14px;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #D4C4B0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
            font-family: inherit;
            background: #FAF8F5;
        }
        
        input:focus,
        textarea:focus {
            outline: none;
            border-color: #8B7355;
            background: white;
            box-shadow: 0 0 0 3px rgba(139, 115, 85, 0.1);
        }
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .submit-btn {
            flex: 1;
            padding: 14px;
            background: #6B5444;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .submit-btn:hover {
            background: #5A463A;
            box-shadow: 0 4px 12px rgba(107, 84, 68, 0.3);
        }
        
        .submit-btn:active {
            transform: scale(0.98);
        }
        
        .cancel-btn {
            flex: 1;
            padding: 14px;
            background: #8B7355;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .cancel-btn:hover {
            background: #7A6449;
            box-shadow: 0 4px 12px rgba(139, 115, 85, 0.3);
        }
        
        .password-note {
            font-size: 12px;
            color: #8B7355;
            margin-top: 5px;
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
            
            .container {
                padding: 20px;
            }
            
            .identity {
                font-size: 13px;
            }
            
            h2 {
                font-size: 20px;
            }
            
            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="identity">
            Sistem Inventaris Barang oleh Robert Ang | A12.2024.07160
        </div>
        
        <h2>Edit Data Barang</h2>
        
        <form action="simpanKoreksiDataBrg.php" method="POST">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">
            
            <div class="form-group">
                <label>Kode Barang</label>
                <input type="text" name="kode_brg" value="<?= htmlspecialchars($data['kode_brg']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="kategori" value="<?= htmlspecialchars($data['kategori']) ?>">
            </div>
            
            <div class="form-group">
                <label>Merk</label>
                <input type="text" name="merk" value="<?= htmlspecialchars($data['merk']) ?>">
            </div>
            
            <div class="form-group">
                <label>Kondisi</label>
                <input type="text" name="kondisi" value="<?= htmlspecialchars($data['kondisi']) ?>">
            </div>
            
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" value="<?= htmlspecialchars($data['jumlah']) ?>">
            </div>
            
            <div class="form-group">
                <label>Satuan</label>
                <input type="text" name="satuan" value="<?= htmlspecialchars($data['satuan']) ?>">
            </div>
            
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan"><?= htmlspecialchars($data['keterangan']) ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>">
            </div>
            
            <div class="form-group">
                <label>Password Baru (opsional)</label>
                <input type="password" name="password" minlength="10" placeholder="Kosongkan jika tidak ingin mengubah password">
                <div class="password-note">Isi hanya jika ingin mengubah password (minimal 10 karakter)</div>
            </div>
            
            <div class="button-group">
                <button type="submit" class="submit-btn">Update Data</button>
                <a href="tampilDataBrg.php" class="cancel-btn">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
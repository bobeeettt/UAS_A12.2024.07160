<?php require 'cek_session.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Barang</title>

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
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        * {
            box-sizing: border-box;
        }
        
        .container {
            max-width: 700px;
            width: 100%;
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
        
        .section-divider {
            margin: 30px 0;
            padding: 15px;
            background: #FAF8F5;
            border-left: 4px solid #8B7355;
            border-radius: 8px;
        }
        
        .section-divider h3 {
            color: #6B5444;
            margin: 0;
            font-size: 16px;
        }
        
        .section-divider p {
            color: #666;
            margin: 5px 0 0 0;
            font-size: 13px;
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
        
        .submit-btn {
            width: 100%;
            padding: 14px;
            background: #6B5444;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
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
        
        .note {
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
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="identity">
            Sistem Informasi Inventaris Barang oleh Robert Ang | A12.2024.07160
        </div>

        <h2>Input Data Barang</h2>
        <form action="simpanDataBrg.php" method="POST">
            <!-- DATA BARANG -->
            <div class="form-group">
                <label>Kode Barang *</label>
                <input type="text" name="kode_brg" required>
            </div>
            
            <div class="form-group">
                <label>Nama *</label>
                <input type="text" name="nama" required>
            </div>
            
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="kategori">
            </div>

            <div class="form-group">
                <label>Merk</label>
                <input type="text" name="merk">
            </div>
            
            <div class="form-group">
                <label>Kondisi</label>
                <input type="text" name="kondisi">
            </div>
            
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" value="1" min="0">
            </div>
            
            <div class="form-group">
                <label>Satuan</label>
                <input type="text" name="satuan">
            </div>
            
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan"></textarea>
            </div>
            
            <!-- DIVIDER -->
            <div class="section-divider">
                <h3>Buat Akun Admin Baru (Opsional)</h3>
                <p>Isi bagian ini HANYA jika ingin membuat akun admin baru yang bisa login ke sistem.<br>
                Untuk input barang biasa, <strong>kosongkan saja</strong> bagian email dan password.</p>
            </div>
            
            <div class="form-group">
                <label>Email (Opsional)</label>
                <input type="email" name="email" placeholder="email@example.com">
                <div class="note">* Kosongkan jika hanya input barang biasa</div>
            </div>
            
            <div class="form-group">
                <label>Password (Opsional - minimal 10 karakter)</label>
                <input type="password" name="password" minlength="10" placeholder="Minimal 10 karakter">
                <div class="note">* Kosongkan jika hanya input barang biasa<br>
                * Isi jika ingin barang ini bisa digunakan untuk login sebagai admin</div>
            </div>
            
            <button type="submit" class="submit-btn">Simpan Data</button>
        </form>
    </div>  
</body>
</html>

<?php
    require 'cek_session.php';
    include 'koneksi.php';

    // Fungsi sanitasi data
    function bersih($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    $xkode_brg = bersih($_POST['kode_brg'] ?? '');
    $xnama = bersih($_POST['nama'] ?? '');
    $xkategori = bersih($_POST['kategori'] ?? '');
    $xmerk = bersih($_POST['merk'] ?? '');
    $xkondisi = bersih($_POST['kondisi'] ?? '');
    $xjumlah = bersih($_POST['jumlah'] ?? '');
    $xsatuan = bersih($_POST['satuan'] ?? '');
    $xketerangan = bersih($_POST['keterangan'] ?? '');
    $xemail = bersih($_POST['email'] ?? '');
    $xraw_password = $_POST['password'] ?? '';

    // ✅ VALIDASI OPSIONAL: Jika email/password diisi, keduanya harus valid
    if (!empty($xemail) || !empty($xraw_password)) {
        // Jika salah satu diisi, keduanya harus diisi
        if (empty($xemail)) {
            echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Error - Email Kosong</title>
                <style>
                    * { margin: 0; padding: 0; box-sizing: border-box; }
                    body {
                        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                        background: #8B7355;
                        min-height: 100vh;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        padding: 20px;
                    }
                    .container {
                        background: white;
                        padding: 40px;
                        border-radius: 12px;
                        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
                        text-align: center;
                        max-width: 500px;
                        border: 3px solid #6B5444;
                    }
                    .identity {
                        background: #6B5444;
                        color: white;
                        padding: 15px;
                        border-radius: 8px;
                        margin-bottom: 25px;
                        font-size: 14px;
                        font-weight: 600;
                        border: 2px solid #5A463A;
                    }
                    .error-icon { font-size: 60px; margin-bottom: 20px; }
                    h2 { color: #8B4513; margin-bottom: 15px; }
                    p { color: #555; margin-bottom: 25px; line-height: 1.6; }
                    .btn {
                        display: inline-block;
                        padding: 12px 30px;
                        background: #6B5444;
                        color: white;
                        text-decoration: none;
                        border-radius: 6px;
                        font-weight: 600;
                        transition: all 0.3s;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                    }
                    .btn:hover {
                        background: #5A463A;
                        box-shadow: 0 4px 12px rgba(107, 84, 68, 0.3);
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="identity">Sistem Inventaris Barang</div>
                    <div class="error-icon">⚠️</div>
                    <h2>Email Harus Diisi</h2>
                    <p>Jika ingin membuat akun admin baru, <strong>email dan password harus diisi keduanya</strong>.</p>
                    <a href="tambahDataBrg.php" class="btn">← Kembali ke Form</a>
                </div>
            </body>
            </html>
            ';
            exit;
        }
        
        if (empty($xraw_password) || strlen($xraw_password) < 10) {
            echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Error - Password Tidak Valid</title>
                <style>
                    * { margin: 0; padding: 0; box-sizing: border-box; }
                    body {
                        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                        background: #8B7355;
                        min-height: 100vh;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        padding: 20px;
                    }
                    .container {
                        background: white;
                        padding: 40px;
                        border-radius: 12px;
                        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
                        text-align: center;
                        max-width: 500px;
                        border: 3px solid #6B5444;
                    }
                    .identity {
                        background: #6B5444;
                        color: white;
                        padding: 15px;
                        border-radius: 8px;
                        margin-bottom: 25px;
                        font-size: 14px;
                        font-weight: 600;
                        border: 2px solid #5A463A;
                    }
                    .error-icon { font-size: 60px; margin-bottom: 20px; }
                    h2 { color: #8B4513; margin-bottom: 15px; }
                    p { color: #555; margin-bottom: 25px; line-height: 1.6; }
                    .btn {
                        display: inline-block;
                        padding: 12px 30px;
                        background: #6B5444;
                        color: white;
                        text-decoration: none;
                        border-radius: 6px;
                        font-weight: 600;
                        transition: all 0.3s;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                    }
                    .btn:hover {
                        background: #5A463A;
                        box-shadow: 0 4px 12px rgba(107, 84, 68, 0.3);
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="identity">Sistem Inventaris Barang</div>
                    <div class="error-icon">⚠️</div>
                    <h2>Password Tidak Valid</h2>
                    <p>Password harus diisi dan minimal <strong>10 karakter</strong>.</p>
                    <a href="tambahDataBrg.php" class="btn">← Kembali ke Form</a>
                </div>
            </body>
            </html>
            ';
            exit;
        }
    }

    // Hash password jika diisi
    $hashed_password = null;
    if (!empty($xraw_password)) {
        $hashed_password = password_hash($xraw_password, PASSWORD_BCRYPT);
    }

    // Insert ke database
    $sqli = "INSERT INTO barang (kode_brg, nama, kategori, merk, kondisi, jumlah, satuan, keterangan, email, password) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sqli);
    $stmt->bind_param("ssssssssss", $xkode_brg, $xnama, $xkategori, $xmerk, $xkondisi, $xjumlah, $xsatuan, $xketerangan, $xemail, $hashed_password);

    if ($stmt->execute()) {
        $pesan_tambahan = !empty($xemail) 
            ? "Akun admin baru telah dibuat dan bisa digunakan untuk login." 
            : "Data barang berhasil disimpan.";
        
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Sukses - Data Tersimpan</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                    background: #8B7355;
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 20px;
                }
                .container {
                    background: white;
                    padding: 40px;
                    border-radius: 12px;
                    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
                    text-align: center;
                    max-width: 500px;
                    border: 3px solid #6B5444;
                }
                .identity {
                    background: #6B5444;
                    color: white;
                    padding: 15px;
                    border-radius: 8px;
                    margin-bottom: 25px;
                    font-size: 14px;
                    font-weight: 600;
                    border: 2px solid #5A463A;
                }
                .success-icon { font-size: 60px; margin-bottom: 20px; }
                h2 { color: #5A7A3A; margin-bottom: 15px; }
                p { color: #555; margin-bottom: 25px; line-height: 1.6; }
                .btn {
                    display: inline-block;
                    padding: 12px 30px;
                    background: #6B5444;
                    color: white;
                    text-decoration: none;
                    border-radius: 6px;
                    font-weight: 600;
                    transition: all 0.3s;
                    margin: 5px;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                }
                .btn:hover {
                    background: #5A463A;
                    box-shadow: 0 4px 12px rgba(107, 84, 68, 0.3);
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="identity">Sistem Inventaris Barang</div>
                <div class="success-icon">✅</div>
                <h2>Data Berhasil Disimpan!</h2>
                <p>Data barang <strong>' . htmlspecialchars($xnama) . '</strong> telah berhasil ditambahkan.<br><br>' . $pesan_tambahan . '</p>
                <a href="tampilDataBrg.php" class="btn">📊 Lihat Data</a>
                <a href="tambahDataBrg.php" class="btn">➕ Tambah Lagi</a>
            </div>
        </body>
        </html>
        ';
    } else {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error - Gagal Menyimpan</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                    background: #8B7355;
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 20px;
                }
                .container {
                    background: white;
                    padding: 40px;
                    border-radius: 12px;
                    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
                    text-align: center;
                    max-width: 500px;
                    border: 3px solid #6B5444;
                }
                .identity {
                    background: #6B5444;
                    color: white;
                    padding: 15px;
                    border-radius: 8px;
                    margin-bottom: 25px;
                    font-size: 14px;
                    font-weight: 600;
                    border: 2px solid #5A463A;
                }
                .error-icon { font-size: 60px; margin-bottom: 20px; }
                h2 { color: #8B4513; margin-bottom: 15px; }
                p { color: #555; margin-bottom: 25px; line-height: 1.6; }
                .error-detail {
                    background: #FFF5EE;
                    padding: 15px;
                    border-radius: 8px;
                    margin-bottom: 20px;
                    color: #8B4513;
                    font-size: 14px;
                    border: 2px solid #D4C4B0;
                }
                .btn {
                    display: inline-block;
                    padding: 12px 30px;
                    background: #6B5444;
                    color: white;
                    text-decoration: none;
                    border-radius: 6px;
                    font-weight: 600;
                    transition: all 0.3s;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                }
                .btn:hover {
                    background: #5A463A;
                    box-shadow: 0 4px 12px rgba(107, 84, 68, 0.3);
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="identity">Sistem Inventaris Barang</div>
                <div class="error-icon">❌</div>
                <h2>Gagal Menyimpan Data</h2>
                <p>Terjadi kesalahan saat menyimpan data barang ke database.</p>
                <div class="error-detail">Error: ' . $stmt->error . '</div>
                <a href="tambahDataBrg.php" class="btn">← Kembali ke Form</a>
            </div>
        </body>
        </html>
        ';
    }

    $stmt->close();
    $koneksi->close();
?>

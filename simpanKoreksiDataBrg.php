<?php
    include 'koneksi.php';
    
    function bersih($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    
    $id = bersih($_POST['id'] ?? '');
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

    if (!empty($xraw_password)) {
        if (strlen($xraw_password) < 10) {
            echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Error - Validasi Password</title>
                <style>
                    * {
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                    }
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
                    .error-icon {
                        font-size: 60px;
                        margin-bottom: 20px;
                    }
                    h2 {
                        color: #8B4513;
                        margin-bottom: 15px;
                    }
                    p {
                        color: #555;
                        margin-bottom: 25px;
                        line-height: 1.6;
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
                    <div class="error-icon">⚠️</div>
                    <h2>Password Tidak Valid</h2>
                    <p>Password harus minimal <strong>10 karakter</strong>.</p>
                    <a href="koreksiDataBrg.php?id='.$id.'" class="btn">← Kembali</a>
                </div>
            </body>
            </html>
            ';
            exit;
        }
        
        $hashed_password = password_hash($xraw_password, PASSWORD_BCRYPT);
        
        $sql = "UPDATE barang SET 
                kode_brg = ?, 
                nama = ?, 
                kategori = ?, 
                merk = ?, 
                kondisi = ?, 
                jumlah = ?, 
                satuan = ?, 
                keterangan = ?, 
                email = ?,
                password = ?
                WHERE id = ?";
        
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ssssssssssi", $xkode_brg, $xnama, $xkategori, $xmerk, $xkondisi, $xjumlah, $xsatuan, $xketerangan, $xemail, $hashed_password, $id);
        
    } else {
        $sql = "UPDATE barang SET 
                kode_brg = ?, 
                nama = ?, 
                kategori = ?, 
                merk = ?, 
                kondisi = ?, 
                jumlah = ?, 
                satuan = ?, 
                keterangan = ?, 
                email = ?
                WHERE id = ?";
        
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sssssssssi", $xkode_brg, $xnama, $xkategori, $xmerk, $xkondisi, $xjumlah, $xsatuan, $xketerangan, $xemail, $id);
    }

    if ($stmt->execute()) {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Sukses - Data Diupdate</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
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
                .success-icon {
                    font-size: 60px;
                    margin-bottom: 20px;
                }
                h2 {
                    color: #5A7A3A;
                    margin-bottom: 15px;
                }
                p {
                    color: #555;
                    margin-bottom: 25px;
                    line-height: 1.6;
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
                <h2>Data Berhasil Diupdate</h2>
                <p>Data barang telah berhasil diperbarui dalam database.</p>
                <a href="tampilDataBrg.php" class="btn">📊 Lihat Data</a>
                <a href="koreksiDataBrg.php?id='.$id.'" class="btn">✏️ Edit Lagi</a>
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
            <title>Error - Gagal Update</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
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
                .error-icon {
                    font-size: 60px;
                    margin-bottom: 20px;
                }
                h2 {
                    color: #8B4513;
                    margin-bottom: 15px;
                }
                p {
                    color: #555;
                    margin-bottom: 25px;
                    line-height: 1.6;
                }
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
                <h2>Gagal Mengupdate Data</h2>
                <p>Terjadi kesalahan saat memperbarui data ke database.</p>
                <div class="error-detail">Error: ' . $stmt->error . '</div>
                <a href="koreksiDataBrg.php?id='.$id.'" class="btn">← Kembali</a>
            </div>
        </body>
        </html>
        ';
    }

    $stmt->close();
    $koneksi->close();
?>

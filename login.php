<?php
session_start();

// Cek jika sudah login, redirect ke tampilDataBrg
if(isset($_SESSION['username'])) {
    header("Location: tampilDataBrg.php");
    exit();
}

// Proses login - PINDAHKAN KE ATAS SEBELUM HTML
$error_message = '';
if(isset($_POST['login'])) {
    require 'koneksi.php';
    $username = mysqli_real_escape_string($koneksi, $_POST['kode_brg']);
    $password = $_POST['pass'];

    $sql = "SELECT * FROM barang WHERE BINARY kode_brg = '$username' LIMIT 1";
    $query = mysqli_query($koneksi, $sql);

    if(mysqli_num_rows($query) == 1) {
        $data = mysqli_fetch_assoc($query);
        if(password_verify($password, $data['password'])) {
            $_SESSION['username'] = $data['kode_brg'];
            $_SESSION['nama'] = $data['nama'];
            header("Location: tampilDataBrg.php");
            exit();
        } else {
            $error_message = 'Password salah!';
        }
    } else {
        $error_message = 'Kode barang tidak ditemukan!';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 400px;
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
            margin-bottom: 30px;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            color: #5A463A;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #D4C4B0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
            font-family: inherit;
            background: #FAF8F5;
        }
        
        input:focus {
            outline: none;
            border-color: #8B7355;
            background: white;
            box-shadow: 0 0 0 3px rgba(139, 115, 85, 0.1);
        }
        
        .login-btn {
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
        
        .login-btn:hover {
            background: #5A463A;
            box-shadow: 0 4px 12px rgba(107, 84, 68, 0.3);
        }
        
        .login-btn:active {
            transform: scale(0.98);
        }
        
        .error-message {
            background: #F8D7DA;
            color: #721C24;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            border-left: 4px solid #C82333;
        }
        
        @media (max-width: 768px) {
            .login-container {
                padding: 30px 20px;
            }
            
            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="identity">
            Sistem Inventaris Barang oleh <br>
            Robert Ang | A12.2024.07160
        </div>
        
        <h2>Login Sistem</h2>
        
        <?php if(!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Kode Barang</label>
                <input type="text" name="kode_brg" required autofocus>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="pass" required>
            </div>
            
            <button type="submit" name="login" class="login-btn">Login</button>
        </form>
    </div>
</body>
</html>
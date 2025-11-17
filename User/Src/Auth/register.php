<?php
include "../../Connection/koneksi.php";
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

session_start();
$errMsg = ["", "", ""];

if (isset($_POST["register"])) {
    $username = test_input($_POST["RegisUsername"]);
    $email = test_input($_POST["RegisEmail"]);
    $pass = test_input($_POST["RegisPassword"]);
    $role = "user";

    if (!empty($username)) {
        if (strlen($username) < 4) {
            $errMsg[0] = "Nama harus mengandung setidaknya 4 karakter!";
        } else if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
            $errMsg[0] = "Nama hanya boleh berisi huruf, angka, dan underscore.";
        }
    } else {
        $errMsg[0] = "Nama wajib diisi!";
    }

    if (!empty($pass)) {
        if (strlen($pass) < 8) {
            $errMsg[1] = "Password harus mengandung setidaknya 8 karakter!";
        } else if (!preg_match("/^[a-zA-Z0-9]+$/", $pass)) {
            $errMsg[1] = "Password mengandung karakter ilegal!";
        }
    } else {
        $errMsg[1] = "Password wajib diisi!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errMsg[2] = "format email tidak valid!";
    }

    if (empty(array_filter($errMsg))) {
        // check if username or email already exists (avoid depending on 'id' column)
        $chk = $koneksi->prepare("SELECT 1 FROM users WHERE nama = ? OR email = ? LIMIT 1");
        $chk->bind_param('ss', $username, $email);
        $chk->execute();
        $cres = $chk->get_result();
        if ($cres && $cres->num_rows > 0) {
            $errMsg[0] = 'Username atau email sudah terdaftar';
        } else {
            $passHash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $koneksi->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $passHash, $role);
            if ($stmt->execute()) {
                // redirect to login after successful register
                header('Location: login.php');
                exit();
            } else {
                $errMsg[0] = 'Gagal membuat akun';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../../Assets/Style/authstyle.css">
    <style>
        body {
            background-image: url('../../assets/images/Aset10.jpg');
            width: 100%;
            height: 100vh;
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="card-header">
        <h2>Sign Up</h2>
        <form action="" method="POST">
            <label for="RegisUsername">Username</label>
            <input type="text" name="RegisUsername" id="RegisUsername" placeholder="Username" required>
            <span class="nameErr"><?php echo $errMsg[0] ?></span>

            <label for="RegisEmail">Email</label>
            <input type="email" name="RegisEmail" id="RegisEmail" placeholder="Email" required>
            <span class="emailErr"><?php echo $errMsg[2] ?></span>

            <label for="RegisPassword">Password</label>
            <input type="password" name="RegisPassword" id="RegisPassword" placeholder="Password" required>
            <span class="passErr"><?php echo $errMsg[1] ?></span>

            <button type="submit" value="register" name="register">Daftar</button>

        </form>
        <p>Sudah punya akun? <a href="login.php">Masuk</a></p>
    </div>
</body>

</html>
<?php
include "../Connection/koneksi.php";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

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
        echo "Akun berhasil dibuat";
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $koneksi->prepare("insert into users (nama, email, password, role) values (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $pass, $role);
        $stmt->execute();
    } else {
        echo "Akun gagal dibuat";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <form action="" method="POST">
        <label for="RegisUsername">Username:</label>
        <input type="text" name="RegisUsername" id="RegisUsername">
        <span class="nameErr"><?php echo $errMsg[0] ?></span>
        <br>
        <label for="RegisEmail">Email:</label>
        <input type="email" name="RegisEmail" id="RegisEmail" required>
        <span class="emailErr"><?php echo $errMsg[2] ?></span>
        <br>
        <label for="RegisPassword">Password:</label>
        <input type="password" name="RegisPassword" id="RegisPassword">
        <span class="passErr"><?php echo $errMsg[1] ?></span>
        <br>
        <button type="submit" value="register" name="register">Daftar</button><br>

    </form>
</body>

</html>
<?php
include "../Connection/koneksi.php";
session_start();

if (isset($_POST["login"])) {
    $name = $_POST["username"];
    $email = $_POST["email"];
    $pass = $_POST["password"];

    $sql = $koneksi->prepare("select nama, password, email, role from users where nama = ?");
    $sql->bind_param("s", $name);
    $sql->execute();
    $result = $sql->get_result();


    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row["password"])) {
            echo "login berhasil!";
            $_SESSION["role"] = $row["role"];
            header("location: index.php");
        } else if ($row["email"] != $email) {
            echo "email tidak cocok!";
        } else {
            echo "Password salah!";
        }
    } else {
        echo "User tidak ditemukan!";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <br>
        <button type="submit" value="login" name="login">Masuk</button><br>

    </form>
</body>

</html>
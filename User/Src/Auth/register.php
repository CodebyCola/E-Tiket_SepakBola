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

$err = [
    "username" => "",
    "email" => "",
    "password" => "",
    "global" => ""
];

if (!empty($_SESSION["register_err"])) {
    $err = $_SESSION["register_err"];
    unset($_SESSION["register_err"]);
}

if (isset($_POST["register"])) {
    $username = test_input($_POST["RegisUsername"]);
    $email = test_input($_POST["RegisEmail"]);
    $pass = test_input($_POST["RegisPassword"]);
    $role = "user";

    if (empty($username)) {
        $err["username"] = "Name is required!";
    } else if (strlen($username) < 4) {
        $err["username"] = "Name must contain at least 4 characters!";
    } else if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $err["username"] = "Letters, numbers, and underscores only.";
    }

    if (empty($pass)) {
        $err["password"] = "Password is required!";
    } else if (strlen($pass) < 8) {
        $err["password"] = "Password must contain at least 8 characters!";
    } else if (!preg_match("/^[a-zA-Z0-9]+$/", $pass)) {
        $err["password"] = "Password contains illegal characters!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err["email"] = "Invalid email format!";
    }

    if (!empty($err["username"]) || !empty($err["password"]) || !empty($err["email"]) || !empty($err["global"])) {
        $_SESSION["register_err"] = $err;
        header("Location: register.php");
        exit();
    }

    if (empty($err["username"]) && empty($err["password"]) && empty($err["email"])) {
        $chk = $koneksi->prepare("SELECT 1 FROM users WHERE nama = ? OR email = ? LIMIT 1");
        $chk->bind_param('ss', $username, $email);
        $chk->execute();
        $cres = $chk->get_result();

        if ($cres && $cres->num_rows > 0) {
            $err["global"] = "Username or email already registered!";
        } else {
            $passHash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $koneksi->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $passHash, $role);
            if ($stmt->execute()) {
                header('Location: login.php');
                exit();
            } else {
                $err["global"] = "Failed to create account";
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
</head>

<body style="background-image: url('../../assets/images/Aset10.jpg')">
    <div class="card-header">
        <h2>Sign Up</h2>
        <a class="btn-back" href="../index.php">
            Back
        </a>
        <?php if (!empty($err["global"])): ?>

            <div class="error-box">
                <?= $err["global"] ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="RegisUsername">Username</label>
            <input type="text" name="RegisUsername" id="RegisUsername" placeholder="Username" required>
            <span class="Err"><?= $err["username"] ?></span>

            <label for="RegisEmail">Email</label>
            <input type="email" name="RegisEmail" id="RegisEmail" placeholder="Email" required>
            <span class="Err"><?= $err["email"] ?></span>

            <label for="RegisPassword">Password</label>
            <input type="password" name="RegisPassword" id="RegisPassword" placeholder="Password" required>
            <span class="Err"><?= $err["password"] ?></span>

            <button type="submit" value="register" name="register">Sign Up</button>

        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>

</html>
<?php
include "../../Connection/koneksi.php";
session_start();
$name = "";

if (!empty($_SESSION["user_id"]) || !empty($_SESSION['user_name'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_COOKIE["remember"]) && !empty($_COOKIE["remember"])) {
    $name = $_COOKIE["remember"];
}

if (isset($_POST["login"])) {

    $name = htmlspecialchars($_POST["username"] ?? "");
    $email = $_POST["email"] ?? "";
    $pass = $_POST["password"] ?? "";

    if (empty($name) || empty($email) || empty($pass)) {
        $_SESSION['err'] = "All fields are required!";
        header("Location: login.php");
        exit();
    } else {
        $sql = $koneksi->prepare("SELECT id_user, nama, password, email, role FROM users WHERE nama = ? LIMIT 1");
        $sql->bind_param("s", $name);
        $sql->execute();
        $result = $sql->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row["email"] != $email) {
                $_SESSION['err'] = "Email does not match!";
                header("Location: login.php");
                exit();
            } else {
                if (password_verify($pass, $row["password"])) {
                    $_SESSION["role"] = $row["role"];
                    if (isset($row['id_user'])) {
                        $_SESSION['user_id'] = $row['id_user'];
                    } else {
                        $_SESSION['user_id'] = null;
                    }
                    $_SESSION['username'] = $row['nama'];
                    if (isset($_POST["remember"])) {
                        setcookie("remember", $name, time() + 3600, "/", "", false, true);
                    }
                    header("location: ../index.php");
                    exit();
                } else {
                    $_SESSION['err'] = "Wrong Password!";
                    header("Location: login.php");
                    exit();
                }
            }
        } else {
            $_SESSION['err'] = "User not found!";
            header("Location: login.php");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../Assets/Style/authstyle.css">
</head>

<body style="  background-image: url('../../Assets/images/Aset10.jpg')">
    <div class="card-header">
        <h2>Login</h2>

        <a class="btn-back" href="../index.php">
            Back
        </a>
        <?php if (!empty($_SESSION['err'])) : ?>
            <div class="error-box">
                <?= $_SESSION['err'] ?>
            </div>
            <?php unset($_SESSION["err"]); ?>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Username" value="<?= htmlspecialchars($name); ?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Email">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password">

            <div>
                <input type="checkbox" id="remember" name="remember" <?php if (isset($_COOKIE["remember"])) echo "checked"; ?>>
                <label for="remember">Remember Me?</label>
            </div>
            <br>
            <button type="submit" value="login" name="login">Login</button>
            <p>Don't have an account yet? <a href="register.php">Sign Up</a></p>
        </form>
    </div>
</body>

</html>
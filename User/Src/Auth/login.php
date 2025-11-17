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

    $name = $_POST["username"] ?? "";
    $email = $_POST["email"] ?? "";
    $pass = $_POST["password"] ?? "";

    if (empty($name) || empty($email) || empty($pass)) {
        $err = "Semua field harus diisi!";
    } else {
        // Attempt to fetch id if present; if not, fall back to columns without id
        try {
            $sql = $koneksi->prepare("SELECT id, nama, password, email, role FROM users WHERE nama = ? LIMIT 1");
            $sql->bind_param("s", $name);
            $sql->execute();
            $result = $sql->get_result();
        } catch (Exception $e) {
            // fallback: users table may not have id column
            $sql = $koneksi->prepare("SELECT nama, password, email, role FROM users WHERE nama = ? LIMIT 1");
            $sql->bind_param("s", $name);
            $sql->execute();
            $result = $sql->get_result();
        }

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row["email"] != $email) {
                $err = "Email tidak cocok!";
            } else {
                if (password_verify($pass, $row["password"])) {
                    // successful login
                    $_SESSION["role"] = $row["role"];
                    // set user id if available, otherwise set username only
                    if (isset($row['id'])) {
                        $_SESSION['user_id'] = $row['id'];
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
                    $err = "Password salah!";
                }
            }
        } else {
            $err = "User tidak ditemukan!";
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
    <style>
        body {
            background-image: url('../../Assets/images/Aset10.jpg');
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
        <h2>Login</h2>
        <form action="" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Username" value="<?php echo htmlspecialchars($name); ?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Email" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password">

            <div>
                <input type="checkbox" id="remember" name="remember" <?php if (isset($_COOKIE["remember"])) echo "checked"; ?>>
                <label for="remember">Ingat Pengguna?</label>
            </div>
            <br>
            <button type="submit" value="login" name="login">Masuk</button>
            <p>Belum punya akun? <a href="register.php">Sign Up</a></p>
        </form>
    </div>
</body>

</html>
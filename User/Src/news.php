<?php
include __DIR__ . "/../Connection/koneksi.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="../Assets/Style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-secondary">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../Assets/images/priemer-league-icon.jpg" alt="logo" width="120" height="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pertandingan.php">Matches</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="news.php">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="riwayat.php">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tiket.php">Buy Ticket</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="d-flex">
            <?php
            if (isset($_SESSION['role'])) {
            ?>
                <h1 class="Username"><?= $_SESSION['username'] ?></h1>

            <?php
            } else {
            ?>
                <a href="Auth/login.php" class="btn btn-dark login-btn">Login</a>
            <?php
            }
            ?>
        </div>
    </nav>
    <section id="Hero">
        <div class="hero text d-flex flex-column justify-content-center align-items-center" style="height: 80vh;">
            <h1 class="text-light">SELAMAT DATANG DI PREMIER LEAGUE</h1>
        </div>
    </section>
</body>

</html>
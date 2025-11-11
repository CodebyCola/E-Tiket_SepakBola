<?php
include "../Connection/koneksi.php";
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="Auth/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-secondary">
      <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
          <img src="../assets/images/PremiereLeauge.png" alt="logo" width="30" height="30" class="me-2"></a>
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
              <a class="nav-link" href="news.php">News</a>
            </li>
            <li class="nav-item">
              <a class="nav-link  active" href="riwayat.php">History</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="d-flex">
        <a href="auth/login.php" class="btn btn-dark login-btn">Login</a>
      </div>
      </nav>
</body>

</html>

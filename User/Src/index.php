<?php
include __DIR__ . "/../Connection/koneksi.php";
session_start();
session_destroy();
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
<style>
  #Hero {
    background-image: url('../assets/images/Aset10.jpg');
    width: 100%;
    height: 90vh;
    background-size: cover;
    background-repeat: no-repeat;
  }
</style>

<body>
  <nav class="navbar navbar-expand-lg bg-body-secondary">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <div class="logo-container"></div>
        <img src="../assets/images/PremiereLeauge.png" alt="logo" width="30" height="30" class="me-2">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pertandingan.php">Matches</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="news.php">News</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="riwayat.php">History</a>
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

  <section id="Fiturs">
    <h3>Why Choose Us?</h3>

    <div class="card-container">

      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <img src="../Assets/images/icon/shield-check.svg" alt="">
          <h5 class="card-title">Aman & Resmi</h5>
          <p class="card-text">Semua tiket yang dijual terverifikasi langsung oleh pihak klub dan penyelenggara. Tidak ada tiket palsu, tidak ada perantara, hanya transaksi yang benar-benar sah.</p>
        </div>
      </div>

      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <img src="../Assets/images/icon/zap.svg" alt="">
          <h5 class="card-title">Pemesanan Cepat</h5>
          <p class="card-text">Proses pemesanan berlangsung dalam hitungan detik. Cukup pilih pertandingan, pilih tempat duduk, dan lakukan pembayaran, tiketmu langsung siap.</p>
        </div>
      </div>

      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <img src="../Assets/images/icon/ticket.svg" alt="">
          <h5 class="card-title">Ticket Digital</h5>
          <p class="card-text">Setelah pembayaran berhasil, tiket digital akan otomatis tersedia dan dapat diunduh melalui menu Riwayat Pemesanan.</p>
        </div>
      </div>

      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <img src="../Assets/images/icon/message-square-dot.svg" alt="">
          <h5 class="card-title">Dukungan 24 jam</h5>
          <p class="card-text">Tim layanan pelanggan kami siap membantu kapan pun kamu butuh mulai dari kendala pembayaran sampai informasi seputar pertandingan.</p>
        </div>
      </div>

    </div>
  </section>




    <div class="container mt-3">
</div>
</body>
<<<<<<< HEAD

</html>
=======
</html>
>>>>>>> dac277d (update)

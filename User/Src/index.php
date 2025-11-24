<?php
include __DIR__ . "/../Connection/koneksi.php";
session_start();

$sql = $koneksi->prepare("SELECT nama, komentar, rating, tanggal from reviews WHERE status = 'disetujui' LIMIT 3");
$sql->execute();

$result = $sql->get_result();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HomePage</title>
  <link rel="stylesheet" href="../Assets/Style/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-secondary position-sticky" style="width: 100%; z-index: 100; top:0;">
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
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pertandingan.php">Matches</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="news.php">News</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="tiket.php">Buy Ticket</a>
          </li>

        </ul>
      </div>
    </div>
    <div class="profile-menu d-flex">
      <?php
      if (isset($_SESSION['role'])) {
      ?>
        <div class="profile-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION['username'] ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
            <li><a class="dropdown-item" href="riwayat.php">Purchase History</a></li>
            <li><a class="dropdown-item" href="Auth/logout.php">Logout</a></li>
          </ul>
        </div>

      <?php
      } else {
      ?>
        <a href="Auth/login.php" class="btn btn-dark login-btn">Login</a>
      <?php
      }
      ?>
    </div>
  </nav>

  <section class="hero">
    <div class="hero-content">
      <div class="hero-tag"><a href="tiket.php">Buy ur ticket!</a>
      </div>
      <h1>Ready to watch your favorite game? Get your tickets now!</h1>
      <p>Watch your favorite club without any hassle!</p>
    </div>
  </section>

  <section id="Fiturs">
    <h3>Why Choose Us?</h3>

    <div class="card-container">

      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <img src="../Assets/images/icon/shield-check.svg" alt="">
          <h5 class="card-title mb-3 ">Aman & Resmi</h5>
          <p class="card-text">Semua tiket yang dijual terverifikasi langsung oleh pihak klub dan penyelenggara. Tidak ada tiket palsu, tidak ada perantara, hanya transaksi yang benar-benar sah.</p>
        </div>
      </div>

      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <img src="../Assets/images/icon/zap.svg" alt="">
          <h5 class="card-title mb-3">Pemesanan Cepat</h5>
          <p class="card-text">Proses pemesanan berlangsung dalam hitungan detik. Cukup pilih pertandingan,Isi form, dan lakukan pembayaran, tiketmu langsung siap.</p>
        </div>
      </div>

      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <img src="../Assets/images/icon/ticket.svg" alt="">
          <h5 class="card-title mb-3">Ticket Digital</h5>
          <p class="card-text">Setelah pembayaran berhasil, tiket digital akan otomatis tersedia dan dapat diunduh melalui menu Riwayat Pemesanan.</p>
        </div>
      </div>

      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <img src="../Assets/images/icon/message-square-dot.svg" alt="">
          <h5 class="card-title mb-3">Dukungan 24 jam</h5>
          <p class="card-text">Tim layanan pelanggan kami siap membantu kapan pun kamu butuh mulai dari kendala pembayaran sampai informasi seputar pertandingan.</p>
        </div>
      </div>

    </div>
  </section>

  <section id="Reviews">
    <h3>Trusted by Football Fans Everywhere.</h3>

    <div class="card-review-container">
      <?php
      while ($data = $result->fetch_assoc()) {
      ?>
        <div class="card text-bg-light mb-3" style="max-width: 18rem;">
          <div class="card-body">
            <div class="ratings">
              <h5><?= $data['rating'] ?></h5>
              <img src="../Assets/images/icon/star.svg" alt="" width="50px" height="50px">
            </div>
            <p class="card-text"><?= $data['komentar'] ?></p>
            <p class="card-text"><small class="text-body-secondary"><?= $data['nama'] ?>, <?= date('d F Y', strtotime($data['tanggal'])) ?></small></p>
          </div>
        </div>
      <?php
      }
      ?>

      <div class="card text-bg-light mb-3" style="max-width: 18rem;">
        <div class="card-body">
          <div class="ratings">
            <h5>4</h5>
            <img src="../Assets/images/icon/star.svg" alt="" width="50px" height="50px">
          </div>
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card`s content.</p>
          <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
        </div>
      </div>

      <div class="card text-bg-light mb-3" style="max-width: 18rem;">
        <div class="card-body">
          <div class="ratings">
            <h5>3</h5>
            <img src="../Assets/images/icon/star.svg" alt="" width="50px" height="50px">
          </div>
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card`s content.</p>
          <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="footer-container">
      <div class="footer-section">
        <h4>About</h4>
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Follow Us</h4>
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Instagram</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>More</h4>
        <ul>
          <li><a href="#">Shop</a></li>
          <li><a href="#">Events</a></li>
          <li><a href="#">Media</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 Premier League. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
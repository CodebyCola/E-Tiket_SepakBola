<?php
include __DIR__ . "/../Connection/koneksi.php";
session_start();

$sql = $koneksi->prepare("SELECT nama, komentar, rating, tanggal from reviews WHERE status = 'disetujui' LIMIT 3");
$sql->execute();
$result = $sql->get_result();

$stmt = $koneksi->prepare("SELECT p.*,
               th.nama_team AS home_name,
               th.logo_team AS home_logo,
               ta.nama_team AS away_name,
               ta.logo_team AS away_logo 
        FROM pertandingan p
        JOIN teams th ON p.tim_home = th.id_team
        JOIN teams ta ON p.tim_away = ta.id_team 
        WHERE month(p.tanggal) > 2 
        ORDER BY p.tanggal ASC
        LIMIT 1");
$stmt->execute();
$hasil = $stmt->get_result();
$match = $hasil->fetch_assoc();

$matchDateTime = $match['tanggal'] . "T" . $match['waktu'];
echo "<!-- DEBUG: $matchDateTime -->";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>League - Your Ticket to the Game</title>
  <link rel="icon" type="image/x-icon" href="../Assets/images/logo.jpg">
  <link rel="stylesheet" href="../Assets/Style/navbarstyle.css">
  <link rel="stylesheet" href="../Assets/Style/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg position-fixed" style="top:0; z-index: 1000; width: 100%;">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="../Assets/images/logo.jpg" alt="logo" width="100" height="90">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link active" href="index.php">Home</a>
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
      <div class="profile-menu d-flex">
        <?php if (isset($_SESSION['role'])) { ?>
          <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              <?= $_SESSION['username'] ?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
              <li><a class="dropdown-item" href="riwayat.php">Purchase History</a></li>
              <li><a class="dropdown-item" href="Auth/logout.php">Logout</a></li>
            </ul>
          </div>
        <?php } else { ?>
          <a href="Auth/login.php" class="btn login-btn">Login</a>
        <?php } ?>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-container">
      <div class="hero-content">
        <div class="hero-tag">
          <a href="tiket.php">Buy Your Ticket Now!</a>
        </div>
        <h1>Ready to watch your favorite game? Get your tickets now!</h1>
        <p>Watch your favorite club without any hassle! Secure, fast, and easy ticket booking.</p>
      </div>

      <div class="hero-card">
        <div class="card-header">
          <span class="card-title text-white">Next Match</span>
          <span class="live-badge">● UPCOMING</span>
        </div>

        <div class="match-info mt-3">
          <div class="teams">
            <div class="team">
              <div class="team-logo"><img src="<?= $match['home_logo'] ?>" alt=""></div>
              <div class="team-name"><?= $match['home_name'] ?></div>
            </div>
            <div class="vs">VS</div>
            <div class="team">
              <div class="team-logo"><img src="<?= $match['away_logo'] ?>" alt=""></div>
              <div class="team-name"><?= $match['away_name'] ?></div>
            </div>
          </div>
          <div class="match-details">
            <span>📅 <?= date('M d Y', strtotime($match['tanggal'])) ?></span>
            <span>🕐 <?= substr($match['waktu'], 0, 5) ?> WIB</span>
            <span>🏟️ <?= $match['lokasi'] ?></span>
          </div>
        </div>

        <div id="countdown" data-matchtime="<?= $matchDateTime ?>">
          <div class="countdown-label">Match starts in</div>
          <div class="countdown-timer">
            <div class="time-unit">
              <span class="time-value" id="days"></span>
              <span class="time-label">Days</span>
            </div>
            <div class="time-unit">
              <span class="time-value" id="hours"></span>
              <span class="time-label">Hours</span>
            </div>
            <div class="time-unit">
              <span class="time-value" id="minutes"></span>
              <span class="time-label">Mins</span>
            </div>
            <div class="time-unit">
              <span class="time-value" id="seconds"></span>
              <span class="time-label">Secs</span>
            </div>
          </div>
        </div>

        <div class="price-section">
          <div class="price">
            <div class="price-label">Starting from</div>
            <div class="price-value">Rp. <?= number_format($match['harga_tiket'], 0, ',', '.') ?></div>
          </div>
          <a href="belitiket.php?id_match=<?= $match['id_match'] ?>" role="button" class="buy-ticket">Get Ticket</a>
        </div>
      </div>
    </div>
  </section>

  <!-- LATEST NEWS -->
  <section class="latest py-5" id="news">
    <div class="container">
      <h3 class="text-center mb-5 display-5 fw-bold">LATEST NEWS</h3>
      <div class="row g-4">
        <div class="col-md-4">
          <article class="news-card h-100 position-relative overflow-hidden rounded-3 shadow-lg">
            <img src="../assets/images/Aset12.webp" class="card-img" alt="">
            <div class="card-overlay"></div>
            <div class="card-body position-absolute bottom-0 start-0 p-4 text-white">
              <h3 class="h4 fw-bold">Sang Raja Telah Kembali</h3>
              <p>Manchester United belum terkalahkan hingga pekan ini!</p>
              <a href="https://www.manutd.com/" class="text-white fw-bold">Read More →</a>
            </div>
          </article>
        </div>
        <div class="col-md-4">
          <article class="news-card h-100 position-relative overflow-hidden rounded-3 shadow-lg">
            <img src="../assets/images/Aset14.webp" class="card-img" alt="">
            <div class="card-overlay"></div>
            <div class="card-body position-absolute bottom-0 start-0 p-4 text-white">
              <h3 class="h4 fw-bold">North London Derby Pekan Depan</h3>
              <p>Arsenal vs Tottenham - pertarungan paling panas!</p>
              <a href="#" class="text-white fw-bold">Read More →</a>
            </div>
          </article>
        </div>
        <div class="col-md-4">
          <article class="news-card h-100 position-relative overflow-hidden rounded-3 shadow-lg">
            <img src="../assets/images/Aset15.webp" class="card-img" alt="">
            <div class="card-overlay"></div>
            <div class="card-body position-absolute bottom-0 start-0 p-4 text-white">
              <h3 class="h4 fw-bold">Hasil dan Klasemen Pekan Terbaru</h3>
              <p>Liverpool mendapat kekalahan mengejutkan di kandang menurut update klasemen terakhir.</p>
              <a href="https://www.manutd.com/" class="text-white fw-bold">Read More →</a>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="Fiturs">
    <h3>Why Choose Us?</h3>
    <div class="card-container">
      <div class="card">
        <div class="card-body">
          <img src="../Assets/images/icon/shield-check.svg" alt="Secure">
          <h5 class="card-title">Aman & Resmi</h5>
          <p class="card-text">Tiket 100% resmi dari klub, tanpa calo.</p>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <img src="../Assets/images/icon/zap.svg" alt="Fast">
          <h5 class="card-title">Pemesanan Cepat</h5>
          <p class="card-text">Proses hanya hitungan detik.</p>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <img src="../Assets/images/icon/ticket.svg" alt="Digital">
          <h5 class="card-title">Ticket Digital</h5>
          <p class="card-text">Langsung masuk ke akunmu, siap dipakai.</p>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <img src="../Assets/images/icon/message-square-dot.svg" alt="Support">
          <h5 class="card-title">Dukungan 24 Jam</h5>
          <p class="card-text">Langsung masuk ke akunmu, siap dipakai.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Reviews Section -->
  <section id="Reviews">
    <h3>Trusted by Football Fans Everywhere</h3>
    <div class="card-review-container">
      <?php while ($data = $result->fetch_assoc()) { ?>
        <div class="card text-bg-light mb-3">
          <div class="card-body">
            <div class="ratings">
              <h5><?= $data['rating'] ?></h5>
              <img src="../Assets/images/icon/star.svg" alt="star">
            </div>
            <p class="card-text"><?= $data['komentar'] ?></p>
            <p class="card-text">
              <small class="text-body-secondary">
                <?= $data['nama'] ?>, <?= date('d F Y', strtotime($data['tanggal'])) ?>
              </small>
            </p>
          </div>
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- Footer -->
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
      <p>&copy; 2025 Super League. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../Assets/Script/countdownTimer.js"></script>
</body>

</html>
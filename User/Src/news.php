<?php
include __DIR__ . "/../Connection/koneksi.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link rel="icon" type="image/x-icon" href="../Assets/images/logo.jpg">
    <link rel="stylesheet" href="../Assets/Style/berita.css">
    <link rel="stylesheet" href="../Assets/Style/navbarstyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
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
                        <a class="nav-link active" href="news.php">News</a>
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

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <h2 class="section-title">Latest News & Features</h2>

            <!-- Featured Article -->
            <article class="featured-article">
                <div class="article-image">
                    <img src="../assets/images/Aset2.webp" alt="Featured News">

                </div>
                <div class="article-content">
                    <h3 class="article-title">Ini Dia 20 Tim yang Akan bertanding di Premiere Leaugue Musim Ini</h3>
                    <span class="article-date">19 November 2025</span>
                </div>
            </article>

            <!-- News Grid -->
            <div class="news-grid">
                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset9.jpg" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Pemain Bintang Dikaitkan dengan Transfer Besar</h4>
                        <p class="news-excerpt">Rumor transfer terbaru menunjukkan minat serius dari klub papan atas...</p>
                        <span class="news-date">18 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset8.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Pelatih Berbicara Tentang Strategi Tim</h4>
                        <p class="news-excerpt">Dalam wawancara eksklusif, pelatih membahas rencana untuk pertandingan mendatang...</p>
                        <span class="news-date">18 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset7.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Lima Moment Terbaik Bulan Ini</h4>
                        <p class="news-excerpt">Melihat kembali aksi-aksi spektakuler yang terjadi sepanjang bulan...</p>
                        <span class="news-date">17 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset1.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Statistik Pemain Terbaik Pekan Ini</h4>
                        <p class="news-excerpt">Analisis mendalam tentang performa luar biasa dari pemain kunci...</p>
                        <span class="news-date">17 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset6.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Preview: Pertandingan Besar Akhir Pekan</h4>
                        <p class="news-excerpt">Semua yang perlu Anda ketahui sebelum big match akhir pekan ini...</p>
                        <span class="news-date">16 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset3.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Tips Fantasy Premier League Terbaik</h4>
                        <p class="news-excerpt">Rekomendasi pemain dan strategi untuk memaksimalkan poin Anda...</p>
                        <span class="news-date">16 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset13.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Krisis Cedera di Chelsea</h4>
                        <p class="news-excerpt">Selain Palmer, Chelsea juga sedang menghadapi masalah cedera lainnya...</p>
                        <span class="news-date">16 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset3.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Tendangan Bebas yang Menarik di EPL</h4>
                        <p class="news-excerpt">Di pekan ke-11 EPL 2025/2026, tercatat ada beberapa gol dari tendangan bebas yang spektakuler.</p>
                        <span class="news-date">16 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset15.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Hasil dan Klasemen Pekan Terbaru</h4>
                        <p class="news-excerpt">Liverpool mendapat kekalahan mengejutkan di kandang menurut update klasemen terakhir.</p>
                        <span class="news-date">16 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset14.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Laga Derby London Utara Pekan Depan</h4>
                        <p class="news-excerpt">Pekan ini ada “Derby London Utara” terbesar: Arsenal vs Tottenham.</p>
                        <span class="news-date">16 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset12.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Sang raja telah kembali</h4>
                        <p class="news-excerpt">Sang raja yaitu Manchester United belum terkalahkan hingga laga minggu ini!</p>
                        <span class="news-date">16 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset16.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Analisis: Apakah Haaland striker terbaik di dunia?</h4>
                        <p class="news-excerpt">Kita melihat rekor-rekor yang bisa dipecahkan pemain Norwegia itu dan menilai bagaimana ia dibandingkan dengan Messi dan Ronaldo.</p>
                        <span class="news-date">16 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset3.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Tim Terbaik Pekan Ini Shearer: 'Ballard adalah lambang musim Sunderland'</h4>
                        <p class="news-excerpt">Sunderland mengambil langkah maju lainnya dalam musim luar biasa mereka dengan hasil luar biasa melawan pemimpin Liga Primer Arsenal.</p>
                        <span class="news-date">16 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset3.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Tips Fantasy Premier League Terbaik</h4>
                        <p class="news-excerpt">Rekomendasi pemain dan strategi untuk memaksimalkan poin Anda...</p>
                        <span class="news-date">16 November 2025</span>
                    </div>
                </article>

                <article class="news-card">
                    <div class="news-image">
                        <img src="../assets/images/Aset3.webp" alt="News">

                    </div>
                    <div class="news-content">
                        <h4 class="news-title">Tips Fantasy Premier League Terbaik</h4>
                        <p class="news-excerpt">Rekomendasi pemain dan strategi untuk memaksimalkan poin Anda...</p>
                        <span class="news-date">16 November 2025</span>
                    </div>
                </article>
            </div>
        </div>
    </main>

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
            <p>&copy; 2025 Premier League. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
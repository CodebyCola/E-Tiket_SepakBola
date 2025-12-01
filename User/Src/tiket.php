<?php
include __DIR__ . "/../Connection/koneksi.php";
session_start();


$stmt = $koneksi->prepare(" SELECT p.*,
               th.nama_team AS home_name,
               th.logo_team AS home_logo,
               th.primary_color as primary_color,
               ta.nama_team AS away_name,
               ta.logo_team AS away_logo,
               ta.secondary_color as secondary_color
        FROM pertandingan AS p
        JOIN teams th ON p.tim_home = th.id_team
        JOIN teams ta ON p.tim_away = ta.id_team
        WHERE p.tanggal > NOW()
        ORDER BY p.tanggal ASC
    ");

$stmt->execute();
$result = $stmt->get_result();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli Tiket</title>
    <link rel="icon" type="image/x-icon" href="../Assets/images/logo.jpg">
    <link rel="stylesheet" href="../Assets/Style/navbarstyle.css">
    <link rel="stylesheet" href="../Assets/Style/ticketstyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pertandingan.php">Matches</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="news.php">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="tiket.php">Buy Ticket</a>
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

    <section id="main-ticket">
        <div class="search-container">
            <input type="text" id="search" placeholder="Search match...">
            <div class="filter-container">
                <div class="left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#5C6BC0" class="bi bi-funnel" viewBox="0 0 16 16">
                        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z" />
                    </svg>
                    <span>Filter ticket:</span>
                </div>
                <div class="right">
                    <button data-value="all" class="active">All</button>
                    <button data-value="available">Available</button>
                    <button data-value="soldout">Sold out</button>
                </div>
            </div>
        </div>

        <?php while ($data = $result->fetch_assoc()):
            $isSoldOut = ($data['stok_tiket'] == 0) ? 'soldout' : ''; ?>
            <div class="card mb-4 match-card <?= $isSoldOut ?>" data-stock="<?= $data['stok_tiket'] ?>">
                <div class="ticket-card">

                    <div class="thumbnail"
                        style="background: linear-gradient(135deg, <?= $data['primary_color'] ?> 50%, <?= $data['secondary_color'] ?> 50%);">
                        <div class="thumbnail-items">

                            <img src="<?= $data['home_logo'] ?>" class="logo-blur-left">
                            <span class="vs">VS</span>
                            <img src="<?= $data['away_logo'] ?>" class="logo-blur-right">

                        </div>
                        <div class="date-badge">
                            <?= date("d M", strtotime($data['tanggal'])) ?>
                        </div>
                    </div>

                    <div class="ticket-info">
                        <div class="ticket-header">
                            <h3><?= $data['home_name'] ?> vs <?= $data['away_name'] ?></h3>
                            <span style="display: inline;" class="stok-display">Stock: <?= $data['stok_tiket']  ?></span>
                        </div>
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#5C6BC0" class="bi bi-calendar-event" viewBox="0 0 16 16">
                                <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                            </svg> <?= date("d M Y", strtotime($data['tanggal']))  ?></span>
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#5C6BC0" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg> <?= $data['lokasi'] ?></span>
                        <span style="font-size: 1.25rem; color: #818cf8 ;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#5C6BC0" class="bi bi-tag" viewBox="0 0 16 16">
                                <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0" />
                                <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1m0 5.586 7 7L13.586 9l-7-7H2z" />
                            </svg> Rp. <?= number_format($data['harga_tiket'], 0, ',', '.') ?></span>

                        <a href="belitiket.php?id_match=<?= $data['id_match'] ?>" class="buy-btn">
                            Buy Ticket
                        </a>
                    </div>

                </div>
            </div>
        <?php endwhile; ?>

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
            <p>&copy; 2025 Super League. All rights reserved.</p>
        </div>
    </footer>


    <script src="../Assets/Script/ticketSC.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
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
        FROM ( SELECT * FROM pertandingan where stok_tiket > 0
        ) AS p
        JOIN teams th ON p.tim_home = th.id_team
        JOIN teams ta ON p.tim_away = ta.id_team
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
    <link rel="stylesheet" href="../Assets/Style/style.css">
    <link rel="stylesheet" href="../Assets/Style/ticketstyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
                    <li class="nav-item">
                        <a class="nav-link active" href="tiket.php">Buy Ticket</a>
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

    <section id="main-ticket">
        <div class="search-container">
            <input type="text" id="search" placeholder="Search match...">
        </div>

        <?php while ($data = $result->fetch_assoc()): ?>
            <div class="card mb-3 match-card">
                <div class="ticket-card">

                    <div class="thumbnail"
                        style="background: linear-gradient(135deg, <?= $data['primary_color'] ?> 50%, <?= $data['secondary_color'] ?> 50%);">

                        <img src="<?= $data['home_logo'] ?>" class="logo-blur-left">
                        <img src="<?= $data['away_logo'] ?>" class="logo-blur-right">

                        <span class="vs">VS</span>

                        <div class="date-badge">
                            <?= date("d M", strtotime($data['tanggal'])) ?>
                        </div>
                    </div>

                    <div class="ticket-info">
                        <h3><?= $data['home_name'] ?> vs <?= $data['away_name'] ?></h3>
                        <span><i class="bi bi-calendar-event"> <?= date("d M Y", strtotime($data['tanggal']))  ?></i></span>
                        <span><i class="bi bi-geo-alt"> <?= $data['lokasi'] ?></i></span>
                        <span><i class="bi bi-ticket"> Rp. <?= number_format($data['harga_tiket'], 0, ',', '.') ?></i></span>

                        <a href="belitiket.php?id_match=<?= $data['id_match'] ?>" class="buy-btn">
                            Buy Ticket
                        </a>
                    </div>

                </div>
            </div>
        <?php endwhile; ?>

    </section>


    <script src="../Assets/Script/ticketSC.js"></script>
</body>

</html>
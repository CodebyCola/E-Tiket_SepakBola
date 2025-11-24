<?php
include __DIR__ . "/../Connection/koneksi.php";
session_start();
$week = isset($_GET['week']) ? $_GET['week'] : "";
$month = isset($_GET['month']) ? $_GET['month'] : "";

if ($month && $week) {
    $stmt = $koneksi->prepare(" SELECT p.*,
               th.nama_team AS home_name,
               th.logo_team AS home_logo,
               ta.nama_team AS away_name,
               ta.logo_team AS away_logo
        FROM (
            SELECT *, FLOOR((DAY(tanggal) - 1) / 7) + 1 AS matchweek
            FROM pertandingan
            WHERE MONTH(tanggal) = ?
        ) AS p
        JOIN teams th ON p.tim_home = th.id_team
        JOIN teams ta ON p.tim_away = ta.id_team
        WHERE p.matchweek = ?
        ORDER BY p.tanggal ASC
    ");

    $stmt->bind_param("ii", $month, $week);
    $stmt->execute();
    $result = $stmt->get_result();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="../Assets/Style/style.css">
    <link rel="stylesheet" href="../Assets/Style/matchstyle.css">
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
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="pertandingan.php">Matches</a>
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
    <section id="matches">
        <form action="pertandingan.php" method="GET">
            <div class="upper-matches">
                <h1 style="display: inline;">Matches</h1>
                <div class="dropdown">
                    <select name="month" id="month" class="drpdwn" onchange="this.form.submit()">
                        <option value="">Months</option>
                        <option value="1" <?= $month == 1 ? "selected" : "" ?>>January</option>
                        <option value="2" <?= $month == 2 ? "selected" : "" ?>>February</option>
                        <option value="3" <?= $month == 3 ? "selected" : "" ?>>March</option>
                        <option value="4" <?= $month == 4 ? "selected" : "" ?>>April</option>
                        <option value="5" <?= $month == 5 ? "selected" : "" ?>>May</option>
                        <option value="6" <?= $month == 6 ? "selected" : "" ?>>June</option>
                        <option value="7" <?= $month == 7 ? "selected" : "" ?>>July</option>
                        <option value="8" <?= $month == 8 ? "selected" : "" ?>>August</option>
                        <option value="9" <?= $month == 9 ? "selected" : "" ?>>September</option>
                        <option value="10" <?= $month == 10 ? "selected" : "" ?>>October</option>
                        <option value="11" <?= $month == 11 ? "selected" : "" ?>>November</option>
                        <option value="12" <?= $month == 12 ? "selected" : "" ?>>December</option>
                    </select>
                </div>
            </div>

            <div class="matches-container">
                <div class="btn-group d-flex overflow-auto gap-3 py-3 px-2" role="group" data-bs-toggle="buttons">
                    <input type="radio" class="btn-check" name="week" id="mw1" value="1" autocomplete="off" <?= $week == 1 ? "checked" : "" ?> onchange="this.form.submit()">
                    <label class="btn btn-dark text-white p-3" for="mw1">Matchweek 1</label>

                    <input type="radio" class="btn-check" name="week" id="mw2" value="2" autocomplete="off" <?= $week == 2 ? "checked" : "" ?> onchange="this.form.submit()">
                    <label class="btn btn-dark text-white p-3" for="mw2">Matchweek 2</label>

                    <input type="radio" class="btn-check" name="week" id="mw3" value="3" autocomplete="off" <?= $week == 3 ? "checked" : "" ?> onchange="this.form.submit()">
                    <label class="btn btn-dark text-white p-3" for="mw3">Matchweek 3</label>

                    <input type="radio" class="btn-check" name="week" id="mw4" value="4" autocomplete="off" <?= $week == 4 ? "checked" : "" ?> onchange="this.form.submit()">
                    <label class="btn btn-dark text-white p-3" for="mw4">Matchweek 4</label>
                </div>
            </div>
        </form>

        <div id="matches-list">
            <?php if (isset($result)): ?>
                <?php while ($data = $result->fetch_assoc()): ?>
                    <a href="detail.php?id_match=<?= $data['id_match'] ?>">
                        <div class="match-card">
                            <div class="match-left">
                                <div class="date"><?= date("d M Y", strtotime($data['tanggal'])) ?></div>
                                <div class="time"><?= substr($data['waktu'], 0, 5) ?></div>
                            </div>

                            <div class="match-center">
                                <div class="club">
                                    <div class="name"><?= $data['home_name'] ?></div>
                                    <img src="<?= $data['home_logo'] ?>" alt="">
                                </div>

                                <div class="vs">
                                    <?php
                                    $isFinished =
                                        (!is_null($data['skor_home']) && !is_null($data['skor_away']))
                                        || $data['stok_tiket'] == 0;

                                    if ($isFinished) {
                                        echo $data['skor_home'] . " - " . $data['skor_away'];
                                    } else {
                                        echo "vs";
                                    }
                                    ?>
                                </div>


                                <div class="club">
                                    <img src="<?= $data['away_logo'] ?>" alt="">
                                    <div class="name"><?= htmlspecialchars($data['away_name']) ?></div>
                                </div>
                            </div>


                            <div class="match-right">
                                <div class="price">Rp <?= number_format($data['harga_tiket'], 0, ',', '.') ?></div>
                                <div class="stadium"><?= $data['lokasi'] ?></div>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>

</html>
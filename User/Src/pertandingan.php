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
        SELECT *,
        CASE
            WHEN DAY(tanggal) BETWEEN 1 AND 7 THEN 1
            WHEN DAY(tanggal) BETWEEN 8 AND 14 THEN 2
            WHEN DAY(tanggal) BETWEEN 15 AND 21 THEN 3
            ELSE 4
        END AS matchweek
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

$sql = $koneksi->prepare("SELECT s.*,t.nama_team FROM team_stats s JOIN teams t ON s.id_team = t.id_team ORDER BY league_position ASC");
$sql->execute();
$hasil = $sql->get_result();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="icon" type="image/x-icon" href="../Assets/images/logo.jpg">
    <link rel="stylesheet" href="../Assets/Style/navbarstyle.css">
    <link rel="stylesheet" href="../Assets/Style/matchstyle.css">
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
                        <a class="nav-link" href="index.php">Home</a>
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

    <section id="matches">
        <div class="m-container">

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
                <?php if (isset($result)) { ?>
                    <?php while ($data = $result->fetch_assoc()): ?>
                        <a href="detail.php?id_match=<?= $data['id_match'] ?>">
                            <div class="match-card">
                                <div class="match-left">
                                    <div class="date"><?= date("d M Y", strtotime($data['tanggal'])) ?></div>
                                    <div class="time"><?= substr($data['waktu'], 0, 5) ?></div>
                                </div>

                                <div class="match-center">
                                    <div class="club">
                                        <div class="name" style="text-align:right;"><?= $data['home_name'] ?></div>
                                        <img src="<?= $data['home_logo'] ?>" alt="">
                                    </div>

                                    <div class="vs">
                                        <?php
                                        $isFinished =
                                            (!is_null($data['skor_home']) && !is_null($data['skor_away']));

                                        if ($isFinished) {
                                            echo $data['skor_home'] . " - " . $data['skor_away'];
                                        } else {
                                            echo "vs";
                                        }
                                        ?>
                                    </div>


                                    <div class="club">
                                        <div class="name"><?= htmlspecialchars($data['away_name']) ?></div>
                                        <img src="<?= $data['away_logo'] ?>" alt="">
                                    </div>
                                </div>


                                <div class="match-right">
                                    <div class="price">Rp <?= number_format($data['harga_tiket'], 0, ',', '.') ?></div>
                                    <div class="stadium"><?= $data['lokasi'] ?></div>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; ?>
                <?php } else { ?>
                    <div class="text-center py-5">
                        <h3 class="text-white-50">Select month and matchweek to view matches</h3>
                    </div>
                <?php } ?>
            </div>

        </div>
    </section>

    <section id="rankings">
        <div class="container my-5">
            <h2 class="rankings-title text-center mb-4">Premier League Standings 2025/2026</h2>

            <table class="standings-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Teams</th>
                        <th>P</th>
                        <th>W</th>
                        <th>D</th>
                        <th>L</th>
                        <th>Goals</th>
                        <th>Pts</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <?php while ($stats = $hasil->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $stats['league_position'] ?></td>
                            <td><?= $stats['nama_team'] ?></td>
                            <td><?= $stats['played'] ?></td>
                            <td><?= $stats['wins'] ?></td>
                            <td><?= $stats['draws'] ?></td>
                            <td><?= $stats['losses'] ?></td>
                            <td><?= $stats['goals'] ?></td>
                            <td><?= $stats['points'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>

</html>
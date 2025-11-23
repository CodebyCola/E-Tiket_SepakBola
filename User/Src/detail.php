<?php
include __DIR__ . "/../Connection/koneksi.php";
session_start();

if (!isset($_GET['id_match'])) {
  die("Invalid request");
}

$id = $_GET['id_match'];

$stmt = $koneksi->prepare(" SELECT p.*,
           th.nama_team AS home_name,
           th.logo_team AS home_logo,
           th.primary_color as primary_color,
           ta.nama_team AS away_name,
           ta.logo_team AS away_logo,
          ta.secondary_color as secondary_color,

           sh.league_position AS home_pos,
           sh.played AS home_played,
           sh.wins AS home_wins,
           sh.draws AS home_draws,
           sh.losses AS home_losses,
           sh.goals AS home_goals,

           sa.league_position AS away_pos,
           sa.played AS away_played,
           sa.wins AS away_wins,
           sa.draws AS away_draws,
           sa.losses AS away_losses,
           sa.goals AS away_goals,

           p.stok_tiket
    FROM pertandingan p
    JOIN teams th ON p.tim_home = th.id_team
    JOIN teams ta ON p.tim_away = ta.id_team
    JOIN team_stats sh ON sh.id_team = th.id_team
    JOIN team_stats sa ON sa.id_team = ta.id_team
    WHERE p.id_match = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$match = $result->fetch_assoc();

$matchweek = floor((date("j", strtotime($match['tanggal'])) - 1) / 7) + 1;
$isFinished = $match['skor_home'] !== null && $match['skor_away'] !== null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Detail Pertandingan</title>
  <link rel="stylesheet" href="../Assets/Style/detailstyle.css">
</head>

<body>
  <div class="match-header">
    <a href="pertandingan.php" class="back-btn">X</a>

    <div class="team-box home">
      <div class="logo">
        <img src="<?= $match['home_logo'] ?>" alt="<?= $match['home_name'] ?>">
      </div>
      <div class="team-name"><?= htmlspecialchars($match['home_name']) ?></div>
    </div>

    <div class="match-time">
      <?php if ($isFinished): ?>
        <?= $match['skor_home'] ?> - <?= $match['skor_away'] ?>
      <?php else: ?>
        <?= substr($match['waktu'], 0, 5) ?>
      <?php endif; ?>
    </div>

    <div class="team-box away">
      <div class="logo">
        <img src="<?= $match['away_logo'] ?>" alt="<?= $match['away_name'] ?>">
      </div>
      <div class="team-name" style="text-align: center;"><?= htmlspecialchars($match['away_name']) ?></div>
    </div>

  </div>

  <div class="middle-info">
    <div class="mw">Matchweek <?= $matchweek ?></div>

    <div class="date">
      <?= date("D d M", strtotime($match['tanggal'])) ?> •
      <?= $match['lokasi'] ?>
    </div>

    <div class="last-time-out">
      <div class="circle">
        <div class="half left" style="background: <?= $match['primary_color']; ?>"></div>
        <div class="half right" style="background: <?= $match['secondary_color']; ?>"></div>
      </div>
      <div class="text">Last Time<br>Out</div>
    </div>
  </div>

  <?php if ($match['stok_tiket'] > 0): ?>
    <div class="ticket-section">
      <a href="pesan_tiket.php?id_match=<?= $id ?>" class="ticket-btn">
        Pesan Tiket (<?= $match['stok_tiket'] ?> tersedia)
      </a>
    </div>
  <?php endif; ?>

  <div class="stats-container">

    <div class="stats-header-flex">
      <div class="team-side left">
        <img src="<?= $match['home_logo'] ?>" alt="">
        <span><?= $match['home_name'] ?></span>
      </div>

      <div class="stats-title">Season So Far</div>

      <div class="team-side right">
        <img src="<?= $match['away_logo'] ?>" alt="">
        <span><?= $match['away_name'] ?></span>
      </div>
    </div>

    <div class="stats-row-flex">
      <div class="home-val"><?= $match['home_pos'] ?></div>
      <div class="label">League Position</div>
      <div class="away-val"><?= $match['away_pos'] ?></div>
    </div>

    <div class="stats-row-flex">
      <div class="home-val"><?= $match['home_wins'] ?></div>
      <div class="label">Wins</div>
      <div class="away-val"><?= $match['away_wins'] ?></div>
    </div>

    <div class="stats-row-flex">
      <div class="home-val"><?= $match['home_draws'] ?></div>
      <div class="label">Draw</div>
      <div class="away-val"><?= $match['away_draws'] ?></div>
    </div>

    <div class="stats-row-flex">
      <div class="home-val"><?= $match['home_losses'] ?></div>
      <div class="label">Losses</div>
      <div class="away-val"><?= $match['away_losses'] ?></div>
    </div>

    <div class="stats-row-flex">
      <div class="home-val"><?= $match['home_goals'] ?></div>
      <div class="label">Goals</div>
      <div class="away-val"><?= $match['away_goals'] ?></div>
    </div>

    <div class="stats-row-flex">
      <div class="home-val"><?= number_format($match['home_goals'] / max(1, $match['home_played']), 2) ?></div>
      <div class="label">Avg Goals / Match</div>
      <div class="away-val"><?= number_format($match['away_goals'] / max(1, $match['away_played']), 2) ?></div>
    </div>

    <div class="stats-row-flex">
      <div class="home-val"><?= number_format(($match['home_played'] - $match['home_wins'] - $match['home_draws']), 2) ?></div>
      <div class="label">Avg Conceded / Match</div>
      <div class="away-val"><?= number_format(($match['away_played'] - $match['away_wins'] - $match['away_draws']), 2) ?></div>
    </div>
  </div>


</body>

</html>
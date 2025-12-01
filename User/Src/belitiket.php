<?php
include __DIR__ . "/../Connection/koneksi.php";
session_start();
$id = $_GET['id_match'];

if (!isset($_SESSION['user_id'])) {
	header("location: Auth/login.php");
	exit();
}

if (!isset($_GET['id_match'])) {
	header("location: tiket.php");
	exit();
} else {
	$stmt = $koneksi->prepare(" SELECT p.*,
               th.nama_team AS home_name,
               th.logo_team AS home_logo,
               th.primary_color as primary_color,
               ta.nama_team AS away_name,
               ta.logo_team AS away_logo,
               ta.secondary_color as secondary_color
        FROM pertandingan p
        JOIN teams th ON p.tim_home = th.id_team
        JOIN teams ta ON p.tim_away = ta.id_team
		WHERE p.id_match = ?
    ");

	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$data = $result->fetch_assoc();
	if ($data['stok_tiket'] < 1) {
		header("location: tiket.php");
		exit();
	}
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$jumlah = $_POST['jumlah'];
	$id_match = $_POST['id_match'];
	$id_user = $_SESSION['user_id'];
	$total = $jumlah * $data['harga_tiket'];
	$nama = $_POST['nama'];
	$email = $_POST['email'];
	$tlp = $_POST['telp'];
	$sisastok = $data['stok_tiket'] - $jumlah;

	$sql = $koneksi->prepare("INSERT INTO pembelian (namaLengkap, email, no_hp, jumlah_tiket, total_harga, id_match, id_user) VALUES (?, ?, ?, ?, ?, ?, ?)");

	$sql->bind_param("sssiiii", $nama, $email, $tlp, $jumlah, $total, $id_match, $id_user);
	if ($sql->execute()) {
		$stmt = $koneksi->prepare("UPDATE pertandingan set stok_tiket = ? WHERE id_match = ?");
		$stmt->bind_param('ii', $sisastok, $id_match);
		$stmt->execute();
		header("Location: riwayat.php");
		exit();
	} else {
		die("Purchase Failed!");
	}
}

$matchweek = floor((date("j", strtotime($data['tanggal'])) - 1) / 7) + 1;

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Detail Payment</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="../Assets/Style/ticket_detail.css">
</head>

<body>
	<section id="detail-ticket">
		<div class="ticket-form-container">

			<div class="match-card" style="--primary-color: <?= $data['primary_color'] ?>; 
            --secondary-color: <?= $data['secondary_color'] ?>;">
				<div class="match-header">
					<div class="team-box home">
						<img src="<?= $data['home_logo'] ?>" alt="" class="logo">
						<span><?php if ($data['home_name'] == "Manchester United") {
									echo "Man Utd";
								} else if ($data['home_name'] == "Manchester City") {
									echo "Man City";
								} else if ($data['home_name'] == "Tottenham Hotspur") {
									echo "Spurs";
								} else {
									echo $data['home_name'];
								} ?></span>
					</div>
					<div class="match-time"><?= substr($data['waktu'], 0, 5) ?></div>
					<div class="team-box away">
						<img src="<?= $data['away_logo'] ?>" alt="" class="logo">
						<span><?php if ($data['away_name'] == "Manchester United") {
									echo "Man Utd";
								} else if ($data['away_name'] == "Manchester City") {
									echo "Man City";
								} else if ($data['away_name'] == "Tottenham Hotspur") {
									echo "Spurs";
								} else {
									echo $data['away_name'];
								} ?></span>
					</div>
				</div>
				<div class="match-detail">
					<div>
						<p>Matchweek <?= $matchweek ?></p>
						<p><?= date("d M Y", strtotime($data['tanggal'])) ?> • <?= $data['lokasi']; ?></p>
						<p style="font-size: 12px;"><?= $data['home_name'] ?> vs <?= $data['away_name'] ?> | Season 2025/2026 | Premier League</p>
					</div>
					<div>
						<a href="pertandingan.php"><i class="bi bi-list-ul"></i> All Matches</a>
					</div>
				</div>
			</div>

			<div class="right-items">
				<form action="" method="POST">
					<h2 class="form-title">Purchase Ticket</h2>
					<a href="tiket.php" class="btn-back">Back</a>
					<div class="form-group">
						<label for="nama">Full Name</label>
						<input type="text" id="nama" name="nama" required placeholder="Enter your fullname here...">
					</div>

					<div class="form-group">
						<label for="email">Email Address</label>
						<input type="email" id="email" name="email" placeholder="Enter your email here..." required>
					</div>

					<div class="form-group">
						<label for="telp">Phone Number</label>
						<input type="text" id="telp" name="telp" placeholder="Enter your phone here..." required>
					</div>

					<div class="form-group">
						<label for="jumlah">Ticket Quantity</label>
						<input type="number" id="jumlah" name="jumlah" min="1" max="<?= $data['stok_tiket'] ?>" value="1">
					</div>

					<div class="total-box">
						<p>Total Price</p>
						<span id="total">Rp <?= number_format($data['harga_tiket'], 0, ',', '.') ?></span>
					</div>

					<input type="hidden" name="id_match" value="<?= $id ?>">
					<input type="hidden" name="harga" id="harga" value="<?= $data['harga_tiket'] ?>">
					<button type="submit" class="btn-pay">Confirm & Pay</button>
				</form>
			</div>
		</div>
	</section>

	<script src="../Assets/Script/belitiketSC.js"></script>
</body>

</html>
<?php include_once "koneksi.php"; ?>

<?php
// beli tiket handler
if (empty($_SESSION['user_id']) && empty($_SESSION['user_name'])) {
	header('Location: Auth/login.php');
	exit();
}

$uid = isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
$uname = $_SESSION['user_name'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// CSRF check
		if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
				die('CSRF token tidak valid');
		}

		$pid = (int) ($_POST['pertandingan_id'] ?? 0);
		$jumlah = (int) ($_POST['jumlah'] ?? 0);
		if ($pid <= 0 || $jumlah <= 0) {
				$err = 'Input tidak valid';
		} else {
				// ambil harga
				$stmt = $koneksi->prepare("SELECT harga FROM pertandingan WHERE id = ? LIMIT 1");
				$stmt->bind_param('i', $pid);
				$stmt->execute();
				$res = $stmt->get_result();
				if ($res && $res->num_rows === 1) {
						$row = $res->fetch_assoc();
						$harga = (float) $row['harga'];
						$total = $harga * $jumlah;

						// store both numeric user_id (if available) and username
						$ins = $koneksi->prepare("INSERT INTO bookings (user_id, user_name, pertandingan_id, jumlah, total) VALUES (?, ?, ?, ?, ?)");
						$uid_insert = $uid > 0 ? $uid : 0;
						$ins->bind_param('isidd', $uid_insert, $uname, $pid, $jumlah, $total);
						if ($ins->execute()) {
								$success = 'Pemesanan berhasil';
						} else {
								$err = 'Gagal menyimpan pemesanan';
						}
				} else {
						$err = 'Pertandingan tidak ditemukan';
				}
		}
}

// If accessed with GET?id=, show quick buy form
$pid = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($pid > 0) {
		$q = $koneksi->prepare("SELECT id, title, tanggal, harga FROM pertandingan WHERE id = ? LIMIT 1");
		$q->bind_param('i', $pid);
		$q->execute();
		$r = $q->get_result();
		$match = $r->fetch_assoc();
}
?>

<div class="row">
	<div class="col-md-6">
		<?php if (!empty($err)): ?><div class="alert alert-danger"><?php echo htmlspecialchars($err); ?></div><?php endif; ?>
		<?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>

		<?php if (!empty($match)): ?>
			<h3><?php echo htmlspecialchars($match['title']); ?></h3>
			<p>Tanggal: <?php echo htmlspecialchars($match['tanggal']); ?></p>
			<p>Harga: Rp <?php echo number_format($match['harga'],0,',','.'); ?></p>

			<form method="POST">
				<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
				<input type="hidden" name="pertandingan_id" value="<?php echo (int)$match['id']; ?>">
				<label for="jumlah">Jumlah tiket</label>
				<input type="number" name="jumlah" id="jumlah" value="1" min="1" class="form-control mb-2">
				<button class="btn btn-primary" type="submit">Beli</button>
			</form>
		<?php else: ?>
			<p>Pertandingan tidak ditemukan.</p>
		<?php endif; ?>
	</div>
</div>

<?php include_once "_footer.php"; ?>

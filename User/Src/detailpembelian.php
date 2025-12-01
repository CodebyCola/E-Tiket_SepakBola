<?php
session_start();
include __DIR__ . "/../Connection/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: Auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("ID pembelian tidak ditemukan!");
}

$id_pembelian = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Ambil detail pembelian + data pertandingan + tim
$stmt = $koneksi->prepare("
    SELECT 
        pb.*,
        p.tanggal,
        p.lokasi,
        th.nama_team AS home_name,
        th.logo_team AS home_logo,
        th.primary_color AS home_color,
        ta.nama_team AS away_name,
        ta.logo_team AS away_logo,
        ta.secondary_color AS away_color
    FROM pembelian pb
    JOIN pertandingan p ON pb.id_match = p.id_match
    JOIN teams th ON p.tim_home = th.id_team
    JOIN teams ta ON p.tim_away = ta.id_team
    WHERE pb.id_pembelian = ? AND pb.id_user = ?
");

$stmt->bind_param("ii", $id_pembelian, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Tiket tidak ditemukan atau bukan milik Anda.");
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket #<?= $id_pembelian ?> | Detail Pembelian</title>
    <link rel="stylesheet" href="../Assets/Style/detail_pembelian.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="pb-5">

    <div class="container py-5">
        <a href="riwayat.php" class="btn back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="ticket-card mx-auto" style="max-width: 700px;">
            <!-- Header Pertandingan -->
            <div class="header-match" style="background: linear-gradient(90deg, <?= $data['home_color'] ?>, <?= $data['away_color'] ?>);">
                <div class="row align-items-center justify-content-center">
                    <div class="col-auto">
                        <img src="<?= $data['home_logo'] ?>" alt="" width="60" class="mt-2">
                    </div>
                    <div class="col-auto">
                        <div class="vs">VS</div>
                    </div>
                    <div class="col-auto">
                        <img src="<?= $data['away_logo'] ?>" alt="" width="60" class="mt-2">
                    </div>
                </div>
                <h3 class="mt-3 mb-0"><?= $data['home_name'] ?> vs <?= $data['away_name'] ?></h3>
                <p class="mb-0 opacity-90">
                    <i class="fas fa-map-marker-alt"></i> <?= $data['lokasi'] ?> • <?= date("d F Y", strtotime($data['tanggal'])) ?>
                </p>
            </div>

            <div class="p-4 p-md-5">
                <!-- Status & ID -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5>Order ID: #<?= str_pad($data['id_pembelian'], 6, '0', STR_PAD_LEFT) ?></h5>
                    </div>
                    <span class="status-badge <?= strtolower($data['status']) == 'paid' ? 'paid' : 'pending' ?>">
                        <?= $data['status'] ?>
                    </span>
                </div>

                <!-- QR Code (contoh pakai https://api.qrserver.com - ganti dengan generator kamu sendiri nanti) -->
                <div class="qr-section">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=TICKET<?= $data['id_pembelian'] ?>-<?= $user_id ?>" alt="QR Ticket" class="img-fluid">
                    <p class="mt-3 text-dark fw-bold">Scan untuk masuk stadion</p>
                </div>

                <!-- Detail Info -->
                <div class="mt-5">
                    <h5 class="mb-2">Detail Tiket</h5>
                    <div class="info-row">
                        <span>Jumlah Tiket</span>
                        <strong><?= $data['jumlah_tiket'] ?> tiket</strong>
                    </div>
                    <div class="info-row">
                        <span>Harga per Tiket</span>
                        <strong>Rp <?= number_format($data['total_harga'], 0, ',', '.') ?></strong>
                    </div>
                    <div class="info-row">
                        <span>Total Harga</span>
                        <strong class="text-warning fs-4">Rp <?= number_format($data['total_harga'], 0, ',', '.') ?></strong>
                    </div>
                    <div class="info-row">
                        <span>Tanggal Pembelian</span>
                        <strong><?= date("d M Y, H:i", strtotime($data['tanggal_beli'])) ?> WIB</strong>
                    </div>

                    <?php if (!empty($data['nomor_kursi'])): ?>
                        <div class="info-row">
                            <span>Nomor Kursi</span>
                            <strong><?= $data['nomor_kursi'] ?></strong>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-grid gap-3 mt-5">
                    <?php if ($data['status'] === 'Pending'): ?>
                        <form action="bayar.php" method="POST">
                            <input type="hidden" name="id_pembelian" value="<?= $data['id_pembelian'] ?>">
                            <button type="submit" name="bayar" class="btn btn-lg text-white" style="background: var(--primary);">
                                <i class="fas fa-credit-card"></i> Bayar Sekarang
                            </button>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-success btn-lg" onclick="window.print()">
                            <i class="fas fa-print"></i> Cetak / Simpan Tiket
                        </button>
                        <a href="https://wa.me/?text=Saya%20sudah%20punya%20tiket%20<?= urlencode($data['home_name'] . ' vs ' . $data['away_name']) ?>%20di%20<?= urlencode($data['lokasi']) ?>"
                            class="btn btn-lg" style="background: #25D366; color: white;">
                            <i class="fab fa-whatsapp"></i> Share ke WhatsApp
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
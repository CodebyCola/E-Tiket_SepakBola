<?php
session_start();
include __DIR__ . "/../Connection/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: Auth/login.php");
    exit();
} else {
    $id = $_SESSION['user_id'];

    $stmt = $koneksi->prepare("SELECT 
        pb.*,

        p.id_match,
        p.tanggal,
        p.lokasi,

        th.nama_team AS home_name,
        th.logo_team AS home_logo,
        th.primary_color AS home_color,

        ta.nama_team AS away_name,
        ta.logo_team AS away_logo,
        ta.secondary_color AS away_color

    FROM pembelian pb
    JOIN pertandingan p 
        ON pb.id_match = p.id_match
    JOIN teams th 
        ON p.tim_home = th.id_team
    JOIN teams ta 
        ON p.tim_away = ta.id_team
    WHERE pb.id_user = ?
");

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
    } else {
        die("Gagal mengambil data!");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purhase History</title>
    <link rel="stylesheet" href="../Assets/Style/riwayatstyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">


</head>

<body style="background-color: #150021;">
    <section id="purchase-history">
        <a href="index.php" class="back-btn">Back</a>
        <div class="history-container">
            <h1>Purchase History</h1>
            <?php while ($data = $result->fetch_assoc()): ?>
                <div class="history-card mb-3 mt-3 d-flext align-items-center">

                    <div class="left-items"
                        style=" 
                        --home-color: <?= $data['home_color'] ?>;
                        --away-color: <?= $data['away_color'] ?>; ">

                        <div class="price mb-4">Rp<?= number_format($data['total_harga'], 0, ',', '.') ?></div>
                        <span class="badge badge-match" style="color: white;">🏆 MATCH: <?= date("d M y", strtotime($data['tanggal'])) ?></span>
                    </div>

                    <div class="right-items flex-gdata-1">
                        <div class="fw-bold mb-1"><?= $data['home_name'] . " VS " . $data['away_name'] ?></div>
                        <div class="info-line"><?= $data['lokasi'] ?></div>
                        <?php if ($data['status'] === 'Pending'): ?>
                            <form action="bayar.php" method="POST">
                                <input type="hidden" name="id_pembelian" value="<?= $data['id_pembelian'] ?>">
                                <button type="submit" name="bayar" class="btn purchase">
                                    Pay Now
                                </button>
                            </form>
                        <?php else: ?>
                        <?php endif; ?>
                        <hr class="my-2">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <div class="info-title">TICKETS</div>
                                <div><?= $data['jumlah_tiket'] ?></div>
                            </div>

                            <div>
                                <div class="info-title">DATE</div>
                                <span class="badge badge-buy">Purchased: <?= date("d M y", strtotime($data['tanggal_beli'])) ?></span>
                            </div>

                            <div class="status-wrapper">
                                <div class="info-title">STATUS</div>
                                <?php
                                $color = "";
                                if ($data['status'] == "Pending") {
                                    $color = "#287effff";
                                } else if ($data['status'] == "Paid") {
                                    $color = "#1ead4bff";
                                }
                                ?>

                                <span class="status-badge" style="--status-color: <?= $color ?>">
                                    <?= $data['status'] ?>
                                </span>
                            </div>

                            <a href="cancelpayment.php?id=<?= $data['id_pembelian'] ?>" onclick="return confirm('Do you want to cancel the payment?') " class="btn cancel">
                                Cancel Payment
                            </a>
                        </div>

                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    </section>

</body>

</html>
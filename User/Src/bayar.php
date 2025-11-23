<?php
session_start();
include __DIR__ . "/../Connection/koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("location: Auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id_beli = $_POST['id_pembelian'];

    if (!empty($id_beli)) {
        $stmt = $koneksi->prepare("UPDATE pembelian SET status = 'Paid' WHERE id_pembelian = ?");
        $stmt->bind_param("i", $id_beli);
        if ($stmt->execute()) {
            header("location: riwayat.php");
            exit();
        }
    } else {
        header("location: riwayat.php");
        exit();
    }
}

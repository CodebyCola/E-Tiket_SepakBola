<?php
include __DIR__ . "/../Connection/koneksi.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
} else {
    $id_beli = $_GET['id'];
    $stmt = $koneksi->prepare("SELECT pb.*, p.* FROM pembelian pb JOIN pertandingan p ON pb.id_match = p.id_match WHERE id_pembelian = ?");
    $stmt->bind_param("i", $id_beli);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $data['stok_tiket'] += $data['jumlah_tiket'];

        $stmt = $koneksi->prepare("UPDATE pertandingan SET stok_tiket = ? WHERE id_match = ?");
        $stmt->bind_param("ii", $data['stok_tiket'], $data["id_match"]);
        $stmt->execute();

        $del = $koneksi->prepare("DELETE FROM pembelian WHERE id_pembelian = ?");
        $del->bind_param("i", $id_beli);
        if ($del->execute()) {
            echo "<script>alert('Purchase successfully canceled');
            window.location.href='riwayat.php';
            </script>";
        }
    } else {
        die("Tidak ditemukan id pembelian");
    }
}

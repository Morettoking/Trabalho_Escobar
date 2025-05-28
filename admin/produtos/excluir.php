<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: ../login.php'); exit; }
include '../../includes/config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->execute([$id]);

$imagePath = "../../assets/img/produtos/$id.jpg";
if (file_exists($imagePath)) {
    unlink($imagePath);
}

header('Location: index.php');
exit;

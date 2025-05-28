<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: ../login.php'); exit; }
include '../../includes/config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM categorias WHERE id = ?");
$stmt->execute([$id]);
header('Location: index.php');
exit;

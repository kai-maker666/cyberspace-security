<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM articles WHERE id=?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
?>
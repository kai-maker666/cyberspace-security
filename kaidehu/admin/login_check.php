<?php
session_start();
include '../config.php'; // 引入数据库配置

// 获取表单数据
$username = $_POST['username'];
$password = $_POST['password'];

// 从数据库查询管理员
$stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
$stmt->execute([$username]);
$admin = $stmt->fetch();

// 直接对比明文密码
if ($admin && $admin['password'] === $password) {
    $_SESSION['admin'] = true;
    header("Location: index.php");
    exit;
} else {
    header("Location: login.php?error=1");
    exit;
}
?>
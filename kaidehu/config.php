<?php
// 数据库配置信息（小皮面板专用）
$db_host = 'localhost';
$db_user = 'kai';
$db_pass = 'kai123';  // 这里只改这个！
$db_name = 'kaidehu';

// 创建数据库连接（安全版 PDO）
try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );
} catch (PDOException $e) {
    die("数据库连接失败：" . $e->getMessage());
}
?>
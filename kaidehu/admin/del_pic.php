<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../config.php';

$id = $_GET['id'] ?? 0;
$article_id = $_GET['article_id'] ?? 0;

if (!$id || !$article_id) {
    header("Location: index.php");
    exit;
}

// 再加一层安全提示
echo "<script>
if(!confirm('真的要删除这张图片吗？删除后无法恢复！')){
    location.href='edit.php?id=<?=$article_id?>';
}
</script>";

// 删除数据库记录
$stmt = $pdo->prepare("DELETE FROM photos WHERE id = ?");
$stmt->execute([$id]);

// 跳回编辑页
header("Location: edit.php?id=$article_id");
exit;
?>
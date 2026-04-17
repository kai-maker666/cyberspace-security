<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../config.php';

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];

// 1. 更新文字
$stmt = $pdo->prepare("UPDATE articles SET title=?, content=? WHERE id=?");
$stmt->execute([$title, $content, $id]);

// 2. 上传新图片（如果有）
if (!empty($_FILES['pics']['tmp_name'][0])) {
    foreach ($_FILES['pics']['tmp_name'] as $i => $tmp) {
        $ext = pathinfo($_FILES['pics']['name'][$i], PATHINFO_EXTENSION);
        $name = uniqid() . ".$ext";
        $dest = "../uploads/$name";
        move_uploaded_file($tmp, $dest);

        $s = $pdo->prepare("INSERT INTO photos (article_id, path) VALUES (?,?)");
        $s->execute([$id, $name]);
    }
}

// 跳回列表
header("Location: index.php");
exit;
?>
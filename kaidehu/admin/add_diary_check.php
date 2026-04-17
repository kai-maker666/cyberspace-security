<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }
include '../config.php';

$title = $_POST['title'];
$content = $_POST['content'];

// 先发布日记
$stmt = $pdo->prepare("INSERT INTO articles (title,content) VALUES (?,?)");
$stmt->execute([$title, $content]);
$article_id = $pdo->lastInsertId();

// 创建上传目录
if(!is_dir('../uploads')) mkdir('../uploads');

// 上传图片到 photos 表
if(!empty($_FILES['pics']['tmp_name'][0])){
  foreach($_FILES['pics']['tmp_name'] as $i=>$tmp){
    $ext = pathinfo($_FILES['pics']['name'][$i],PATHINFO_EXTENSION);
    $name = uniqid().'.'.$ext;
    $dest = '../uploads/'.$name;
    move_uploaded_file($tmp,$dest);
    
    $s = $pdo->prepare("INSERT INTO photos (article_id,path) VALUES (?,?)");
    $s->execute([$article_id,$name]);
  }
}

echo "发布成功！<a href='index.php'>返回后台</a>";
?>
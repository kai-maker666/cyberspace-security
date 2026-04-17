<?php
include 'config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title><?=$row['title']?></title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:微软雅黑}
        body{background:#f5f5f5;padding:20px}
        .container{
            background:white;
            padding:30px;
            border-radius:8px;
            max-width:800px;
            margin:0 auto;
        }
        h1{
            margin-bottom:15px;
            color:#333;
        }
        .content{
            line-height:1.8;
            font-size:16px;
            color:#444;
            margin-top:20px;
            white-space:pre-wrap;
        }
        .time{
            color:#999;
            font-size:14px;
        }
        a{
            display:inline-block;
            margin-bottom:20px;
            color:#4e73df;
            text-decoration:none;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php">← 返回首页</a>
    <h1><?=$row['title']?></h1>
    <div class="time"><?=$row['create_time']?></div>
    <div class="content"><?=$row['content']?></div>
</div>

</body>
</html>
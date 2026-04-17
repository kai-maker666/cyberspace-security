<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../config.php';

// 读取所有日记
$stmt = $pdo->query("SELECT * FROM articles ORDER BY create_time DESC");
$list = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>管理后台</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:微软雅黑}
        body{padding:20px;background:#f5f5f5}
        .nav{
            background:#4e73df;padding:15px;
            border-radius:8px;margin-bottom:20px;color:white
        }
        .nav a{
            color:white;margin-right:15px;text-decoration:none
        }
        .container{
            background:white;padding:20px;border-radius:8px;
        }
        table{
            width:100%;border-collapse:collapse;margin-top:15px
        }
        th,td{
            border:1px solid #ddd;padding:10px;text-align:left
        }
        th{background:#f8f9fa}
        .btn{
            padding:5px 10px;border-radius:4px;
            text-decoration:none;color:white;font-size:14px
        }
        .edit{background:#4e73df}
        .del{background:#e74a3a}
    </style>
</head>
<body>

<div class="nav">
    <a href="index.php">后台首页</a>
    <a href="add_diary.php">发布日记</a>
    <a href="../home.php">返回首页</a>
    <a href="logout.php">退出登录</a>
</div>

<div class="container">
    <h2>📝 日记管理列表</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>标题</th>
            <th>时间</th>
            <th>操作</th>
        </tr>
        <?php foreach($list as $row): ?>
        <tr>
            <td><?=$row['id']?></td>
            <td><?=$row['title']?></td>
            <td><?=$row['create_time']?></td>
            <td>
                <a href="edit.php?id=<?=$row['id']?>" class="btn edit">编辑</a>
                <a href="delete.php?id=<?=$row['id']?>" class="btn del" onclick="return confirm('确定删除？')">删除</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
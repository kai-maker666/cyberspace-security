<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

// 取出当前文章的所有图片
$picStmt = $pdo->prepare("SELECT * FROM photos WHERE article_id = ?");
$picStmt->execute([$id]);
$photos = $picStmt->fetchAll();
?>

<!DOCTYPE html>
<meta charset="UTF-8">
<title>编辑动态</title>
<style>
*{box-sizing:border-box;font-family:微软雅黑}
body{background:#f5f5f5;padding:20px}
.main{max-width:700px;background:#fff;margin:0 auto;padding:25px;border-radius:12px}
h2{margin-bottom:20px}
input,textarea{width:100%;padding:12px;margin:8px 0;border:1px solid #ddd;border-radius:8px}
textarea{height:140px}
.upload{background:#eee;padding:8px 12px;border-radius:6px;display:inline-block}
#preview{display:flex;gap:8px;flex-wrap:wrap;margin:10px 0}
#preview img{width:100px;height:100px;object-fit:cover;border-radius:6px}
.existing-img{position:relative;display:inline-block}
.existing-img img{width:100px;height:100px;object-fit:cover;border-radius:6px}
.existing-img a{
    position:absolute;top:0;right:0;background:red;color:#fff;
    padding:2px 6px;font-size:12px;text-decoration:none
}
.btns{margin-top:20px;display:flex;gap:10px}
button{background:#4e73df;color:white;border:none;padding:12px 20px;border-radius:8px;cursor:pointer}
.btn-cancel{background:#6c757d}
</style>

<div class="main">
<h2>✏️ 编辑图文动态</h2>

<form action="update.php" method="post" enctype="multipart/form-data" id="editForm">
<input type="hidden" name="id" value="<?=$row['id']?>">

标题：<input type="text" name="title" value="<?=$row['title']?>" required>
内容：<textarea name="content"><?=$row['content']?></textarea>

<!-- 已上传的图片（可删除） -->
<div style="margin:10px 0">
<label>已上传图片：</label>
<div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:5px">
    <?php foreach($photos as $p): ?>
    <div class="existing-img">
        <img src="../uploads/<?=$p['path']?>">
        <a href="del_pic.php?id=<?=$p['id']?>&article_id=<?=$row['id']?>"
           onclick="return confirm('确定要删除这张图片吗？\n删除后可重新上传，但无法撤销！')">×</a>
    </div>
    <?php endforeach; ?>
</div>
</div>

<!-- 上传新图片 -->
<label class="upload">➕ 上传新图片（可多张）
<input type="file" name="pics[]" multiple accept="image/*" style="display:none" id="file">
</label>
<div id="preview"></div>

<!-- 保存 + 取消按钮 -->
<div class="btns">
    <button type="submit">✅ 保存修改</button>
    <button type="button" class="btn-cancel" onclick="history.back()">❌ 取消/返回</button>
</div>
</form>
</div>

<script>
const file = document.getElementById('file');
const preview = document.getElementById('preview');
file.addEventListener('change',()=>{
    preview.innerHTML='';
    for(let i=0;i<file.files.length;i++){
        let img = document.createElement('img');
        img.src=URL.createObjectURL(file.files[i]);
        preview.appendChild(img);
    }
})
</script>
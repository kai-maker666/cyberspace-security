<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<title>发布朋友圈动态</title>
<style>
*{box-sizing:border-box;font-family:微软雅黑}
body{background:#f5f5f5;padding:20px}
.main{max-width:700px;background:#fff;margin:0 auto;padding:25px;border-radius:12px}
h2{margin-bottom:20px}
input,textarea{width:100%;padding:12px;margin:8px 0;border:1px solid #ddd;border-radius:8px}
textarea{height:140px}
#preview{display:flex;gap:8px;flex-wrap:wrap;margin:10px 0}
#preview img{width:100px;height:100px;object-fit:cover;border-radius:6px}
button{background:#4e73df;color:white;border:none;padding:12px 20px;border-radius:8px;cursor:pointer}
.upload{background:#eee;padding:8px 12px;border-radius:6px;display:inline-block}
</style>

<div class="main">
<h2>📷 发布图文动态</h2>
<form action="add_diary_check.php" method="post" enctype="multipart/form-data">
标题：<input type="text" name="title" required>
内容：<textarea name="content" placeholder="分享你的心情..."></textarea>

<label class="upload">选择图片（可多张）
<input type="file" name="pics[]" multiple accept="image/*" style="display:none" id="file">
</label>
<div id="preview"></div>

<button type="submit">发布</button>
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
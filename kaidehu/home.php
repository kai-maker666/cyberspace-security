<?php
include 'config.php';
$list = $pdo->query("SELECT * FROM articles ORDER BY create_time DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kai的壶</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "微软雅黑", sans-serif;
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            display: flex;
            min-height: 100vh;
        }

        /* 左侧导航栏 */
        .sidebar {
            width: 260px;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            padding: 30px 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .profile {
            text-align: center;
            margin-bottom: 30px;
        }
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 40px;
            margin: 0 auto 15px;
        }
        .nickname {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .bio {
            font-size: 14px;
            color: #888;
        }
        .menu {
            list-style: none;
        }
        .menu li {
            margin-bottom: 15px;
        }
        .menu a {
            display: block;
            padding: 12px 15px;
            border-radius: 8px;
            text-decoration: none;
            color: #555;
            transition: all 0.3s;
        }
        .menu a:hover, .menu a.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        /* 主内容区 */
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 30px;
            max-width: 900px;
        }
        .page-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }
        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .card h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }
        .time {
            color: #999;
            font-size: 13px;
            margin-bottom: 15px;
        }
        .content {
            line-height: 1.8;
            color: #555;
            margin-bottom: 15px;
        }
        .pics {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .pics img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .pics img:hover {
            transform: scale(1.05);
        }

        /* 全屏查看器样式 */
        .viewer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }
        .viewer.active {
            display: flex;
        }
        .viewer img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }
        .viewer .close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 40px;
            cursor: pointer;
        }
        .viewer .prev, .viewer .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 50px;
            cursor: pointer;
            padding: 20px;
        }
        .viewer .prev { left: 20px; }
        .viewer .next { right: 20px; }

        /* 响应式适配 */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            body {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<!-- 左侧导航栏 -->
<div class="sidebar">
    <div class="profile">
        <div class="avatar">
          <img src="uploads/hu1.png" alt="头像" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
        </div>
        <div class="nickname">我的壶</div>
        <div class="bio">kaide点点滴滴 ✨</div>
    </div>
    <ul class="menu">
        <li><a href="#" class="active">🏠 首页动态</a></li>
        <li><a href="admin/login.php">✏️ 发布动态</a></li>
        <li><a href="#">📚 kai的收藏</a></li>
        <li><a href="#">⚙️ 个人设置</a></li>
    </ul>
</div>

<!-- 主内容区 -->
<div class="main-content">
    <h1 class="page-title">📝 kai的壶</h1>

    <?php foreach($list as $row): ?>
    <div class="card">
        <h3><?=$row['title']?></h3>
        <div class="time"><?=$row['create_time']?></div>
        <div class="content"><?=$row['content']?></div>

        <?php
        $pid = $row['id'];
        $photos = $pdo->prepare("SELECT * FROM photos WHERE article_id = ?");
        $photos->execute([$pid]);
        $pics = $photos->fetchAll();
        ?>

        <?php if($pics): ?>
        <div class="pics">
            <?php foreach($pics as $p): ?>
            <img src="uploads/<?=$p['path']?>" data-src="uploads/<?=$p['path']?>">
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<!-- 全屏查看器 -->
<div class="viewer" id="viewer">
    <span class="close">&times;</span>
    <span class="prev">&#10094;</span>
    <img id="viewer-img" src="">
    <span class="next">&#10095;</span>
</div>

<script>
const viewer = document.getElementById('viewer');
const viewerImg = document.getElementById('viewer-img');
const pics = document.querySelectorAll('.pics img');
const closeBtn = document.querySelector('.viewer .close');
const prevBtn = document.querySelector('.viewer .prev');
const nextBtn = document.querySelector('.viewer .next');

let currentImages = [];
let currentIndex = 0;

// 点击小图打开查看器
pics.forEach((img, index) => {
    img.addEventListener('click', () => {
        // 获取当前文章的所有图片
        const parent = img.closest('.pics');
        currentImages = Array.from(parent.querySelectorAll('img'));
        currentIndex = currentImages.indexOf(img);
        viewerImg.src = img.dataset.src;
        viewer.classList.add('active');
    });
});

// 关闭查看器
closeBtn.addEventListener('click', () => {
    viewer.classList.remove('active');
});
viewer.addEventListener('click', (e) => {
    if (e.target === viewer) {
        viewer.classList.remove('active');
    }
});

// 切换图片
prevBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
    viewerImg.src = currentImages[currentIndex].dataset.src;
});
nextBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    currentIndex = (currentIndex + 1) % currentImages.length;
    viewerImg.src = currentImages[currentIndex].dataset.src;
});
</script>

</body>
</html>
<?php
session_start();
session_destroy(); // 销毁登录会话
header("Location: login.php");
exit;
?>
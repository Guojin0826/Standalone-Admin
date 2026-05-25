<?php
require_once 'config.php';

// 检查是否登录
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>
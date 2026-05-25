<?php
require_once 'auth.php';
require_once 'config.php';

$conn = getConnection();

// 统计数据
$userCount = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理首页</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            font-size: 24px;
        }
        .header a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
        }
        .container {
            display: flex;
            min-height: calc(100vh - 70px);
        }
        .sidebar {
            width: 200px;
            background: white;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #f0f0f0;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background: #667eea;
            color: white;
        }
        .main {
            flex: 1;
            padding: 30px;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            color: #999;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .stat-card .number {
            font-size: 32px;
            color: #667eea;
            font-weight: bold;
        }
        .welcome {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .welcome h2 {
            color: #333;
            margin-bottom: 15px;
        }
        .welcome p {
            color: #666;
            line-height: 1.8;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>后台管理系统</h1>
        <div>
            <span>欢迎, <?php echo $_SESSION['admin_username']; ?></span>
            <a href="logout.php" style="margin-left: 15px;">退出</a>
        </div>
    </div>
    
    <div class="container">
        <div class="sidebar">
            <a href="index.php" class="active">首页</a>
            <a href="users.php">用户管理</a>
        </div>
        
        <div class="main">
            <div class="stats">
                <div class="stat-card">
                    <h3>用户总数</h3>
                    <div class="number"><?php echo $userCount; ?></div>
                </div>
            </div>
            
            <div class="welcome">
                <h2>欢迎使用后台管理系统</h2>
                <p>这是一个简单的PHP后台管理系统，包含以下功能：</p>
                <p>• 用户登录验证</p>
                <p>• 用户管理（增删改查）</p>
                <p>• 简洁的后台界面</p>
            </div>
        </div>
    </div>
</body>
</html>

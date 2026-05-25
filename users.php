<?php
require_once 'auth.php';
require_once 'config.php';

$conn = getConnection();
$message = '';

// 处理删除
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM users WHERE id = $id");
    $message = '删除成功';
}

// 处理添加/编辑
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    
    if (isset($_POST['id']) && $_POST['id']) {
        // 编辑
        $id = (int)$_POST['id'];
        $sql = "UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id=$id";
        $conn->query($sql);
        $message = '更新成功';
    } else {
        // 添加
        $sql = "INSERT INTO users (name, email, phone) VALUES ('$name', '$email', '$phone')";
        $conn->query($sql);
        $message = '添加成功';
    }
}

// 获取用户列表
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");

$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户管理</title>
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
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .card h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }
        table th {
            background: #f8f9fa;
            color: #666;
        }
        .message {
            padding: 10px;
            background: #d4edda;
            color: #155724;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .actions a {
            margin-right: 5px;
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
            <a href="index.php">首页</a>
            <a href="users.php" class="active">用户管理</a>
        </div>
        
        <div class="main">
            <?php if ($message): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <div class="card">
                <h2>添加用户</h2>
                <form method="POST">
                    <input type="hidden" name="id" id="editId">
                    <div class="form-group">
                        <label>姓名</label>
                        <input type="text" name="name" id="editName" required>
                    </div>
                    <div class="form-group">
                        <label>邮箱</label>
                        <input type="email" name="email" id="editEmail" required>
                    </div>
                    <div class="form-group">
                        <label>电话</label>
                        <input type="text" name="phone" id="editPhone">
                    </div>
                    <button type="submit" class="btn btn-primary">保存</button>
                </form>
            </div>
            
            <div class="card">
                <h2>用户列表</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>邮箱</th>
                            <th>电话</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $users->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td><?php echo $user['created_at']; ?></td>
                            <td class="actions">
                                <a href="#" class="btn btn-primary btn-sm" onclick="editUser(<?php echo htmlspecialchars(json_encode($user)); ?>)">编辑</a>
                                <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('确定删除?')">删除</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        function editUser(user) {
            document.getElementById('editId').value = user.id;
            document.getElementById('editName').value = user.name;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editPhone').value = user.phone || '';
        }
    </script>
</body>
</html>

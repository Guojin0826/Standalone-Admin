<<<<<<< HEAD
# PHP 后台管理系统

一个简单的PHP后台管理系统，包含登录、用户管理等功能。

## 功能特性

- ✅ 管理员登录验证
- ✅ 用户管理（增删改查）
- ✅ 简洁的后台界面
- ✅ 密码加密存储
- ✅ 会话管理

## 安装说明

### 1. 环境要求

- PHP 5.6 或更高版本
- MySQL 5.5 或更高版本
- Apache/Nginx 服务器

### 2. 安装步骤

1. 将所有文件复制到Web服务器的根目录或子目录中

2. 修改 `config.php` 中的数据库配置：
   ```php
   define('DB_HOST', 'localhost');     // 数据库主机
   define('DB_USER', 'root');          // 数据库用户名
   define('DB_PASS', '');              // 数据库密码
   define('DB_NAME', 'admin_system');  // 数据库名称
   ```

3. 确保PHP已安装mysqli扩展

4. 访问 `login.php` 或 `index.php`，系统会自动创建数据库和数据表

### 3. 默认账号

- 用户名：`admin`
- 密码：`admin123`

**请在首次登录后立即修改密码！**

## 文件说明

```
├── config.php      # 数据库配置和初始化
├── login.php       # 登录页面
├── logout.php      # 退出登录
├── auth.php        # 权限验证
├── index.php       # 后台首页
├── users.php       # 用户管理
└── README.md       # 说明文档
```

## 使用说明

1. 访问系统登录页面
2. 使用默认账号登录
3. 在用户管理页面可以添加、编辑、删除用户
4. 点击右上角"退出"按钮可以退出登录

## 安全建议

1. 修改默认管理员密码
2. 在生产环境中关闭错误显示
3. 使用HTTPS协议
4. 定期备份数据库
5. 限制后台访问IP（可选）

## 许可证

MIT License
=======
# Standalone-Admin
一个简单的php后台管理
>>>>>>> 5b846b09535d92301adf5b0625da7ac72f8f361e

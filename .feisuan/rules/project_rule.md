
# 开发规范指南

为保证代码质量、可维护性、安全性与可扩展性，请在开发过程中严格遵循以下规范。

## 一、技术栈与环境要求

- **操作系统**：Windows 10
- **工作区路径**：`H:\问道实验室\aa`
- **JDK 版本**：JDK 1.8.0_131
- **构建工具**：Maven
- **代码作者**：guojin
- **注释语言**：中文（第一语言）

> **注意**：由于 JDK 版本为 1.8，所有依赖包需兼容 Java 8 标准（如使用 `javax.*` 而非 `jakarta.*`）。

## 二、项目目录结构

请严格遵循以下目录结构进行开发，确保模块清晰、职责分明：

```text
aa/
├── pom.xml
├── src/
│   ├── main/
│   │   ├── java/
│   │   │   └── com/example/aa/          # 基础包名（根据实际项目调整）
│   │   │       ├── AaApplication.java    # 启动类
│   │   │       ├── controller/           # 控制层
│   │   │       ├── service/              # 服务接口层
│   │   │       │   └── impl/             # 服务实现层
│   │   │       ├── repository/           # 数据访问层（DAO/Mapper）
│   │   │       ├── entity/               # 实体类（DO/Entity）
│   │   │       ├── dto/                  # 数据传输对象
│   │   │       ├── vo/                   # 视图对象
│   │   │       └── config/               # 配置类
│   │   └── resources/
│   │       ├── application.yml           # 应用配置文件
│   │       └── mapper/                   # MyBatis XML 映射文件（如使用）
│   └── test/
│       └── java/                         # 单元测试
```

## 三、分层架构规范

| 层级        | 职责说明                         | 开发约束与注意事项                                               |
|-------------|----------------------------------|----------------------------------------------------------------|
| **Controller** | 处理 HTTP 请求与响应，定义 API 接口 | 不得直接访问数据库，必须通过 Service 层调用；统一返回结果封装类 |
| **Service**    | 实现业务逻辑、事务管理与数据校验   | 定义接口，实现类放在 `impl` 包中；通过 Repository 访问数据     |
| **Repository** | 数据库访问与持久化操作             | 继承 `JpaRepository` 或使用 MyBatis Mapper；避免 N+1 查询      |
| **Entity**     | 映射数据库表结构                   | 不得直接返回给前端；包名统一为 `entity`                         |

### 接口与实现分离

- 所有 Service 接口需放在 `service` 包下。
- 对应的实现类必须放在 `service.impl` 子包中。
- Controller 层通过 `@Autowired` 或构造函数注入 Service 接口。

## 四、安全与性能规范

### 输入校验

- 使用 JSR-303 校验注解（如 `@NotBlank`, `@Size` 等）。
  - **注意**：JDK 1.8 环境下，校验注解位于 `javax.validation.constraints.*` 包下。
- 禁止手动拼接 SQL 字符串，防止 SQL 注入攻击。

### 事务管理

- `@Transactional` 注解仅用于 **Service 层**方法。
- 避免在循环中频繁提交事务，影响性能。
- 明确指定回滚规则，例如：`@Transactional(rollbackFor = Exception.class)`

## 五、代码风格规范

### 命名规范

| 类型       | 命名方式             | 示例                  |
|------------|----------------------|-----------------------|
| 类名       | UpperCamelCase       | `UserServiceImpl`     |
| 方法/变量  | lowerCamelCase       | `saveUser()`          |
| 常量       | UPPER_SNAKE_CASE     | `MAX_LOGIN_ATTEMPTS`  |

### 注释规范

- **所有类、方法、字段必须添加中文 Javadoc 注释**。
- 复杂业务逻辑需在方法内部添加行级注释。
- 示例：
  ```java
  /**
   * 保存用户信息
   * @param userDTO 用户数据传输对象
   * @return 保存后的用户ID
   */
  Long saveUser(UserDTO userDTO);
  ```

### 类型命名规范（阿里巴巴风格）

| 后缀 | 用途说明                     | 示例         |
|------|------------------------------|--------------|
| DTO  | 数据传输对象                 | `UserDTO`    |
| DO   | 数据库实体对象               | `UserDO`     |
| BO   | 业务逻辑封装对象             | `UserBO`     |
| VO   | 视图展示对象                 | `UserVO`     |
| Query| 查询参数封装对象             | `UserQuery`  |

### 实体类简化工具

- 若使用 Lombok，请确保 Maven 依赖版本兼容 JDK 1.8：
  - `@Data`
  - `@NoArgsConstructor`
  - `@AllArgsConstructor`

## 六、扩展性与日志规范

### 接口优先原则

- 所有业务逻辑通过接口定义（如 `UserService`），具体实现放在 `impl` 包中（如 `UserServiceImpl`）。

### 日志记录

- 使用 `@Slf4j` 注解（Lombok）或 `LoggerFactory` 代替 `System.out.println`。
- 日志级别规范：
  - `ERROR`：系统错误、异常
  - `WARN`：警告信息、非致命错误
  - `INFO`：关键业务流程、启动关闭
  - `DEBUG`：详细调试信息

## 七、编码原则总结

| 原则       | 说明                                       |
|------------|--------------------------------------------|
| **SOLID**  | 高内聚、低耦合，增强可维护性与可扩展性     |
| **DRY**    | 避免重复代码，提高复用性                   |
| **KISS**   | 保持代码简洁易懂                           |
| **YAGNI**  | 不实现当前不需要的功能                     |
| **OWASP**  | 防范常见安全漏洞，如 SQL 注入、XSS 等      |

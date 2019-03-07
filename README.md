# CakePHP 3.7 + BJUI 快速开发后台模板

BJUI框架地址：[https://github.com/JZaaa/BJUI](https://github.com/JZaaa/BJUI)

默认账号： admin

密码：123456

## 开始使用

### 安装

````
composer install
````

### 数据库

- `sql`文件导入：向`msyql`中导入 根目录下的`cakeadmin_3_7.sql`文件

### Linux文件夹权限

Linux系统可能会出现文件权限的问题，请给以下文件与子文件添加权限：
````
/logs
/tmp
/files
/webroot/assets/b-jui/BJUI/plugins/kindeditor/attached
````

### 生产环境部署
- 设置`debug=false`
- 推荐文档根目录设置为`webroot`
- 【可选】composer重新加载类以优化项目加载速度
```
php composer dumpautoload -o
``` 
- 【可选】涉及到类的静态文件，运行以下命令之一以优化速度
```
// 以 符号链接 形式创建静态文件
bin/cake plugin assets symlink
// 若不支持 符合链接，用此命令复制静态文件
bin/cake plugin assets copy
```
- 清除缓存
```
bin/cake schema_cache clear
bin/cake cache clear_all
```

### 其他
- `DebugKit`默认未启用，启用请修改`Application.php`文件对应代码
- `csrf` 组件默认已关闭，启用请在`routes.php` 添加相关代码

## 拓展

### 服务器无法开启Intl拓展解决方法
````
composer require cakedc/intl --ignore-platform-reqs
````
在config/requirements.php中找到并注释
````
if (!extension_loaded('intl')) {
     trigger_error('You must enable the intl extension to use CakePHP.', E_USER_ERROR);
}
````

### 跨域
````
composer require ozee31/cakephp-cors

// 加载插件
bin/cake plugin load Cors --bootstrap
````
配置
````
    // in app.php
    /**
     * 跨域配置
     * - AllowOrigin [array|bool|string]  - 设置 true/* 允许全部， 可用字符串或数组指定允许跨域地址
     * - AllowMethods [array] - 设置允许访问类型
     * - MaxAge [number|false] - 缓存时间, 开发请设置为false
     * - AllowHeaders [true|array|string]
     * - ExposeHeaders [array|string|false] - 允许访问头
     */
    'Cors' => [
        // Accept all origins
        'AllowOrigin' => true,

        'AllowMethods' => ['GET', 'POST'],

        'MaxAge' => 86400, // 缓存一天

        'ExposeHeaders' => ['X-Token']
    ]
````

## Token令牌
**[使用方法](https://www.jianshu.com/p/762679ea1ff8)**
````
composer require admad/cakephp-jwt-auth

bin/cake plugin load ADmad/JwtAuth
````




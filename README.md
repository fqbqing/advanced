Yii 2 Advanced Project Template
===============================

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii2-app-advanced/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii2-app-advanced/downloads.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
tests                    contains various tests for the advanced application
    codeception/         contains tests developed with Codeception PHP Testing Framework
```

搭建 rabc 后台系列教程（一）—— 安装 yii2 和 composer
http://www.getyii.com/topic/546


2、使用中国镜像：由于众所周知的原因，国外的网站连接速度很慢，并且随时可能被“墙”甚至“不存在”。

进入 cmd，输入：
composer config -g repo.packagist composer https://packagist.phpcomposer.com
安装最新的Composer 资源插件

进入 cmd，输入：composer global require "fxp/composer-asset-plugin:~1.1.1"

注：更新 yii2 ，进入 cmd ，切换目录到 advanced，输入
composer update yiisoft/yii2 yiisoft/yii2-composer bower-asset/jquery.inputmask


3最简单的权限实现方法
http://www.getyii.com/topic/585
common/data/user.sql导入数据库,后从frontend注册一个帐户即可

4、API available:

```php
// version 1
OPTIONS /index.php?r=v1/user/login
POST /index.php?r=v1/user/login

OPTIONS /index.php?r=v1/posts
GET /index.php?r=v1/posts
GET /index.php?r=v1/posts/ID
POST /index.php?r=v1/posts
PUT /index.php?r=v1/posts/ID
DELETE /index.php?r=v1/posts/ID

OPTIONS /index.php?r=v1/comments
GET /index.php?r=v1/comments
GET /index.php?r=v1/comments/ID
POST /index.php?r=v1/comments
PUT /index.php?r=v1/comments/ID
DELETE /index.php?r=v1/comments/ID

//version 2
OPTIONS /index.php?r=v2/user/login
POST /index.php?r=v2/user/login
```

You can hide `index.php` from URL. For that see [server.md](server.md)

5、api开发参考

http://www.fancyecommerce.com/2016/05/04/yii2-restful-%E6%8E%A5%E5%8F%A3-api-1-%EF%BC%9A-%E6%8E%A5%E5%8F%A3%E7%9A%84%E5%9F%BA%E6%9C%AC%E9%85%8D%E7%BD%AE/

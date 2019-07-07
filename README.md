<h1 align="center"> thinkphp5-curd </h1>

<p align="center">
基于Thinkphp5自定义命令行工具，根据数据表结构创建更完善的model，validate，controller类的开发者工具。

如果你经常写后台管理系统的CURD，那么这个扩展包非常适合你，针对thinkphp5官方命令进行了增强，根据传入的数据表名，创建功能更完善的model，validate，controller类，减少重复造轮子的时间，让你更专注于核心业务开发。
</p>

## Installing

```shell
$ composer require haojohnny/tp5-curd -vvv
```

## Usage

在Thinkphp5框架的command.php文件中，加入工具命令
```php
<?php

    return [
        'Haojohnny\Tp5Curd\Command\Curd',
        'Haojohnny\Tp5Curd\Command\Model',
        'Haojohnny\Tp5Curd\Command\Validate',
        'Haojohnny\Tp5Curd\Command\Controller',
    ];
```

在应用根目录下执行
    
    php think

将列出该工具的命令用法

    make:curd             Creat model,validate,controller class for CURD
    make:curd-controller  Creat a new controller class for CURD
    make:curd-model       Creat a new validate class for CURD
    make:curd-validate    Creat a new validate class for CURD


## demo

数据表w_user的DDL
```sql
CREATE TABLE `w_user` (
   `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
   `wechat_nickname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '微信昵称',
   `avatar_url` varchar(255) CHARACTER SET utf8mb4 NOT NULL COMMENT '头像',
   `province` varchar(64) CHARACTER SET utf8mb4 NOT NULL COMMENT '所在省份',
   `city` varchar(64) CHARACTER SET utf8mb4 NOT NULL COMMENT '所在城市',
   `wechat_union_id` varchar(64) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '微信unionid',
   `applet_open_id` varchar(64) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '小程序openid',
   `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别 0：未知  1：男 2：女',
   `mobile` char(11) CHARACTER SET utf8mb4 NOT NULL COMMENT '手机号',
   `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
   PRIMARY KEY (`user_id`)
 ) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='用户表';
```

执行命令

    php think make:curd index/User w_user
    
将会在应用的index模块创建名为User的模型，验证器，控制器。以下代码是命令执行生成User.php验证器代码的结果。
```php
<?php
// +--
// | Date: 2019-07-07 11:34
// | Remark:
// |

namespace app\index\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'user_id' => 'require|number',
        'wechat_nickname' => 'require|max:100',
        'avatar_url' => 'require|max:255',
        'province' => 'require|max:64',
        'city' => 'require|max:64',
        'wechat_union_id' => 'require|max:64',
        'applet_open_id' => 'require|max:64',
        'gender' => 'require',
        'mobile' => 'require|length:11',
        'reg_time' => 'require',
        
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'user_id.require' => '用户ID必须填写',
        'user_id.number' => '用户ID数据格式必须为数字',
        'wechat_nickname.require' => '微信昵称必须填写',
        'wechat_nickname.max' => '微信昵称最大长度为100个字符',
        'avatar_url.require' => '头像必须填写',
        'avatar_url.max' => '头像最大长度为255个字符',
        'province.require' => '所在省份必须填写',
        'province.max' => '所在省份最大长度为64个字符',
        'city.require' => '所在城市必须填写',
        'city.max' => '所在城市最大长度为64个字符',
        'wechat_union_id.require' => '微信unionid必须填写',
        'wechat_union_id.max' => '微信unionid最大长度为64个字符',
        'applet_open_id.require' => '小程序openid必须填写',
        'applet_open_id.max' => '小程序openid最大长度为64个字符',
        'gender.require' => '性别 0：未知  1：男 2：女必须填写',
        'mobile.require' => '手机号必须填写',
        'mobile.length' => '手机号长度必须为11个字符',
        'reg_time.require' => '注册时间必须填写',
        
    ];

    protected $scene = [
        'insert' => ['wechat_nickname', 'avatar_url', 'province', 'city', 'wechat_union_id', 'applet_open_id', 'gender', 'mobile', 'reg_time'],
        'update' => ['user_id', 'wechat_nickname', 'avatar_url', 'province', 'city', 'wechat_union_id', 'applet_open_id', 'gender', 'mobile', 'reg_time'],        
    ];
}

```

    

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/haojohnny/tp5-curd/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/haojohnny/tp5-curd/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT
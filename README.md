#常用的thinkphp common模块封装方法



##  api返回常用
~~~php
use Gz\TpCommon\utils\Ajax;

#成功返回:  return Ajax::success();
#成功返回:  return Ajax::error();
~~~

## 默认状态值
### 默认
~~~php
use Gz\TpCommon\consts\Status;

Status::argumentsErr();  //参数错误
...
~~~
### 多语言
~~~php
//配置类默认 /config/lang.php  默认语言

//自定义语言 app/lang/当前语言.php 
Status::(定义的语言key值)() //方法类型调用

~~~



# 错误和日志
## 异常处理
### 抛出异常
需要在app目录下面的provider.php文件中绑定异常处理类，例如
~~~php
 // 绑定自定义异常处理handle类
'think\exception\Handle' => \Gz\TpCommon\exception\handle\ExceptionHandle::class,
~~~
使用
~~~php
use Gz\TpCommon\exception\Error;

throw new Error("msg");

~~~

## 提前输出客户端
~~~php
use Gz\TpCommon\exception\Response;
return Response::instance()->send("msg",$data,$code);
~~~

# 表
## 默认配置表
前端文件路径存放等

value字段格式: [{"key":"merchantTpl","value":"merchantTpl"}]

~~~
CREATE TABLE `jsdh_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `en_name` varchar(100) DEFAULT NULL,
  `zh_name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL COMMENT '值',
  `desc` varchar(255) DEFAULT NULL COMMENT '默认商户模板',
  PRIMARY KEY (`id`),
  UNIQUE KEY `en_name` (`en_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='默认配置';
~~~
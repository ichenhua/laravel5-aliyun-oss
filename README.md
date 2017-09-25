Laravel5-Aliyun-Oss
---------

```
    ___     __    _                                    ____    _____   _____
   /   |   / /   (_)   __  __  __  __   ____          / __ \  / ___/  / ___/
  / /| |  / /   / /   / / / / / / / /  / __ \        / / / /  \__ \   \__ \
 / ___ | / /   / /   / /_/ / / /_/ /  / / / /       / /_/ /  ___/ /  ___/ /
/_/  |_|/_/   /_/    \__, /  \__,_/  /_/ /_/        \____/  /____/  /____/
                    /____/
```

Laravel5-Aliyun-Oss 是阿里云 OSS 官方 SDK 的 Composer 封装，支持 Laravel5 项目。


## 更新记录

* 2017-09-25 `Release v1.0.1` 文件后缀转小写，添加组件使用demo
* 2017-09-20 `Release v1.0.0` 引入aliyunOss2.0，封装根据 url 上传文件方法。

## 安装流程

1、安装的两种方式

① 直接编辑配置文件

将以下内容增加到 composer.json：

```json
require: {
    "chenhua/laravel5-aliyun-oss": "~1.0"
}
```

然后运行 `composer update`。

② 执行命令安装

运行命令：

```bash
composer require chenhua/laravel5-aliyun-oss
```

2、完成上面的操作后，修改 `config/app.php` 中 `providers` 数组

```php
Chenhua\AliyunOss\AliyunOssServiceProvider::class,
```

3、修改 `config/app.php` 中 `aliases` 数组

```php
'AliyunOss' => Chenhua\AliyunOss\Facades\AliyunOss::class,
```

4、执行 `artisan` 命令，生成 `config/aliyun.php` 配置文件

```bash
php artisan vendor:publish --tag=aliyun.oss
```

5、`.env` 添加配置项

```bash
#Aliyun配置
OSS_AK_ID=LTAIXRSmr9DtWAxxx
OSS_AK_SECRET=vkRN73GgWMhDkCZr5tNdjPutxxxxx
OSS_ENDPOINT=oss-cn-beijing.aliyuncs.com
```

## 使用

### 重新封装方法

外网 url 上传文件

```php
use AliyunOss;

#code
//自定义bucket
$bucket = '81f7-test';

//生成文件不带前缀
$file = AliyunOss::uploadFileByUrl('http://www.81f7.com/logo.png',$bucket);

//生成文件带 rc 前缀
$file = AliyunOss::uploadFileByUrl('http://www.81f7.com/logo.png',$bucket,'rc');
```

### 静态调用 Aliyun 自带方法

```php
use AliyunOss;

#code
//自定义bucket
$bucket = '81f7-test';
$file_name = 'logo.png';

//获取已有文件信息
$getFile = AliyunOss::getObjectMeta($bucket, $file_name);

//AliyunOss::getObjectMeta($bucket, $file_name);
//实际调用的是 `OSS/OssClient.php` 中的：
//public function getObjectMeta($bucket, $object, $options = NULL)

```

更多用法可以参考阿里云官方代码，[查看更多>>>](https://github.com/aliyun/aliyun-oss-php-sdk/blob/master/src/OSS/OssClient.php)。

## License
除 “版权所有（C）阿里云计算有限公司” 的代码文件外，遵循 [MIT license](http://opensource.org/licenses/MIT) 开源。



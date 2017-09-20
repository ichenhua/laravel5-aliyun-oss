<?php
namespace Chenhua\AliyunOss\Facades;

use Illuminate\Support\Facades\Facade;

class AliyunOss extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'aliyun-oss';
    }
}
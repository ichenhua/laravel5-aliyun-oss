<?php
namespace App\Component;

class OSS
{
    //通过url上传文件到阿里云
    public static function uploadFileByUrl($url)
    {
        $prefix = config('aliyun.oss.directory').'/'.config('aliyun.oss.prefix');
        return \AliyunOss::uploadFileByUrl($url,config('aliyun.oss.bucket'),$prefix);
    }

    //根据文件名获取私有访问路径
    public static function getPrivateUrl($file_name)
    {
        return \AliyunOss::signUrl(config('aliyun.oss.bucket'),$file_name, $timeout = 3600);
    }
}

<?php
namespace Chenhua\AliyunOss;

use OSS\OssClient;

class AliyunOss
{
    static protected $ossClient;
    static protected $config;

    public function __construct()
    {
        self::$config = config('aliyun.oss');
        if(!self::$config) throw new \Exception('config aliyun.oss exception.');
        //通过配置项初始化oss设置
        $accessKeyId = self::$config['ak_id'];
        $accessKeySecret = self::$config['ak_secret'];
        $endpoint = self::$config['end_point'];
        self::$ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
    }

    //从url地址上传图片
    public static function uploadFileByUrl($url, $bucket, $prefix='')
    {
        $file = file_get_contents($url);
        $file_name = self::createRandFileName($url,$prefix);
        if(self::fileIsExist($bucket, $file_name)){
            $file_name = self::createRandFileName($url,$prefix);
        }
        $result = self::$ossClient->putObject($bucket, $file_name, $file );

        return $result + [
            'bucket' => $bucket,
            'file_name' => $file_name
        ];
    }

    //检测文件是否已存在
    public static function fileIsExist( $bucket, $file_name )
    {
        return self::$ossClient->doesObjectExist( $bucket, $file_name);
    }

    //生成随机文件名
    private static function createRandFileName($url, $prefix='')
    {
        $file_name = date('Ymd-His').'-'.rand(100,900).'.'.pathinfo($url, PATHINFO_EXTENSION);
        if($prefix){
            $file_name = $prefix.$file_name;
        }
        return $file_name;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([self::$ossClient, $method], $args);
    }

}
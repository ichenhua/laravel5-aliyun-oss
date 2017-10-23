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
        $file = self::getContentByCurl($url);
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
        $ext = pathinfo(parse_url($url,PHP_URL_PATH),PATHINFO_EXTENSION);
        $file_name = date('Ymd-His').'-'.rand(100,900).'.'.strtolower($ext);
        if($prefix){
            $file_name = $prefix.$file_name;
        }
        return $file_name;
    }

    //curl方式获取文件内容
    private static function getContentByCurl($url,$isHttps=false){
        $header = array('Expect:');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        if($isHttps){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        }

        $ret = curl_exec($ch);

        if(curl_errno($ch)){
            \Log::error('Curl error: '.curl_error($ch));
        }

        curl_close ($ch);
        //$return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
        return $ret;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([self::$ossClient, $method], $args);
    }

}
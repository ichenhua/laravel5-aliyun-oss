<?php
namespace App\Http\Controllers;

class TestController extends Controller
{
    //上传图片到阿里云,并获取私有访问链接
    public function upload()
    {
        $url  = 'https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq/it/u=3571045740,327043274&fm=173&s=C0123C9B4AF07292CB2AFBF50300502B&w=364&h=241&img.JPG';
        $data = \App\Component\OSS::uploadFileByUrl($url);
        $pri_url =  \App\Component\OSS::getPrivateUrl($data['file_name']);
        dd($data,$pri_url);
    }



}
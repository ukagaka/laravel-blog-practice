<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\tencentyun\ImageV2;


class ApiController extends Controller
{

    public function loadImg(Request $request)
    {
        $file = $request->file('file');
        $filePrefix = 'post';
        $bucket = '2258guba';
        $name = $filePrefix . '/' . md5(rand(1, 1000) . $bucket . rand(1, 1000)).$file->extension();
        $uploadRet = ImageV2::upload($file->path(), $bucket, $name);
        if (0 === $uploadRet['code']) {
            return json_encode(array('code'=>200,'data'=>['url'=>$uploadRet['data']['downloadUrl']]));
        }
        return json_encode(array('code'=>400));
    }

}

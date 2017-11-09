<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传
    public function upload()
    {
        $file = Input::file('Filedata');
        if($file->isValid()){
            $realpath = $file->getRealPath();//上传文件的绝对路径
            $extension = $file->getClientOriginalExtension();//上传文件的后缀
            $newName = date('YmdHis').mt_rand(100,999).'.'.$extension;//自己定义的新文件名
            $path = $file->move(base_path().'/uploads',$newName);//将临时文件重新命名并移动到新路径
            $filepath = 'uploads/'.$newName;
            return $filepath;
        }
    }
}

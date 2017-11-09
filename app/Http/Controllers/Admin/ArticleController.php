<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleController extends CommonController
{
    //get.admin/article  全部文章列表
    public function index()
    {
        echo '全部文章分类';
    }


    //get.admin/article/create  添加文章
    public function create()
    {
        $data = (new Category)->tree();
        return view('admin.article.add')->with('data',$data);
    }
    //post.admin/category //提交文章分类
    public function store()
    {
        $input = Input::except('_token');
//        dd($input);
        $rules = [
            'cate_name'=>'required',
        ];
        $message = [
            'cate_name.required'=>'分类名称不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Category::create($input);
            if($re){
                return redirect('admin/category');
            }else{
                return back()->with('errors','增加分类失败，请稍后再试！');
            }
        }else{
//            dd($validator);
            return back()->withErrors($validator);
        }
    }
}

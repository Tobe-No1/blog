<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    //get.admin/category  全部分类列表
    public function index()
    {
        $categories = (new Category)->tree();
        return view('admin.category.index')->with('data',$categories);
    }

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($_POST['cate_id']);
        $cate->cate_order = $_POST['cate_order'];
        $re = $cate->update();
        if($re){
            $data = [
                'status'=>0,
                'msg'=>'分类排序更新成功!'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'分类排序更新失败,请稍后重试！'
            ];
        }
        return $data;
    }
    //get.admin/category/create  添加分类
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.add')->with('data',$data);
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
    //get.admin/category/{category}/edit  编辑单个分类
    public function edit($cate_id)
    {
        $cate = Category::find($cate_id);
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.edit',compact('data','cate'));
    }
    //put.admin/category/{category}  更新分类
    public function update($cate_id)
    {
        $input = Input::except('_token','_method');
//        dd($input);
        $re = Category::where('cate_id',$cate_id)->update($input);
        if($re){
            return redirect('admin/category');
        }else{
            return back()->with('errors','更新文章分类失败，请稍后重试！');
        }
//        dd($input);
    }
    //delete.admin/category/{category} 删除单个分类
    public function destroy($cate_id)
    {
        $re = Category::where('cate_id',$cate_id)->delete();
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
        if($re){
            $data = [
                'status'=> 0,
                'msg'=> '删除分类成功！'
            ];
        }else{
            $data = [
                'status'=> 1,
                'msg'=> '删除分类失败，请稍后重试！'
            ];
        }
        return $data;
    }
    //get.admin/category/{category}  显示单个分类
    public function show()
    {

    }
}

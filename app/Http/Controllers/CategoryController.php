<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        //
    }

    public function getAllCategories(Request $request){
        $classes=Category::orderBy('id','ASC')
            ->when($request->Category_name,function ($q) use ($request) {
            $q->where('Category_name','like','%'.$request->Category_name.'%');})
            ->with('category_news','category_news_one')->paginate(5);
        return response()->json($classes);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'Category_name' => 'required',
        ],[],[
            'Category_name' => 'اسم التصنيف',
        ]);
        if ($validated->fails()){
            $msg="تأكد من البيانات المدخلة";
            $data=$validated->errors();
            return response()->json(compact('msg','data'),422);
        }
        $category = new Category();
        $category->Category_name=$request->Category_name;
        $category->save();
        return response()->json(['msg'=>"تمت الاضافة بنجاح"]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(),[
            'Category_name' => 'required',
        ],[],[
            'Category_name' => 'اسم التصنيف',
        ]);
        if ($validated->fails()){
            $msg="تأكد من البيانات المدخلة";
            $data=$validated->errors();

            return response()->json(compact('msg','data'),422);
        }

        $category = Category::Find($id);
        $category->Category_name=$request->Category_name;
        $category->save();
        return response()->json(['msg'=>"تم التعديل بنجاح"]);
    }

    public function destroy($id)
    {
        $delete = Category::find($id);
        $delete->delete();
        return response()->json(['msg'=>"تم الحذف بنجاح"]);
    }
}

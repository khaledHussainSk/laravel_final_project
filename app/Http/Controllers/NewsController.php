<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{

    public function index()
    {
        $classes=News::get();
        return response()->json($classes);
    }

    public function create()
    {
        $news = News::get();
        return view('welcome',compact('news'));
    }

    public function getNews(Request $request){
        //desc تنازلي
        //asc تصاعدي
        //all لا تأ×ذ شروط
        //get تأخذ شروط
        $classes=News::orderBy('id','ASC')->when($request->Category,function ($q) use ($request) {
            $q->where('Category','like','%'.$request->Category.'%');
        })
            ->when($request->NewsDate,function ($q) use ($request) {
                $q->where('NewsDate','like','%'.$request->NewsDate.'%');
            })
            ->when($request->Description,function ($q) use ($request) {
                $q->where('Description','like','%'.$request->Description.'%');
            })->with('category_')->paginate(5);
        return response()->json($classes);
    }

    public function login(Request $request)
    {
        $user=User::where('email',$request->email)->first();
        if (!$user){
            return response()->json(['msg'=>"عذرا البريد الالكتروني غير صحيح"],401);
        }

        if (Hash::check($request->password, $user->password)){
            $token = $user->createToken('Laravel password Grant Client')->accessToken;
            $response = ['token' => $token];
            return response($response,200);
        }else{
            $response = ["message" => "عذرا كلمة المرور غير صحيحة"];
            return response($response,401);
        }
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'Category' => 'required',
            'Description' => 'required',
            'NewsDate' => 'required',
            'Image' => 'mimes:jpeg,jpg,png,gif',
        ],[],[
            'Category' => 'التصنيف',
            'Description' => 'تفاصيل الخبر',
            'NewsDate' => 'تاريخ الخبر',
            'Image' => 'صورة الخبر',
        ]);
        if ($validated->fails()){
            $msg="تأكد من البيانات المدخلة";
            $data=$validated->errors();

            return response()->json(compact('msg','data'),422);
        }
        $news = new News();
        $news->Description=$request->Description;
        $news->Category=$request->Category;
        $news->NewsDate=$request->NewsDate;

        if($request->hasFile('Image')){
            $file=$request->file('Image');
            $image_name=time().'.'.$file->getClientOriginalExtension();
            $path='images'.'/'.$image_name;
            $file->move(public_path('images'),$image_name);
            $news->Image=$path;
        }
        $news->save();
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
            'Category' => 'required|max:30',
            'Description' => 'required',
            'NewsDate' => 'required',
            'Image' => 'required',
        ],[],[
            'Category' => 'التصنيف',
            'Description' => 'تفاصيل الخبر',
            'NewsDate' => 'تاريخ الخبر',
            'Image' => 'صورة الخبر',
        ]);
        if ($validated->fails()){
            $msg="تأكد من البيانات المدخلة";
            $data=$validated->errors();

            return response()->json(compact('msg','data'),422);
        }

        $news = News::Find($id);
        $news->Description=$request->Description;
        $news->Category=$request->Category;
        $news->NewsDate=$request->NewsDate;
        if($request->hasFile('Image')){
            $file=$request->file('Image');
            $image_name=time().'.'.$file->getClientOriginalExtension();
            $path='images'.'/'.$image_name;
            $file->move(public_path('images'),$image_name);
            $news->Image=$path;
        }
        $news->save();
        return response()->json(['msg'=>"تم التعديل بنجاح"]);
    }

    public function destroy($id)
    {
        $delete = News::find($id);
        $delete->delete();
        return response()->json(['msg'=>"تم الحذف بنجاح"]);
    }
}

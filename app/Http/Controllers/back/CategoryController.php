<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\Article;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index()
    {
        $categories=category::all();
        return view('back.categories.index',compact('categories'));
    }
    public function switch(Request $request)
    {
        $category=category::findOrFail($request->id);
        $category->status=$request->statu=="true" ? 1 : 0 ;
        $category->save();
    }

    public function create(Request $request)
    {
        //dd($request->post());
        $isExist=category::where('slug',Str::slug($request->category))->first();
        if ($isExist)
        {
            toastr()->error($request->category.' adında bir kategori zaten mevcut.');
            return redirect()->back();
        }
        $category=new category();
        $category->name=$request->category;
        $category->slug=Str::slug($request->category);
        $category->save();
        toastr()->success('Kategori başarıyla oluşturuldu');
        return redirect()->back();
    }

    public function getData(Request $request)
    {
        $category=category::findOrFail($request->id);
        return response()->json($category);
    }

    public function update(Request $request)
    {
        $isSlug=category::where('slug',Str::slug($request->category))->whereNotIn('id',[$request->id])->first();
        $isName=category::where('name',$request->category)->whereNotIn('id',[$request->id])->first();
        if ($isSlug or $isName)
        {
            toastr()->error($request->category.' adında bir kategori zaten mevcut.');
            return redirect()->back();
        }
        $category=category::findOrFail($request->id);
        $category->name=$request->category;
        $category->slug=Str::slug($request->slug);
        $category->save();
        toastr()->success('Kategori başarıyla güncellendi');
        return redirect()->back();
    }
    public function delete(Request $request)
    {
        $category = category::findOrFail($request->id);
        if ($category->id ==9)
        {
            toastr()->error('Bu kategori silinemez');
            return redirect()->back();
        }
        $count=$category->articleCount();
        $defaultcategory=category::findOrFail(9);
        $mesaj="";
        if ($count>0)
        {
            Article::where('catagoryID',$category->id)->update(['catagoryID'=>9]);
            $mesaj='Bu kategoriye ait '.$count.' makale '.$defaultcategory->name.' kategorisine taşındı.';
        }
        $category->delete();
        toastr()->success($mesaj,'Kategori başarıyla silindi');
        return redirect()->back();

    }
}

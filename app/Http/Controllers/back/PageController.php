<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages=Page::all();
        return view('back.pages.index',compact('pages'));
    }

    public function switch(Request $request)
    {
        $page=Page::findOrFail($request->id);
        $page->status=$request->statu=="true" ? 1 : 0 ;
        $page->save();
    }

    public function create()
    {
        return view('back.pages.create');
    }
    public function post(Request $request)
    {
         $request->validate([
            'title'=>'min:3',
            'image'=>'required|image|mimes:jpeg,png,jpg,max:2048'
         ]);

         $last=Page::orderBy('order','desc')->first();

         $page=new Page;
         $page->title=$request->title;
         $page->content=$request->conten;
         $page->slug=Str::slug($request->title);
         $page->order=$last->order+1;
         if ($request->hasFile('image'))
         {
             $imgname=Str::slug($request->name).'.'.$request->image->getClientOriginalExtension();
             $request->image->move(public_path('uploads'),$imgname);
             $page->img='uploads/'.$imgname;
         }
         $page->save();
         toastr()->success('Sayfa barıyla oluşturuldu','Başarılı');
         return redirect()->route('admin.page.index');
    }

    public function update($id)
    {
        $page=Page::findOrFail($id);
        return view('back.pages.update',compact('page'));
    }

    public function updatePost(Request $request,$id)
    {
        $request->validate([
            'title'=>'min:3',
            'image'=>'image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $page=Page::findOrFail($id);
        $page->title=$request->title;
        $page->content=$request->conten;
        $page->slug=Str::slug($request->title);

        if ($request->hasFile('image'))
        {
            $imgname=Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imgname);
            $page->img='uploads/'.$imgname;
        }
        $page->save();
        toastr()->success('Sayfa barıyla güncellendi','Başarılı');
        return redirect()->route('admin.page.index');

    }

    public function delete($id)
    {
        $page=Page::findOrFail($id);
        if (File::exists($page->img))
        {
            File::delete(public_path($page->img));
        }
        $page->forceDelete();
        toastr()->success('Sayfa barıyla silindi','Başarılı');
        return redirect()->route('admin.page.index');
    }

    public function orders(Request $request)
    {
        foreach ($request->get('page') as $key => $order)
        {
            
            $page=Page::findOrFail($order);
            $page->order=$key;
            $page->save();
        }
    }
}

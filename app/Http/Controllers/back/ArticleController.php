<?php

namespace App\Http\Controllers\back;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\category;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $articles = Article::orderBy('created_at','ASC')->get();
        return view('back.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cateries=category::all();
        return view('back.articles.create',compact('cateries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'min:3',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $article=new Article;
        $article->title=$request->title;
        $article->catagoryID=$request->category;
        $article->content=$request->conten;
        $article->slug=Str::slug($request->title);

        if($request->hasFile('image'))
        {

            $imageName=Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $article->image='uploads/'.$imageName;
        }
        $article->save();
        toastr()->success('Başarılı', 'Makale başırıyla oluşturuldu');
        return redirect()->route('admin.makaleler.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return  $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article=Article::findOrFail($id);
        $cateries=category::all();
        return view('back.articles.update',compact('cateries','article'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'min:3',
            'image'=>'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $article=Article::findOrFail($id);
        $article->title=$request->title;
        $article->catagoryID=$request->category;
        $article->content=$request->conten;
        $article->slug=Str::slug($request->title);

        if($request->hasFile('image'))
        {
            $imageName=Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $article->image='uploads/'.$imageName;
        }
        $article->save();
        toastr()->success('Başarılı', 'Makale başırıyla güncellendi');
        return redirect()->route('admin.makaleler.index');
    }

    public function switch(Request $request)
    {

        $article=Article::findOrFail($request->id);
        $article->status=$request->statu=="true" ? 1 : 0 ;
        $article->save();
        return $request->id;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Article::findOrFail($id)->delete();
        toastr()->success('Makale, Silinen makalelere taşındı.');
        return redirect()->route('admin.makaleler.index');
    }
    public  function trashed()
    {
        $articles=Article::onlyTrashed()->orderBy('deleted_at','desc')->get();
        return view('back.articles.trashed',compact('articles'));
    }
    public function recover($id)
    {
        //Article::onlyTrashed()->find($id)->restore(); Bu fa olur
        $article=Article::onlyTrashed()->find($id);
        $article->deleted_at=null;
        $article->status=0;
        $article->save();
        toastr()->success('Makale başarıyla kurtarıldı');
        return redirect()->back();
    }
    public function harddelete($id)
    {
        $article=Article::onlyTrashed()->findOrFail($id);
        if(File::exists($article->image))
        {
            File::delete($article->image);
        }
        $article->forceDelete();
        toastr()->success('Makale başarıyla silindi');
        return redirect()->back();
    }
    public function destroy($id)
    {
        return $id;
    }
}

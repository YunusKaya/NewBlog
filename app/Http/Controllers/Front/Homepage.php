<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\Article;
use App\Models\Page;
use Illuminate\Support\Facades\Mail;

class Homepage extends Controller
{
    public  function __construct()
    {
        view()->share('pages',Page::orderBy('order','ASC')->get());
        view()->share('catagories',category::get());
    }
    public function index()
    {
        $data['articles']=Article::orderBy('created_at','DESC')->paginate(2) ?? abort(403,'Hata index');
        return view('front.homepage',$data);
    }

    public function single($category,$slug)
    {
        //Article::where('slug',$slug)->increment('hit');
        $cata=category::where('slug',$category)->first() ?? abort(403,'Hata single first');
        $artc = Article::where('slug',$slug)->where('catagoryID',$cata->id)->first() ?? abort(403,'Hata single');
        $artc->increment('hit');
        $data['articles']= $artc;

        return view('front.single',$data);
    }

    public function categories ($categorySlug)
    {
        $cata=category::where('slug',$categorySlug)->first() ?? abort(404);
        $data['catagory']=$cata;
        $data['articles']=Article::where('catagoryID',$cata->id)->orderBy('created_at','DESC')->paginate(1);
        return view('front.category',$data);
    }
    public function page($slug)
    {
       $page=Page::where('slug',$slug)->first() ?? abort('403','Böyle bir sayfa yok');
       $data['page']=$page;
       return view('front.page',$data);
    }
    public function contact()
    {
        return view('front.iletisim');
    }

    public function contactPost(Request $request)
    {
        $rules=[
            'name'=>'required|min:5',
            'email'=>'required|email',
            'topic'=>'required',
            'message'=>'required|min:10',
        ];

        $validate=Validator::make($request->post(),$rules);
        if ($validate->fails())
        {
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }
        Mail::send
        ([],[],
            function ($message) use ($request)
            {
            $message->from('iletisim@blogsitesi.com','Blog Sitesi');
            $message->to('iletisim@blogsitesi.com');
            $message->setBody(' Mesajı göndere: '.$request->name.'<br/>
                                Mesajı Gönderen Mail: '.$request->email.'<br/>
                                Mesaj Konusu: '.$request->topic.'<br/>
                                Mesaj: '.$request->message.'<br/> <br/>
                                Tarih:'.date('d.m.Y H:i:s'),'text/html');
            $message->subject($request->name.' iletişimden mesaj gönderdi');

            }
        );

        return redirect()->route('contact')->with('success','Mesajımız bize iletildi. Teşekkürler');


    }
}

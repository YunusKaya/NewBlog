<?php

use Illuminate\Support\Facades\Route;

/*
|---------------------------------------------------
| Back Routes
|---------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function () {
    Route::get('giris', 'back\AuthController@login')->name('login');
    Route::post('giris', 'back\AuthController@loginPost')->name('loginPost');
});
Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function ()
{
    Route::get('panel', 'back\Dashboard@index')->name('dashboard');
    //Makale rout
    Route::get('makaleler/silinenler','back\ArticleController@trashed')->name('trashed.article');
    Route::resource('makaleler','back\ArticleController');
    Route::get('switch','back\ArticleController@switch')->name('switch');
    Route::get('deletearticle/{id}','back\ArticleController@delete')->name('delete.article');
    Route::get('recoverarticle/{id}','back\ArticleController@recover')->name('recover.article');
    Route::get('harddeletearticle/{id}','back\ArticleController@harddelete')->name('harddelete.article');
    //Kategori rout
    Route::get('kategoriler','back\CategoryController@index')->name('category.index');
    Route::get('kategori/status','back\CategoryController@switch')->name('category.switch');
    Route::post('kategori/create','back\CategoryController@create')->name('category.create');
    Route::post('kategori/update','back\CategoryController@update')->name('category.update');
    Route::post('kategori/delete','back\CategoryController@delete')->name('category.delete');
    Route::get('kategori/getData','back\CategoryController@getData')->name('category.getData');
    //Page Rout

    Route::get('sayfalar','back\PageController@index')->name('page.index');
    Route::get('sayfalar/olustur','back\PageController@create')->name('page.create');
    Route::get('sayfalar/guncelle/{id}','back\PageController@update')->name('page.edit');
    Route::post('sayfalar/guncelle/{id}','back\PageController@updatePost')->name('page.edit.post');
    Route::post('sayfalar/olustur','back\PageController@post')->name('page.create.post');
    Route::get('sayfa/switch','back\PageController@switch')->name('page.switch');
    Route::get('sayfa/sil/{id}', 'back\PageController@delete')->name('page.delete');
    Route::get('sayfa/sıralama', 'back\PageController@orders')->name('page.orders');
    //
    Route::get('cikis', 'back\AuthController@logout')->name('logout');
});

/*
|---------------------------------------------------
| Front Routes
|---------------------------------------------------
*/

Route::get('/', 'Front\Homepage@index')->name('homepage');
Route::get('/kategori/{categorySlug}','Front\Homepage@categories')->name('categories');
Route::get('/{catagory}/{slug}','Front\Homepage@single')->name('single');
Route::get('/iletisim','Front\Homepage@contact')->name('contact');
Route::post(('iletisim/post'),'Front\Homepage@contactPost')->name('contact.post');
Route::get('/{sayfa}','Front\Homepage@page')->name('page');



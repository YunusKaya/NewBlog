@extends('front.layouts.master')
@section('title',$page->title)
@section('bg-img',$page->img)
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-8">
                <p>{!!$page->content!!}</p>
            </div>
        </div>
    </div>

@endsection



@extends('front.layouts.master')
@section('title',$articles->getCatagory->name)
@section('bg-img',$articles->image)
@section('content')
    <!-- Main Content -->

    <article>
        <div class="container">
            <div class="row">
                <div class="col-md-9 mx-auto">
                    <h2>{{$articles->title}}</h2>
                    <img src="{{$articles->image}}" style="width:70%"/>
                    <p>{!!$articles->content!!}</p>
                    <br>
                    <p class="post-meta">
                        <span class="float-left">
                            Katagori: {{$articles->getCatagory->name}} <br>
                            Okunma Sayısı: {{$articles->hit}}
                        </span>
                        <span class="float-right">
                            {{$articles->created_at->diffForHumans()}}

                        </span>
                    </p>
                </div>
                @include('front.layouts.categoryWidget')
            </div>
        </div>
    </article>

@endsection

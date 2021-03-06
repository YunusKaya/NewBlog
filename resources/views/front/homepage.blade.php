

@extends('front.layouts.master')
@section('title','Anasayfa')
@section('content')
<!-- Main Content -->

<div class="container">
    <div class="row">
        <div class="col-md-9 mx-auto">
            @foreach($articles as $artical)
                <div class="post-preview">
                    <a href="{{route('single',[$artical->getCatagory->slug,$artical->slug])}}">
                        <h2 class="post-title">
                            {{$artical->title}}
                        </h2>
                        <img src="{{$artical->image}}" style="width:100%"/>
                        <h3 class="post-subtitle">
                            {!! Str::limit($artical->content,75) !!}
                        </h3>
                    </a>
                    <p class="post-meta">
                        <a href="#">
                            Katagori: {{$artical->getCatagory->name}} -- {{$artical->catagoryID}}
                        </a>
                        <span class="float-right">
                            {{$artical->created_at->diffForHumans()}}

                        </span>
                    </p>
                </div>
                <hr>
            @endforeach
            {{$articles->links()}}
        </div>

        @include('front.layouts.categoryWidget')
    </div>
</div>
@endsection

@extends('back.layouts.master')
@section('title','Silinene Makaleler')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left"><strong>{{$articles->count()}} makale bulundu</strong></h6>
            <a href="{{route('admin.makaleler.index')}}" class="btn btn-primary btn-sm float-right"><i class="fab fa-creative-commons-sampling-plus"></i> Aktif Makaleler</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Fotoğraf</th>
                            <th>Makale Başlığı</th>
                            <th>Katagori</th>
                            <th>Hit</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                            <tr>
                                <td>
                                    <img src="{{asset($article->image)}}" width="180">
                                </td>
                                <td>{{$article->title}}</td>
                                <td>{{$article->getCatagory->name}}</td>
                                <td>{{$article->hit}}</td>
                                <td>{{$article->created_at->diffForHumans()}}</td>
                                <td>
                                    <a href="{{route('admin.recover.article',$article->id)}}" title="Geri Yükle" class="btn btn-sm btn-primary mt-1"><i class="fas fa-redo-alt"></i> </a>
                                    <a href="{{route('admin.harddelete.article',$article->id)}}" title="Sil" class="btn btn-sm btn-danger mt-1"><i class="fa fa-times"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@extends('back.layouts.master')
@section('title','Tüm Sayfalar')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left"><strong>{{count($pages)}} Sayfa Bulundu</strong></h6>
        </div>
        <div class="card-body">
            <div id="OrderSucces" style="display: none;" class="alert alert-success">
                Sıralama başarıyla güncellendi.
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Görsel</th>
                            <th>Sayfa Başlığı</th>
                            <th>Durum</th></th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody id="orders">
                        @foreach($pages as $page)
                            <tr id="page_{{$page->id}}">
                                <td style="width: 5px; " class="text-center">
                                    <i class="fas fa-arrows-alt-v handle fa-2x" style="cursor: move"></i>
                                </td>
                                <td>
                                    <img src="{{asset($page->img)}}" width="180">
                                </td>
                                <td>{{$page->title}}</td>
                                <td>
                                    <input class="switch" page-id="{{$page->id}}" type="checkbox" data-on="Aktif" data-onstyle="success" data-off="Pasif" data-offstyle="danger"  @if($page->status==1) checked @endif data-toggle="toggle">
                                </td>
                                <td>
                                    <a href="{{route('page',$page->slug)}}" target="_blank" title="Görüntüle" class="btn btn-sm btn-success mt-1"><i class="fa fa-eye"></i> </a>
                                    <a href="{{route('admin.page.edit',$page->id)}}" title="Düzenle" class="btn btn-sm btn-primary mt-1"><i class="fa fa-edit"></i> </a>
                                    <a href="{{route('admin.page.delete',$page->id)}}" title="Sil" class="btn btn-sm btn-danger mt-1"><i class="fa fa-times"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('cs')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

    <script>
        $('#orders').sortable({
            handle:'.handle',
            update:function ()
            {
               var siralama = $('#orders').sortable('serialize');
               $.get("{{route('admin.page.orders')}}?"+siralama,function (data,status){
                   $('#OrderSucces').show().delay(1000).fadeOut();
               });
            }
        });
    </script>

    <script>
        $(function ()
        {
            $('.switch').change(function ()
            {
                id=$(this)[0].getAttribute('page-id');
                statu=$(this).prop('checked');
                $.get("{{route('admin.page.switch')}}", {id:id,statu:statu},function (data,status){});
            })
        })
    </script>
@endsection

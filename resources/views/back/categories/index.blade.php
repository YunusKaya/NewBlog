@extends('back.layouts.master')
@section('title','Tüm Kategoriler')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Yeni Kategori Oluştur</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.category.create')}}">
                        @csrf
                        <div class="form-group">
                            <label>Kategori Adı</label>
                            <input type="text" class="form-control" name="category" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary float-right">Ekle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Kategori Adı</th>
                                <th>Makale Sayısı</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->articleCount()}}</td>
                                    <td>
                                        <input class="switch" category-id="{{$category->id}}" type="checkbox" data-on="Aktif" data-onstyle="success" data-off="Pasif" data-offstyle="danger"  @if($category->status==1) checked @endif data-toggle="toggle">
                                    </td>
                                    <td>
                                        <a title="Düzenle" category-id="{{$category->id}}" class="edit-click btn btn-sm btn-primary text-white"><i class="fa fa-edit"></i></a>
                                        <a title="Sil" category-id="{{$category->id}}" category-count="{{$category->articleCount()}}" category-name="{{$category->name}}" class="remove-click btn btn-sm btn-danger text-white"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Düzenle</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="{{route('admin.category.update')}}">
                <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>Kategori Adı</label>
                            <input id="category" type="text" class="form-control" name="category">
                            <input type="hidden" name="id" id="category_id">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input id="slug" type="text" class="form-control" name="slug">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-success">Kaydet</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Makaleyi Sil</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div id="body" class="modal-body">
                    <div id="articleAlert" class="alert alert-danger"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <form method="post" action="{{route('admin.category.delete')}}">
                        @csrf
                        <input type="hidden" name="id" id="deleteId">
                        <button id="deletebutton" type="submit" class="btn btn-success">Sil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('cs')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(function ()
        {
            $('.remove-click').click(function (){
                id=$(this)[0].getAttribute('category-id');
                count=$(this)[0].getAttribute('category-count');;
                cname=$(this)[0].getAttribute('category-name');
                $('#body').hide();
                if (id==9)
                {
                    $('#deletebutton').hide();
                    $('#body').show();
                    $('#articleAlert').html(cname+' kategorisi silinemez. Varsayılan kategoridir.');
                    $('#deleteModal').modal();
                    return ;
                }
                $('#deleteId').val(id);
                $('#articleAlert').html('');
                if (count>0)
                {
                    $('#deletebutton').show();
                    $('#body').show();
                    $('#articleAlert').html('Bu kategoriye ait '+count+' adet makale bulundu.Silmek istediğinize emin misiniz?');
                }
                $('#deleteModal').modal();
            })


            $('.edit-click').click(function (){
                id=$(this)[0].getAttribute('category-id');
                $.ajax({
                    type:'GET',
                    url:'{{route('admin.category.getData')}}',
                    data:{id:id},
                    success:function (data)
                    {
                        console.log(data);
                        $('#category').val(data.name);
                        $('#slug').val(data.slug);
                        $('#category_id').val(data.id);
                        $('#editModal').modal();
                    }
                })
            })


            $('.switch').change(function ()
            {
                id=$(this)[0].getAttribute('category-id');
                statu=$(this).prop('checked');
                $.get("{{route('admin.category.switch')}}", {id:id,statu:statu},function (data,status){});
            })
        })
    </script>
@endsection

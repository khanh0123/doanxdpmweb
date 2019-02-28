@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', 'Chi tiết quốc gia')
@section('main')
<div class="container-fluid">
    <div class="alert alert-light" role="alert">
        <strong class="">Chi tiết quốc gia</strong>
    </div>
    <form action="" method="post">
        {{ csrf_field()}}
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header card-header-text" data-background-color="rose">
                                <h4 class="card-title">Chi tiết</h4>
                            </div>

                            <div class="card-content form-horizontal">
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Tên danh mục</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name="name" value="{{ $data['info']['name'] }}" required="required">
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Slug</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name="slug" value="{{ $data['info']['slug'] }}" required>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Tiêu đề seo</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name="seo_title" value="{{ $data['info']['seo_title'] }}" >
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Mô tả seo</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name="seo_des" value="{{ $data['info']['seo_des'] }}" >
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col-8 -->
            <div class="col-md-3">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header card-header-text" data-background-color="rose">
                                <h4 class="card-title">Hành động</h4>
                            </div>
                            <div class="card-content">

                                @if (session()->get('permission')->canUpdate)
                                <button type="submit" class="btn btn-info using-tooltip" data-toggle="tooltip" data-placement="top" title="Xác Nhận Thay Đổi"><i class="material-icons">check</i>Xác Nhận<div class="ripple-container"></div></button>
                                @endif

                                <a class="btn using-tooltip" href="{{base_url('admin/country')}}" data-toggle="tooltip" data-placement="top" title="Hủy bỏ thao tác">Hủy bỏ<div class="ripple-container"></div></a>

                                @if (session()->get('permission')->canDelete)
                                <a class="btn btn-danger using-tooltip" href="{{base_url('admin/country/del/'.$data['info']['id'])}}" data-toggle="tooltip" data-placement="top" title="Xóa phần tử này?"><i class="material-icons">close</i>Xóa<div class="ripple-container"></div></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </form>
        <!-- end form -->

    </div>
    @stop

    @section('css')
    <!-- add custom css here -->
    @stop

    @section('js')
    <!--  DataTables.net Plugin    -->
<!-- <script src="/assets/js/jquery.datatables.js"></script>
--><script type="text/javascript">
    $(document).ready(function() {
        $('.using-tooltip').tooltip({animation:true});
        $('.menu-left-custom >li.active').removeClass('active');
        $('#catcotgen').parent('li').addClass('active');
        $('#catcotgen').collapse();

        $('input[name="name"]').on('keyup', function(event) {
            event.preventDefault();
            $('input[name="slug"]').val(create_slug($(this).val()));
        });

    });
</script>
@stop
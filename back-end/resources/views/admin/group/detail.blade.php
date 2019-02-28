@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', 'Chi tiết nhóm')
@section('main')
<div class="container-fluid">
    <div class="alert alert-light" role="alert">
        <strong class="">Chi tiết nhóm</strong>
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
                                    <label class="col-sm-2 label-on-left">Tên nhóm *</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name="name" value="{{ $data['info']->name }}" required="required">
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Chọn nhóm quyền</label>
                                    <div class="col-sm-5">
                                        <select data-container="body" class="selectpicker" data-live-search="true" data-size="10" data-style="btn-info" name="per_id" required>
                                            @foreach($data['more'] as $key => $value)
                                            <option data-tokens="{{$value->name}}" value="{{$value->id}}" {{$value->id == $data['info']->per_id ? 'selected' : ''}}>{{$value->name}}</option>
                                            @endforeach
                                        </select>

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

                                <a class="btn using-tooltip" href="{{base_url('admin/group')}}" data-toggle="tooltip" data-placement="top" title="Hủy bỏ thao tác">Hủy bỏ<div class="ripple-container"></div></a>

                                @if (session()->get('permission')->canDelete)

                                <a class="btn btn-danger using-tooltip" href="{{base_url('admin/group/del/'.$data['info']->id)}}" data-toggle="tooltip" data-placement="top" title="Xóa phần tử này?"><i class="material-icons">close</i>Xóa<div class="ripple-container"></div></a>

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
    <!-- Select Plugin -->
<script src="/assets/js/jquery.select-bootstrap.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.using-tooltip').tooltip({animation:true});
        $('.menu-left-custom >li.active').removeClass('active');
        $('#group').parent('li').addClass('active');
        $('#group').collapse();

    });
</script>
@stop
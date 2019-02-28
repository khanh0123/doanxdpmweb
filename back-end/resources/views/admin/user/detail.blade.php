@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', 'Chi tiết thông tin Admin')
@section('main')
<div class="container-fluid">
    <div class="alert alert-light" role="alert">
        <strong class="">Chi tiết thông tin Admin</strong>
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
                                    <label class="col-sm-2 label-on-left">Họ <small>*</small></label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name="first_name" value="{{ $data['info']['first_name'] }}" required>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Tên <small>*</small></label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name="last_name" value="{{ $data['info']['last_name'] }}" required>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Email <small>*</small></label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="email" class="form-control" name="email" required value="{{ $data['info']['email'] }}" >
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Mật Khẩu <small>*</small></label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="password" class="form-control" name="password" value="******" required disabled>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Trạng thái </label>
                                    <div class="col-sm-10">
                                        <label class="text-success label-on-left" style="color: {{$data['info']['status'] === 1 ? '#4caf50' : 'red'}} ">{{$data['info']['status'] !== 1 ? 'Vô hiệu hóa' : 'Kích hoạt'}}</label>
                                            
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Chọn nhóm *</label>
                                    <div class="col-sm-5">
                                        <select data-container="body" class="selectpicker" data-live-search="true" data-size="10" data-style="btn-info" name="gad_id" required>
                                            @foreach($data['more'] as $key => $value)
                                            <option data-tokens="{{$value->name}}" value="{{$value->id}}" {{$value->id == $data['info']->gad_id ? 'selected' : ''}}>{{$value->name}}</option>
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
                                
                                <button type="submit" class="btn btn-info using-tooltip" data-toggle="tooltip" data-placement="top" title="Xác Nhận Thay Đổi"><i class="material-icons">check</i>Xác Nhận<div class="ripple-container"></div></button>

                                <a class="btn using-tooltip" href="{{base_url('admin/user')}}" data-toggle="tooltip" data-placement="top" title="Hủy bỏ thao tác">Hủy bỏ<div class="ripple-container"></div></a>
                                
                                @if ($data['info']['status'] === 1)
                                <a class="btn btn-danger using-tooltip" href="{{base_url('admin/user/lock/'.$data['info']['id'])}}" data-toggle="tooltip" data-placement="top" title="Khóa user này?"><i class="material-icons">lock</i>Khóa<div class="ripple-container"></div></a>
                                @else
                                <a class="btn btn-success using-tooltip" href="{{base_url('admin/user/unlock/'.$data['info']['id'])}}" data-toggle="tooltip" data-placement="top" title="Mở khóa user này?"><i class="material-icons">lock_open</i>Mở Khóa<div class="ripple-container"></div></a>
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
        $('#groupAdmin').parent('li').addClass('active');
        $('#groupAdmin').collapse();

    });
</script>
@stop
@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', 'Chi tiết danh mục')
@section('main')
<div class="container-fluid">
    <div class="alert alert-light" role="alert">
        <strong class="">Chi tiết danh mục</strong>
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
                                    <label class="col-sm-2 label-on-left">Tên menu <small>*</small></label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name="name" value="{{$data['info']->name}}" required>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <label class="col-sm-2 label-on-left">Slug</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name="slug" value="{{$data['info']->slug}}" >
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Chọn menu</label>
                                    <div class="col-sm-10">
                                        <select data-container="body" class="selectpicker" data-live-search="true" data-size="10"  data-style="btn-success" name="tag_id" >
                                            @foreach($data['more'] as $key => $value)
                                            <?php 
                                                $seleted = in_array($value->id,$data['info']->sub_menu) ? true : false;
                                             ?>
                                            <option data-tokens="{{$value->name}}" value="{{$value->id}}" {{$seleted ? 'selected' : ''}}>{{$value->name}}</option>
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
                              

                                <a class="btn using-tooltip" href="{{url('admin/menu')}}" data-toggle="tooltip" data-placement="top" title="Hủy bỏ thao tác">Hủy bỏ<div class="ripple-container"></div></a>

                               

                                <a class="btn btn-danger using-tooltip" href="{{url('admin/menu/del/'.$data['info']['id'])}}" data-toggle="tooltip" data-placement="top" title="Xóa phần tử này?"><i class="material-icons">close</i>Xóa<div class="ripple-container"></div></a>
                              
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
        $('#menu').parent('li').addClass('active');
        $('#menu').collapse();

        // $('input[name="name"]').on('keyup', function(event) {
        //     event.preventDefault();
        //     $('input[name="slug"]').val(create_slug($(this).val()));
        // });

        $('select[name="tag_id"]').on('change', function(event) {
            event.preventDefault();
            $('input[name="name"]').val($(this).val());
        });  
    });
</script>
@stop
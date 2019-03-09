@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', 'Thêm tin mới')
@section('main')
<div class="container-fluid">
    <div class="alert alert-light" role="alert">
        <strong class="">Thêm tin mới</strong>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        {{ csrf_field()}}
        <div class="row">

            <div class="col-sm-9">
                <!--      Wizard container        -->
                <div class="wizard-container">
                    <div class="card wizard-card" data-color="green" id="wizardProfile">
                        <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="wizard-header">
                            <h3 class="wizard-title">
                                Thêm thông tin bản tin
                            </h3>
                        </div>
                        <div class="wizard-navigation">
                            <ul>
                                <li class="wizard-menu-top">
                                    <a href="/admin/posts#info" data-toggle="tab">Thông tin bản tin</a>
                                </li>
                                <li class="wizard-menu-top">
                                    <a href="/admin/posts#more" data-toggle="tab">Ảnh và loại</a>
                                </li>
                                <li class="wizard-menu-top">
                                    <a href="/admin/posts#seoinfo" data-toggle="tab">Thông tin SEO</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane" id="info">
                                <div class="card-content form-horizontal">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <label class="col-sm-4 label-on-left">Tên bản tin <small style="color:red">*</small></label>
                                                <div class="col-sm-8">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" class="form-control" name="name" value="" required data-name="Tên phim">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-4 label-on-left">Slug</label>
                                                <div class="col-sm-8">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" class="form-control" name="slug" value="">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                            </div>                                            

                                        </div>
                                        <!-- end col 6 -->
                                        <div class="col-sm-6">
                                            <!-- <div class="row">
                                                <label class="col-sm-4 label-on-left">Số tập <small style="color:red">*</small></label>
                                                <div class="col-sm-2">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="number" class="form-control" name="epi_num" value="1" required data-name="Số tập">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="row">
                                                <label class="col-sm-4 label-on-left">Tiêu đề<small style="color:red">*</small></label>
                                                <div class="col-sm-2">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" class="form-control" name="title" value="" required data-name="Thời gian">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-4 label-on-left">Ngày đăng <small></small></label>
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <input type="date" class="form-control" value="{{date('Y-m-d')}}" name="release_date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <label class="col-sm-4 label-on-left">Nội dung<small style="color:red">*</small></label>
                                                <div class="col-sm-2">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" class="form-control" name="content" value="" required data-name="Thời gian">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="more">
                                <div class="card-content form-horizontal">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <!-- <div class="row">
                                                <label class="col-sm-3 label-on-left">Chọn mục</label>
                                                <div class="form-group label-floating is-empty">
                                                    <div class="col-sm-3">
                                                        <div class="togglebutton">
                                                            <label>
                                                                <input type="checkbox" name="is_hot" value="0"> Phim Hot
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="togglebutton">
                                                            <label>
                                                                <input type="checkbox" name="is_new" value="0"> Phim Mới
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="togglebutton">
                                                            <label>
                                                                <input type="checkbox" name="is_banner" value="0"> Banner
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- end row -->
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">Chọn tags</label>
                                                <div class="col-sm-5">
                                                    <select data-container="body" class="selectpicker" data-live-search="true" data-size="10" data-style="btn-info"  multiple name="tag_id[]" required data-name="Tags">
                                                        @foreach($data['more']['tags'] as $key => $value)
                                                        <option data-tokens="{{$value->name}}" value="{{$value->id}}">{{$value->name}}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <!-- end row -->
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="/assets/img/image_placeholder.jpg" alt="Ảnh xem trước">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-rose btn-round btn-file">
                                                        <span class="fileinput-new">Chọn ảnh</span>
                                                        <span class="fileinput-exists">Thay đổi</span>
                                                        <input type="file" name="image" required data-name="Ảnh">
                                                        <div class="ripple-container"></div>
                                                    </span>
                                                    <a href="extended.html#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane" id="seoinfo">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="info-text"> Nhập thông tin SEO cho phim </h4>
                                    </div>
                                    <div class="col-sm-11 col-sm-offset-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Mô tả ngắn</label>
                                            <input name="short_des" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-11 col-sm-offset-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Mô tả đầy đủ</label>
                                            <input name="long_des" type="text" class="form-control">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- wizard container -->
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

                                <button type="submit" class="btn btn-info using-tooltip" data-toggle="tooltip" data-placement="top" title="Xác Nhận Thêm" onClick="return validateMovie();"><i class="material-icons">check</i>Xác Nhận<div class="ripple-container"></div></button>

                                <button type="reset" class="btn btn-danger using-tooltip"  data-toggle="tooltip" data-placement="top" title="Làm mới form này"><i class="material-icons">close</i>Làm mới<div class="ripple-container"></div></button>
                            </div>
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
<!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css"> -->
@stop

@section('js')

<!--  Plugin for the Wizard -->
<script src="/assets/js/jquery.bootstrap-wizard.js"></script>
<!-- Select Plugin -->
<script src="/assets/js/jquery.select-bootstrap.js"></script>
<!--    Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="/assets/js/jasny-bootstrap.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.using-tooltip').tooltip({animation:true});
        $('.menu-left-custom >li.active').removeClass('active');
        $('#posts').parent('li').addClass('active');
        $('#posts .add').addClass('active');
        $('#posts').collapse();

        $('input[name="name"]').on('keyup', function(event) {
            event.preventDefault();
            $('input[name="slug"]').val(create_slug($(this).val()));
        });

        // $('input[name="is_hot"],input[name="is_new"],input[name="is_banner"]').on('change', function(event) {
        //     event.preventDefault();
        //     if($(this).is(':checked')){
        //         $(this).val(1);
        //     } else {
        //         $(this).val(0);
        //     }
        // });
        // demo.initMaterialWizard();


    });
    function validateMovie(){
        var input = $('#wizardProfile input[required]');
        var select = $('#wizardProfile select[required]');
        for(var k = 0; k < input.length; k++){
            if($(input[k]).val() == ''){
                var name = $(input[k]).data('name');
                showNotification('warning' , `${name} không được để trống` , 3000);
                return false;
            }
        }
        for(var k = 0; k < select.length; k++){
            if($(select[k]).val() == ''){
                var name = $(select[k]).data('name');
                showNotification('warning' , `${name} không được để trống` , 3000);
                return false;
            }
        }
        return true;
    }
</script>
@stop
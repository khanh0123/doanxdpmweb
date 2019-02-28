@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', 'Chi tiết phim')
@section('main')
<div class="container-fluid">
    <div class="alert alert-light" role="alert">
        <strong class="">Chi tiết phim</strong>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-9">
                <!--      Wizard container        -->
                <div class="wizard-container">
                    <div class="card wizard-card" data-color="green" id="wizardProfile">
                        <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="wizard-header">
                            <h3 class="wizard-title">
                                Thông tin phim
                            </h3>
                        </div>
                        <div class="wizard-navigation">
                            <ul>
                                <li class="wizard-menu-top">
                                    <a href="/admin/movie/detail/{{$data['info']->id}}#info" data-toggle="tab">Thông tin phim</a>
                                </li>
                                <li class="wizard-menu-top">
                                    <a href="/admin/movie/detail/{{$data['info']->id}}#more" data-toggle="tab">Thể loại</a>
                                </li>
                                <li class="wizard-menu-top">
                                    <a href="/admin/movie/detail/{{$data['info']->id}}#images" data-toggle="tab">Hình ảnh</a>
                                </li>

                                <li class="wizard-menu-top">
                                    <a href="/admin/movie/detail/{{$data['info']->id}}#seoinfo" data-toggle="tab">Thông tin SEO</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane" id="info">
                                <div class="card-content form-horizontal">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <label class="col-sm-4 label-on-left">Tên phim <small style="color:red">*</small></label>
                                                <div class="col-sm-8">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" class="form-control" name="name" value="{{ $data['info']->name }}" required data-name="Tên phim">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-4 label-on-left">Slug</label>
                                                <div class="col-sm-8">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" class="form-control" name="slug" value="{{ $data['info']->slug }}">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- end col 6 -->
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <label class="col-sm-4 label-on-left">Số tập <small style="color:red">*</small></label>
                                                <div class="col-sm-2">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="number" class="form-control" name="epi_num" value="{{ $data['info']->epi_num }}" required data-name="Số tập">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-4 label-on-left">Thời gian (phút )<small style="color:red">*</small></label>
                                                <div class="col-sm-2">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="number" class="form-control" name="runtime" value="{{ $data['info']->runtime }}" required data-name="Thời gian">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-4 label-on-left">Ngày phát hành <small></small></label>
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                            <input type="date" class="form-control" value="{{ customDate($data['info']->release_date , 'Y-m-d') }}" name="release_date">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end info -->
                            <div class="tab-pane" id="more">
                                <div class="card-content form-horizontal">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">Chọn mục</label>
                                                <div class="form-group label-floating is-empty">
                                                    <div class="col-sm-3">
                                                        <div class="togglebutton">
                                                            <label>
                                                                <input type="checkbox" name="is_hot" value="{{ $data['info']->is_hot ? 1 : 0 }}" {{ $data['info']->is_hot ? 'checked' : '' }}> Phim Hot
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="togglebutton">
                                                            <label>
                                                                <input type="checkbox" name="is_new" value="{{ $data['info']->is_new ? 1 : 0 }}" {{ $data['info']->is_new ? 'checked' : '' }}> Phim Mới
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="togglebutton">
                                                            <label>
                                                                <input type="checkbox" name="is_banner" value="{{ $data['info']->is_banner ? 1 : 0 }}" {{ $data['info']->is_banner ? 'checked' : '' }}> Banner
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end row -->
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">Chọn danh mục</label>
                                                <div class="col-sm-5  my-container">
                                                    <select data-container="body" class="selectpicker" data-live-search="true" data-size="10" data-style="btn-info" name="cat_id" required data-name="Danh mục">
                                                        @foreach($data['more']['category'] as $key => $value)
                                                        <option data-tokens="{{$value->name}}" value="{{$value->id}}" {{ $value->id == $data['info']->cat_id ? 'selected' : '' }} >{{$value->name}}
                                                        </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <!-- end row -->
                                            <div class="row ">
                                                <label class="col-sm-3 label-on-left">Chọn thể loại</label>
                                                <div class="col-sm-5  my-container">
                                                    <select data-container="body" class="selectpicker" data-live-search="true" data-size="10" multiple data-style="btn-danger" name="genre[]" required data-name="Thể loại">
                                                        @foreach($data['more']['genre'] as $key => $value)
                                                        <option data-tokens="{{$value->name}}" value="{{$value->id}}" {{ 
                                                            in_array(
                                                            [
                                                            'mov_id' => $data['info']->id,
                                                            'gen_id' => $value->id
                                                            ] , $data['info']->genre ) ? 'selected' : '' }} >{{$value->name}}
                                                        </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <!-- end row -->
                                            <div class="row">
                                                <label class="col-sm-3 label-on-left">Chọn quốc gia</label>
                                                <div class="col-sm-5 my-container">
                                                    <select data-container="body" class="selectpicker" data-live-search="true" data-size="10" multiple data-style="btn-secondary" name="country[]" required data-name="Quốc gia">
                                                        @foreach($data['more']['country'] as $key => $value)
                                                        <option data-tokens="{{$value->name}}" value="{{$value->id}}" {{ 
                                                            in_array(
                                                            [
                                                            'mov_id' => $data['info']->id,
                                                            'cou_id' => $value->id
                                                            ] , $data['info']->country ) ? 'selected' : '' }} > {{$value->name}} 
                                                        </option>

                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end more -->
                            <div class="tab-pane" id="images">
                                <div class="col-md-4 col-sm-4 div-image-old">
                                    <input type="hidden" value="{{ $data['info']->images->thumbnail->id }}" name="listidimages_old[]">
                                    <div class="fileinput text-center fileinput-exists" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="/assets/img/image_placeholder.jpg" alt="Ảnh xem trước">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style=""><img src="{{ !empty($data['info']->images->thumbnail->url) ? $data['info']->images->thumbnail->url : $data['info']->images->thumbnail->path }}"></div>
                                        <div>
                                            <a href="#" class="btn btn-danger btn-round fileinput-exists btn-delete-image" data-dismiss="fileinput">
                                                <i class="fa fa-times"></i> Xóa ảnh này
                                                <div class="ripple-container">
                                                    <div class="ripple ripple-on ripple-out" style="left: 62.75px; top: 17.4px; background-color: rgb(255, 255, 255); transform: scale(15.5484);">

                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="/assets/img/image_placeholder.jpg" alt="Ảnh xem trước">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Chọn ảnh mới </span>
                                                <span class="fileinput-exists">Thay đổi</span>
                                                <input type="file" name="image" data-name="Ảnh">
                                                <div class="ripple-container"></div>
                                            </span>
                                            <a href="extended.html#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
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
                                            <input name="short_des" type="text" class="form-control" value="{!! $data['info']->short_des !!}">
                                        </div>
                                    </div>
                                    <div class="col-sm-11 col-sm-offset-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Mô tả đầy đủ</label>
                                            <input name="long_des"  type="text" class="form-control" value="{!! $data['info']->long_des !!}">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- wizard container -->
            </div>
            <!-- end col-9 -->
            <div class="col-md-3">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header card-header-text" data-background-color="rose">
                                <h4 class="card-title">Hành động</h4>
                            </div>
                            <div class="card-content">                               

                                @if (session()->get('permission')->canUpdate)
                                <button type="submit" class="btn btn-info using-tooltip" data-toggle="tooltip" data-placement="top" title="Xác Nhận Thay Đổi" onClick="return validateMovie();"><i class="material-icons">check</i>Xác Nhận<div class="ripple-container"></div></button>
                                @endif

                                <a class="btn using-tooltip" href="{{base_url('admin/movie')}}" data-toggle="tooltip" data-placement="top" title="Hủy bỏ thao tác">Hủy bỏ<div class="ripple-container"></div></a>

                                @if (session()->get('permission')->canDelete)

                                <a class="btn btn-danger using-tooltip" href="{{ base_url('admin/movie/del/'.$data['info']->id) }}" data-toggle="tooltip" data-placement="top" title="Xóa phim này?"><i class="material-icons">close</i>Xóa<div class="ripple-container"></div></a>
                                @endif

                                @if (session()->get('permission')->canWrite)

                                    <a href="{{ base_url("admin/movie/".$data['info']->id."/episode/add")}}" class="btn btn-success using-tooltip" data-toggle="tooltip" data-placement="top" title="Thêm tập phim"><i class="material-icons">playlist_add</i>Thêm tập<div class="ripple-container"></div></a>
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
            $('#movie').parent('li').addClass('active');
            $('#movie').collapse();

            $('input[name="name"]').on('keyup', function(event) {
                event.preventDefault();
                $('input[name="slug"]').val(create_slug($(this).val()));
            });
            demo.initMaterialWizard();

            

            
            $('body .btn-delete-image').on('click', function(event) {
                event.preventDefault();
                $(this).parents('.div-image-old').remove();
            });

            $('input[name="is_hot"],input[name="is_new"],input[name="is_banner"]').on('change', function(event) {
                event.preventDefault();
                if($(this).is(':checked')){
                    $(this).val(1);
                } else {
                    $(this).val(0);
                }
            });


        });
        function validateMovie(){
            var input = $('#wizardProfile input[required]');
            var select = $('#wizardProfile select[required]');
            for(var k = 0; k < input.length; k++){
                if($(input[k]).val() == ''){
                    var name = $(input[k]).data('name');
                    showNotification('warning' , `${name} không được để trống` , 3000);
                    console.log($(input[k]));
                    return false;
                }
            }
            for(var k = 0; k < select.length; k++){
                if($(select[k]).val() == ''){
                    var name = $(select[k]).data('name');
                    showNotification('warning' , `${name} không được để trống` , 3000);
                    console.log($(select[k]));
                    return false;
                }
            }
            return true;
        }

    </script>
    @stop
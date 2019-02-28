@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', 'Chi tiết banner')
@section('main')
<div class="container-fluid">
    <div class="alert alert-light" role="alert">
        <strong class="">Chi tiết banner {{ $dataMovie->name }}</strong>
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
                                Chi tiết tập phim
                            </h3>
                        </div>
                        <div class="wizard-navigation">
                            <ul>
                                <li class="wizard-menu-top">
                                    <a href="/admin/movie#info" data-toggle="tab">Thông tin tập</a>
                                </li>
                                <li class="wizard-menu-top">
                                    <a href="/admin/movie#images" data-toggle="tab">Quản Lý Ảnh</a>
                                </li>

                                <li class="wizard-menu-top">
                                    <a href="/admin/movie#links" data-toggle="tab">Quản Lý Nguồn Video</a>
                                </li>
                                <li class="wizard-menu-top">
                                    <a href="/admin/movie#seoinfo" data-toggle="tab">Thông tin SEO</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane" id="info">
                                <div class="card-content form-horizontal">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="row">
                                                <label class="col-sm-4 label-on-left">Tiêu đề <small style="color:red">*</small></label>
                                                <div class="col-sm-8">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" class="form-control" name="title" value="{{ $data->title }}" required data-name="Tiêu đề tập">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <label class="col-sm-4 label-on-left">Chọn tập  <small style="color:red">*</small></label>
                                                <div class="col-sm-8">
                                                    <select data-container="body" class="selectpicker" data-live-search="true" data-size="10" data-style="btn-info" name="episode" required data-name="Tập phim">
                                                        @for($i = 1 ; $i <= $dataMovie->epi_num; $i++)
                                                        @if($i === $data->episode || !in_array($i , $dataEpisodesCreated))
                                                        <option data-tokens="{{$i}}" value="{{$i}}" {{ $i === $data->episode ? 'selected' : '' }}>Tập {{$i}}</option>
                                                        @endif
                                                        @endfor
                                                    </select>

                                                </div>
                                            </div>
                                            

                                        </div>
                                        <!-- end col 6 -->
                                        

                                    </div>
                                </div>
                            </div>
                            <!-- end info -->
                            <div class="tab-pane" id="images">
                                @foreach($data->images as $value)
                                <div class="col-md-4 col-sm-4 div-image-old">
                                    <input type="hidden" value="{{ $value->id }}" name="listidimages_old[]">
                                    <div class="fileinput text-center fileinput-exists" data-provides="fileinput">
<!--                                         <div class="fileinput-new thumbnail">
                                            <img src="/assets/img/image_placeholder.jpg" alt="Ảnh xem trước">
                                        </div> -->
                                        <div class="fileinput-preview fileinput-exists thumbnail" style=""><img src="{{ $value->path }}"></div>
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
                                @endforeach
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
                                                <input type="file" name="images[]" multiple data-name="Ảnh">
                                                <div class="ripple-container"></div>
                                            </span>
                                            <a href="extended.html#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="links">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title">Danh sách link</h4>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Nguồn</th>
                                                        <th>Link</th>
                                                        <th>Chất lượng</th>
                                                        <th>Phương thức phát</th>
                                                        <th class="text-right">Xóa</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($data->link_play as $value)
                                                    <tr>
                                                        <input type="hidden" name="link_play_old[]" value="{{ $value->id }}" />
                                                        <td class="text-center">#</td>
                                                        <td>{{ $value->from ? $value->from : '' }}</td>
                                                        <td>{{ $value->source ? $value->source : '' }}</td>
                                                        <td>{{ $value->qualify ? $value->qualify : 'Chưa rõ' }}</td>
                                                        <td>{{ $value->method == 'live' ? 'Trực tiếp' : 'Graph Api' }}</td>
                                                        <td class="td-actions text-right">
                                                            <button type="button" rel="tooltip" class="btn btn-danger" data-original-title="" title="" onClick="return removeLink(this);">
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->

                                <button class="btn btn-info btn-raised btn-round" data-toggle="modal" data-target="#modalAddLink" onClick="return false;">
                                    <span class="btn-label">
                                        <i class="material-icons">check</i>
                                    </span>
                                    Tạo Link
                                    <div class="ripple-container"></div>
                                </button>
                            </div>
                            <!-- end links -->
                            <div class="tab-pane" id="seoinfo">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="info-text"> Nhập thông tin SEO cho phim </h4>
                                    </div>
                                    <div class="col-sm-11 col-sm-offset-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Mô tả ngắn</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-11 col-sm-offset-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Slug</label>
                                            <input type="text" class="form-control" name="slug" value="{{ $data->slug }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-11 col-sm-offset-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Mô tả đầy đủ</label>
                                            <input type="text" class="form-control">
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
                                @if(session()->get('permission')->canUpdate)
                                    <button type="submit" class="btn btn-info using-tooltip" data-toggle="tooltip" data-placement="top" title="Xác nhận thay đổi" onClick="return validateEpisode();"><i class="material-icons">check</i>Xác nhận<div class="ripple-container"></div></button>
                                @endif

                                @if(session()->get('permission')->canUpdate)
                                    <a href="{{ base_url("admin/movie/$dataMovie->id/episode/del/$data->id") }}" class="btn btn-danger using-tooltip" data-toggle="tooltip" data-placement="top" title="Xóa tập này"><i class="material-icons">close</i>Xóa<div class="ripple-container"></div></a>
                                @endif
                                <button type="reset" class="btn btn-default using-tooltip"  data-toggle="tooltip" data-placement="top" title="Làm mới form này"><i class="material-icons">close</i>Làm mới<div class="ripple-container"></div></button>

                                <a href="{{ base_url("admin/movie/$dataMovie->id/episode") }}" class="btn btn-success using-tooltip" data-toggle="tooltip" data-placement="top" title="Quản Lý Tập Phim"><i class="material-icons">playlist_add</i>Quản Lý Tập<div class="ripple-container"></div></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </form>
        <!-- end form -->
        <div class="modal fade" id="modalAddLink" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title">Thêm link mới</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-sm-3">Link phát</label>
                            <div class="col-sm-8">
                                <div class="form-group label-floating is-empty" style="margin: 0 0 20px 0">
                                    <label class="control-label"></label>
                                    <input type="text" class="form-control" name="link_source">
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 label-on-left">Nguồn</label>
                            <div class="col-sm-8">
                                <select data-container="body" class="selectpicker" data-size="5" data-style="btn-info" name="link_from">
                                    <option data-tokens="facebook" value="facebook">Facebook</option>
                                    <option data-tokens="google" value="google">Google</option>
                                    <option data-tokens="others" value="others" selected>Khác</option>
                                </select>

                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 label-on-left">Chất Lượng</label>
                            <div class="col-sm-8">
                                <select data-container="body" class="selectpicker" data-size="5" data-style="btn-info" name="link_quality">
                                    <option data-tokens="360" value="360">360P</option>
                                    <option data-tokens="480" value="480">480P</option>
                                    <option data-tokens="720" value="720">720P</option>
                                    <option data-tokens="1080" value="1080">1080P</option>
                                    <option data-tokens="0" value="0" selected>Chưa rõ</option>
                                </select>

                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 label-on-left">Phương thức phát</label>
                            <div class="col-sm-8">
                                <select data-container="body" class="selectpicker" data-size="5" data-style="btn-info" name="link_method">
                                    <option data-tokens="live" value="live" selected>Trực tiếp</option>
                                    <option data-tokens="graph" value="graph">Sử dụng graph API facebook</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">                            
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Hủy bỏ</button>
                        <button type="button" class="btn btn-success" onClick="return addLinkEpisode()">Xác nhận</button>                        
                    </div>
                </div>
            </div>
        </div>
        <!--  End Modal -->

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
            $('#movie').parent('li').addClass('active');
            // $('#movie .add').addClass('active');
            $('#movie').collapse();

            $('input[name="title"]').on('keyup', function(event) {
                event.preventDefault();
                $('input[name="slug"]').val(create_slug($(this).val()));
            });
            demo.initMaterialWizard();

            
        });
        function validateEpisode(){
            var input = $('input[required]');
            var select = $('select[required]');
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
        function addLinkEpisode(){
            var link_source = $('input[name="link_source"]').val();
            var link_from = $('select[name="link_from"]').val();
            var link_quality = $('select[name="link_quality"]').val();
            var link_method = $('select[name="link_method"]').val();
            var reg_link = /http(s)?:\/\/([\w\W]+).([a-zA-Z0-9])$/;
            if(link_source == 'facebook'){
                reg_link = /http(s)?:\/\/([\w\W]+)$)/;
            }
            if(!link_source || !reg_link.test(link_source)){
                showNotification('warning' , `Link không hợp lệ` , 3000);
                return false;
            }

            if(!link_from){
                showNotification('warning' , `Hãy chọn nguồn phát` , 3000);
                return false;
            }

            if(!link_quality){
                showNotification('warning' , `Hãy chọn chất lượng video` , 3000);
                return false;
            }

            if(!link_method || (link_method !== 'live' && link_method !== 'graph')){
                showNotification('warning' , `Hãy chọn phương thức phát` , 3000);
                return false;
            }

            var link_play = JSON.stringify({
                source:link_source,
                from:link_from,
                qualify:parseInt(link_quality),
                method:link_method
            });
            var tr = '<tr>' + 
            `<input type="hidden" name="link_play[]" value='`+link_play+`' />` +
            '<td class="text-center">#</td>' +
            '<td>'+ link_from +'</td>' +
            '<td>'+ link_source +'</td>' +
            '<td>'+ parseInt(link_quality) +'</td>' +
            '<td>'+ link_method +'</td>' +
            '<td class="td-actions text-right">' +
            '<button type="button" rel="tooltip" class="btn btn-danger" data-original-title="" title="" onClick="return removeLink(this);">' +
            '<i class="material-icons">close</i>' +
            '</button>' +
            '</td>' +
            '</tr>';

            $('#links table tbody').append(tr);

            return false;

        }

        function removeLink(el){
            $(el).parents('tr').remove();
        }
    </script>
    @stop
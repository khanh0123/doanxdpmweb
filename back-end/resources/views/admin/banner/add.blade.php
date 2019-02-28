@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', 'Thêm banner mới')
@section('main')
<div class="container-fluid">
    <div class="alert alert-light" role="alert">
        <strong class="">Thêm banner mới</strong>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">

            <div class="col-sm-9">

                <div class="form-group label-floating is-empty">
                    <label class="control-label">Nhập tên phim cần thêm vào banner
                        <star>*</star>
                    </label>
                    <input class="form-control" name="mov_name" type="text">
                    <span class="material-input"></span>
                </div>
                <div class="bootstrap-tagsinput" id="resultMovie">
                    <!-- <span class="tag label label-info">Amsterdam<span data-role="remove"></span></span> --> 
                    <!-- <input type="text" placeholder=""> -->
                </div>
                <input type="hidden" name="mov_id" required data-name="Phim">
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

                                <button type="submit" class="btn btn-info using-tooltip" data-toggle="tooltip" data-placement="top" title="Xác Nhận Thêm" onClick="return validateBanner();"><i class="material-icons">check</i>Xác Nhận<div class="ripple-container"></div></button>

                                <button type="reset" class="btn btn-danger using-tooltip"  data-toggle="tooltip" data-placement="top" title="Làm mới form này"><i class="material-icons">close</i>Làm mới<div class="ripple-container"></div></button>                               
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
            $('#banner').parent('li').addClass('active');
            $('#banner .add').addClass('active');
            $('#banner').collapse();

            var xhr,requestTimeout;
            $('input[name="mov_name"]').on('keyup', function(event) {
                // event.preventDefault();
                var mov_name = $(this).val();
                if(requestTimeout){
                    clearTimeout(requestTimeout);
                    if(xhr){
                        xhr.abort();
                    }
                }
                requestTimeout = setTimeout(function(){
                    xhr = $.ajax({
                        url: '/admin/movie/search',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {mov_name: mov_name,_token:$('input[name="_token"').val()},
                    })
                    .done(function(res) {
                        if(res.success){
                            var html = `<span class="tag label label-info">${res.data.name}<span data-role="remove" onClick="remove(this)"></span></span>`;
                            $('#resultMovie').html(html);
                            $('input[name="mov_id"]').val(res.data.id);
                        }
                    })
                    .fail(function() {
                        console.log("error");
                    })
                    .always(function() {
                        console.log("complete");
                    });
                },500);
                
            });


        });
        function validateEpisode(){
            var input = $('input[required]');
            for(var k = 0; k < input.length; k++){
                if($(input[k]).val() == ''){
                    var name = $(input[k]).data('name');
                    showNotification('warning' , `${name} không được để trống` , 3000);
                    return false;
                }
            }
            return true;
        }       

        function remove(el){
            $(el).parent().remove();
            $('input[name="mov_id"]').val('');
        }
    </script>
    @stop
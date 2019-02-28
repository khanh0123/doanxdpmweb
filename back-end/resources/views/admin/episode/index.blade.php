@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', "Danh sách tập của phim ".$data['movie']->name)
@section('main')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="purple">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Danh sách tập của phim {{ $data['movie']->name }} </h4>
                    <div class="toolbar">
                        <!-- Here you can write extra buttons/actions for the toolbar   -->
                        @if(session()->get('permission')->canWrite)
                            <a href="{{ base_url("admin/movie/".$data['movie']->id."/episode/add")}}" class="btn btn-success btn-round">
                                <span class="btn-label">
                                    <i class="material-icons">check</i>
                                </span>
                                Thêm tập mới
                                <div class="ripple-container"></div>
                            </a>
                            <button class="btn btn-info btn-raised btn-round" data-toggle="modal" data-target="#modalCloneEpisode" onClick="return false;">
                                <span class="btn-label">
                                    <i class="material-icons">check</i>
                                </span>
                                Sao chép nhiều tập phim
                                <div class="ripple-container"></div>
                            </button>
                        @endif
                        

                    </div>
                    @if(!empty($data['info']))
                    <form class="form-inline" method="GET" action="">
                        <!-- <div class="row"> -->
                            <div class="col-sm-12">
                                <div style="margin: 5px;width: 13%;display: inline-block">
                                    <span>Hiển thị</span>
                                    <select class="selectpicker col-4" data-style="btn btn-primary btn-round"  data-size="7" name="limit">
                                        <option value="10" {{ @$data['filter']['limit'] == 10 ? 'selected' : ''}}>10</option>
                                        <option value="20" {{ @$data['filter']['limit'] == 20 ? 'selected' : ''}}>20</option>
                                        <option value="30" {{ @$data['filter']['limit'] == 30 ? 'selected' : ''}}>30</option>
                                        <option value="40" {{ @$data['filter']['limit'] == 40 ? 'selected' : ''}}>40</option>
                                        <option value="80" {{ @$data['filter']['limit'] == 80 ? 'selected' : ''}}>80</option>
                                    </select>
                                    <!-- <span>Kết quả</span> -->
                                </div>
                                <div class="my-container" style="margin: 5px;width: 30%;display: inline-block">
                                    <span>Sắp xếp</span>
                                    <select class="selectpicker col-4" data-style="btn btn-primary btn-round"  data-size="7" style="width: 20% !important" name="sort">                                
                                        <option value="desc" {{ @$data['filter']['sort'] == 'desc' ? 'selected' : ''}}>Giảm dần</option>
                                        <option value="asc" {{ @$data['filter']['sort'] == 'asc' ? 'selected' : ''}}>Tăng dần</option>                     
                                    </select>
                                    <span>theo</span>
                                        <select class="selectpicker col-4" data-style="btn btn-primary btn-round"  data-size="7" style="width: 20% !important" name="orderBy">                                
                                        <option value="id" {{ @$data['filter']['orderBy'] == 'id' ? 'selected' : ''}}>ID</option>
                                        <option value="title" {{ @$data['filter']['orderBy'] == 'title' ? 'selected' : ''}}>Tiêu đề</option>
                                        <option value="episode" {{ @$data['filter']['orderBy'] == 'episode' ? 'selected' : ''}}>Tập</option>
                                        
                                        <option value="created_at" {{ @$data['filter']['orderBy'] == 'created_at' ? 'selected' : ''}}>Thời gian tạo</option>
                                        <option value="updated_at" {{ @$data['filter']['orderBy'] == 'updated_at' ? 'selected' : ''}}>Thời gian cập nhật</option>                     
                                    </select>
                                </div>
                                <div style="margin: 5px;width: 30%;display: inline-block">
                                    <span>Từ khóa tìm kiếm </span>
                                    <div class="form-group" style="margin: 0;padding-left: 10px">
                                        <input type="text" class="form-control" value="{{ @$data['filter']['title'] }}" name="title">

                                    </div>
                                </div>
                                <button class="btn btn-success btn-round" type="submit">Lọc<div class="ripple-container"></div></button>
                            </div>

                            
                        </div>
                    </form>
                    @endif
                    
                    <div class="material-datatables">
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tập</th>
                                    <th>Tiêu đề</th>
                                    <th>Slug</th>
                                    <th>Ngày tạo</th>
                                    <th>Lần cập nhật cuối</th>
                                    
                                    <th class="text-right">Hành động</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Tập</th>
                                    <th>Tiêu đề</th>
                                    <th>Slug</th>
                                    <th>Ngày tạo</th>
                                    <th>Lần cập nhật cuối</th>
                                    <th class="text-right">Hành động</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($data['info'] as $value)
                                <tr>
                                    <td>{{ $value->episode }}</td>
                                    <td>{{ $value->title }}</td>
                                    <td>{{ $value->slug }}</td>
                                    <td>{{ customDate($value->created_at , 'daytime') }}</td>
                                    <td>{{ customDate($value->updated_at , 'daytime') }}</td>
                                    <td class="text-right">
                                        <a href="{{base_url("admin/movie/".$data['movie']->id."/episode/detail/$value->id") }}" class="btn btn-simple btn-warning btn-icon edit">Chi tiết</a>
                                        @if (session()->get('permission')->canDelete)
                                            <a href="{{base_url("admin/movie/".$data['movie']->id."/episode/del/$value->id") }}" class="btn btn-simple btn-danger btn-icon remove">Xóa</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                        @if( $data['info']->hasPages() )
                        <div class="row">
                            @if($data['info']->count() > 0)
                            <div class="col-sm-5">
                                <div class="dataTables_info" role="status" aria-live="polite">
                                    Hiển thị {{ $data['info']->count() == 0 ? '0 kết quả' : ( 'từ '.  (($data['info']->currentPage()-1)*$data['info']->perPage() + 1 ).' tới '. (($data['info']->currentPage()-1)*$data['info']->perPage() + $data['info']->count()) .' trong tổng số '. ($data['info']->total() .' kết quả') ) }}
                                </div>
                            </div>
                            @endif
                            
                            <div class="col-sm-7">
                                <div class="dataTables_paginate" style="text-align: right">
                                    <ul class="pagination" style="margin: 0">
                                        <li class="paginate_button previous {{ $data['info']->currentPage() <= 1 ? 'disabled' : ''}} " >
                                            <a href="{{ $data['info']->previousPageUrl() }}" aria-controls="datatables" data-dt-idx="0" tabindex="0">Trước</a>
                                        </li>
                                        <?php 
                                        $begin = ($data['info']->currentPage() - 5) < 1 ? 1 : $data['info']->currentPage() - 5;
                                        $end = ($data['info']->currentPage() + 5) > $data['info']->lastPage() ? $data['info']->lastPage() : $data['info']->currentPage() + 5;

                                        ?>
                                        @for($i = $begin ; $i <= $end ; $i++)
                                        <li class="paginate_button {{ $data['info']->currentPage() == $i ? 'active' : '' }}">
                                            <a href="{{ $data['info']->url($i) }}" aria-controls="datatables" data-dt-idx="1" tabindex="0">{{$i}}</a>
                                        </li>
                                        @endfor
                                        <li class="paginate_button next {{ $data['info']->currentPage() >= $data['info']->lastPage() ? 'disabled' : ''}}">
                                            <a href="{{ $data['info']->nextPageUrl() }}" aria-controls="datatables" data-dt-idx="2" tabindex="0">Sau</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                        <!-- end row -->
                        @endif
                    </div>
                    
                </div>
                <!-- end content-->
            </div>
            <!--  end card  -->
        </div>
        <!-- end col-md-12 -->
    </div>
    <!-- end row -->
    
    <div class="modal fade" id="modalCloneEpisode" tabindex="-1" role="dialog" aria-labelledby="modalCloneEpisodeLabel" aria-hidden="true">
        <form action="{{base_url("admin/movie/".$data['movie']->id."/episode/clone")}}" method="POST">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title">Tạo tập hàng loạt</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-sm-4 label-on-left">Cách tạo</label>
                            <div class="col-sm-8">
                                <select data-container="body" class="selectpicker" data-size="5" data-style="btn-info" name="how_creating">
                                    <option data-tokens="default" value="default">Tạo đầy đủ tập</option>
                                    <option data-tokens="options" value="options">Chọn tập</option>
                                </select>

                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 label-on-left">Chọn tập để sao chép</label>
                            <div class="col-sm-8">
                                <select data-container="body" class="selectpicker" data-size="10" data-style="btn-info" name="from">
                                    @foreach($data['more'] as $value)
                                    <option data-tokens="{{ $value }}" value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="row epis_needed  hidden">
                            <label class="col-sm-4 label-on-left">Chọn tập cần sao chép</label>
                            <div class="col-sm-8">
                                <select data-container="body" class="selectpicker" data-size="5" data-style="btn-info" multiple>

                                    @for($i = 1 ; $i <= $data['movie']->epi_num ; $i++)
                                    @if(!in_array($i,$data['more']))
                                    <option data-tokens="{{ $i }}" value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                    @endfor
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">                            
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Hủy bỏ</button>
                        <button type="submit" class="btn btn-success">Xác nhận</button>                        
                    </div>
                </div>

            </div>
        </form>
        <!-- end form -->
    </div>
    <!--  End Modal -->
    
</div>
@stop

@section('css')
<!-- add custom css here -->
@stop

@section('js')
<!--  DataTables.net Plugin    -->
<script src="/assets/js/jquery.datatables.js"></script>
<!-- Select Plugin -->
<script src="/assets/js/jquery.select-bootstrap.js"></script>
<!--    Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script type="text/javascript">
    $(document).ready(function() {

        $('.menu-left-custom >li.active').removeClass('active');
        $('#movie').parent('li').addClass('active');
        // $('#genre .show').addClass('active');
        $('#movie').collapse();

        $('#datatables').DataTable({
            paging: false,
            // pagingType: "full_numbers",
            ordering:  false,
            "bInfo" : false,
            // "lengthMenu": [
            // [10, 25, 50, -1],
            // [10, 25, 50, "All"]
            // ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Tìm kiếm",
                paginate:
                {
                    previous: "Trước",
                    next: "Sau",
                    first: "",
                    last: ""
                },
                emptyTable: "Không có dữ liệu nào"
            },
            page:{

            }

        });


        $('select[name="how_creating"]').on('change', function(event) {
           event.preventDefault();
           if($(this).val() == 'default'){
            $('.epis_needed').addClass('hidden');
            $('.epis_needed').find('select').removeAttr('name');
        } else if($(this).val() == 'options') {
            $('.epis_needed').removeClass('hidden');
            $('.epis_needed').find('select').attr('name', 'needs');;
        }
    });

        $('.card .material-datatables label').addClass('form-group');
    });
</script>
@stop
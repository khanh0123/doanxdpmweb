@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', 'Danh sách danh mục')
@section('main')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="purple">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Danh sách danh mục</h4>
                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    @if(!empty($data['info']))
                    <div class="row">
                        <div class="col-sm-6">
                                <span>Hiển thị</span>
                                <div class="dropdown custom-group" style="display: inline-block">
                                    <button href="#pablo" class="dropdown-toggle btn btn-primary btn-round " data-toggle="dropdown">{{ $data['info']->perPage()}}
                                        <b class="caret"></b>
                                        <div class="ripple-container"></div>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-left">
                                        <li class="dropdown-header"></li>
                                        <li><a href="{{url('admin/tags?limit=10')}}">10</a></li>
                                        <li><a href="{{url('admin/tags?limit=20')}}">20</a></li>
                                        <li><a href="{{url('admin/tags?limit=30')}}">30</a></li>
                                        <li><a href="{{url('admin/tags?limit=40')}}">40</a></li>
                                    </ul>
                                </div>
                                <span>Kết quả</span>

                        </div>
                    </div>
                    @endif
                    <div class="material-datatables">
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tên tags</th>
                                    <th>Slug</th>
                                    <th class="text-right">Hành động</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Tên tags</th>
                                    <th>Slug</th>
                                    <th class="text-right">Hành động</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($data['info'] as $value)
                                <tr>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->slug }}</td>
                                    <td class="text-right">
                                        <a href="{{url('admin/tags/detail/'.$value->id) }}" class="btn btn-simple btn-warning btn-icon edit">Chi tiết</a>
                                        <a href="{{url('admin/tags/del/'.$value->id) }}" class="btn btn-simple btn-danger btn-icon remove">Xóa</a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                        
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" role="status" aria-live="polite">
                                    Hiển thị {{ $data['info']->count() == 0 ? '0 kết quả' : ( 'từ '.  (($data['info']->currentPage()-1)*$data['info']->perPage() + 1 ).' tới '. (($data['info']->currentPage()-1)*$data['info']->perPage() + $data['info']->count()) .' trong tổng số '. ($data['info']->total() .' kết quả') ) }}
                                </div>
                            </div>
                            @if( $data['info']->hasPages() )
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
                            @endif
                        </div>
                        <!-- end row -->
                        
                    </div>
                    
                </div>
                <!-- end content-->
            </div>
            <!--  end card  -->
        </div>
        <!-- end col-md-12 -->
    </div>
    <!-- end row -->
</div>
@stop

@section('css')
<!-- add custom css here -->
@stop

@section('js')
<!--  DataTables.net Plugin    -->
<script src="/assets/js/jquery.datatables.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        
        $('.menu-left-custom >li.active').removeClass('active');
        $('#tags').parent('li').addClass('active');
        $('.show .tags').addClass('active');
        $('#tags').collapse();

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


        $('.card .material-datatables label').addClass('form-group');
    });
</script>
@stop
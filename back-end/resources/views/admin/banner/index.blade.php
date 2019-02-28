@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', "Danh sách banner")
@section('main')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="purple">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Danh sách banner</h4>
                    <div class="toolbar">
                        <!-- Here you can write extra buttons/actions for the toolbar   -->                        

                    </div>
                    
                    <div class="material-datatables">
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên phim</th>
                                    <th>Ngày tạo</th>
                                    <th>Lần cập nhật cuối</th>                                    
                                    <th class="text-right">Hành động</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên phim</th>
                                    <th>Ngày tạo</th>
                                    <th>Lần cập nhật cuối</th>
                                    <th class="text-right">Hành động</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($data['info'] as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->mov_name }}</td>
                                    <td>{{ customDate($value->created_at , 'daytime') }}</td>
                                    <td>{{ customDate($value->updated_at , 'daytime') }}</td>
                                    <td class="text-right">                                        
                                        @if (session()->get('permission')->canDelete)
                                            <a href="{{base_url("admin/banner/del/$value->id") }}" class="btn btn-simple btn-danger btn-icon remove">Xóa</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>                        
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
<!-- Select Plugin -->
<script src="/assets/js/jquery.select-bootstrap.js"></script>
<!--    Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script type="text/javascript">
    $(document).ready(function() {

        $('.menu-left-custom >li.active').removeClass('active');
        $('#banner').parent('li').addClass('active');
        $('#banner .show').addClass('active');
        $('#banner').collapse();

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
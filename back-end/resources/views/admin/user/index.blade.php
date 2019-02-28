@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', 'Danh sách admin')
@section('main')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="purple">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Danh sách admin</h4>
                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
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
                                    </select>
                                    <!-- <span>Kết quả</span> -->
                                </div>
                                <div style="margin: 5px;width: 30%;display: inline-block">
                                    <span>Sắp xếp</span>
                                    <select class="selectpicker col-4" data-style="btn btn-primary btn-round"  data-size="7" style="width: 20% !important" name="sort">                                
                                        <option value="desc" {{ @$data['filter']['sort'] == 'desc' ? 'selected' : ''}}>Giảm dần</option>
                                        <option value="asc" {{ @$data['filter']['sort'] == 'asc' ? 'selected' : ''}}>Tăng dần</option>                     
                                    </select>
                                    <span>theo</span>
                                    <select class="selectpicker col-4" data-style="btn btn-primary btn-round"  data-size="7" style="width: 20% !important" name="orderBy">                                
                                        <option value="id" {{ @$data['filter']['orderBy'] == 'id' ? 'selected' : ''}}>ID</option>
                                        <option value="email" {{ @$data['filter']['orderBy'] == 'email' ? 'selected' : ''}}>Email</option>
                                        <option value="created_at" {{ @$data['filter']['orderBy'] == 'created_at' ? 'selected' : ''}}>Ngày tạo</option>
                                        <!-- <option value="asc" {{ @$data['filter']['orderBy'] == 'asc' ? 'selected' : ''}}>Tăng dần</option>                      -->
                                    </select>
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
                                    <th>Email</th>
                                    <th>Họ</th>
                                    <th>Tên</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Email</th>
                                    <th>Họ</th>
                                    <th>Tên</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành Động</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($data['info'] as $value)
                                <tr>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ $value->first_name }}</td>
                                    <td>{{ $value->last_name }}</td>
                                    <td>{{ $value->status === 1 ? 'Kích hoạt' : 'Vô hiệu hóa' }}</td>
                                    <td>{{ $value->created_at }}</td>
                                    <td >
                                        <a href="{{base_url('admin/user/detail/'.$value->id) }}" class="btn btn-simple btn-warning btn-icon edit">Chi tiết</a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                        @if( $data['info']->hasPages() )
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" role="status" aria-live="polite">
                                    Hiển thị {{ $data['info']->count() == 0 ? '0 kết quả' : ( 'từ '.  (($data['info']->currentPage()-1)*$data['info']->perPage() + 1 ).' tới '. (($data['info']->currentPage()-1)*$data['info']->perPage() + $data['info']->count()) .' trong tổng số '. ($data['info']->total() .' kết quả') ) }}
                                </div>
                            </div>
                            
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
        $('#groupAdmin').parent('li').addClass('active');
        $('#groupAdmin .admin.show').addClass('active');
        $('#groupAdmin').collapse();

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


        // var table = $('#datatables').DataTable();

        // // Edit record
        // table.on('click', '.edit', function() {
        //     $tr = $(this).closest('tr');

        //     var data = table.row($tr).data();
        //     alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        // });

        // // Delete a record
        // table.on('click', '.remove', function(e) {
        //     $tr = $(this).closest('tr');
        //     table.row($tr).remove().draw();
        //     e.preventDefault();
        // });

        // //Like record
        // table.on('click', '.like', function() {
        //     alert('You clicked on Like button');
        // });

        $('.card .material-datatables label').addClass('form-group');
    });
</script>
@stop
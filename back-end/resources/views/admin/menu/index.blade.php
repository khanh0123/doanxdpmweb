@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', 'Danh sách menu')
@section('main')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="purple">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Danh sách menu</h4>
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
                                        <option value="10" {{ @$data['info']['filter']['limit'] == 10 ? 'selected' : ''}}>10</option>
                                        <option value="20" {{ @$data['info']['filter']['limit'] == 20 ? 'selected' : ''}}>20</option>
                                        <option value="30" {{ @$data['info']['filter']['limit'] == 30 ? 'selected' : ''}}>30</option>
                                        <option value="40" {{ @$data['info']['filter']['limit'] == 40 ? 'selected' : ''}}>40</option>
                                    </select>
                                    <!-- <span>Kết quả</span> -->
                                </div>
                                <div style="margin: 5px;width: 30%;display: inline-block">
                                    <span>Sắp xếp</span>
                                    <select class="selectpicker col-4" data-style="btn btn-primary btn-round"  data-size="7" style="width: 20% !important" name="sort">                                
                                        <option value="desc" {{ @$data['info']['filter']['sort'] == 'desc' ? 'selected' : ''}}>Giảm dần</option>
                                        <option value="asc" {{ @$data['info']['filter']['sort'] == 'asc' ? 'selected' : ''}}>Tăng dần</option>                     
                                    </select>
                                    <span>theo</span>
                                    <select class="selectpicker col-4" data-style="btn btn-primary btn-round"  data-size="7" style="width: 20% !important" name="orderBy">                                
                                        <option value="id" {{ @$data['info']['filter']['orderBy'] == 'id' ? 'selected' : ''}}>ID</option>
                                        <option value="email" {{ @$data['info']['filter']['orderBy'] == 'email' ? 'selected' : ''}}>Email</option>
                                        <option value="created_at" {{ @$data['info']['filter']['orderBy'] == 'created_at' ? 'selected' : ''}}>Ngày tạo</option>
                                        <!-- <option value="asc" {{ @$data['info']['filter']['orderBy'] == 'asc' ? 'selected' : ''}}>Tăng dần</option>                      -->
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
                                    <th>Tên Menu</th>
                                    <th>Slug</th>
                                    <th>Ngày tạo</th>
                                    <th>Lần cập nhật cuối</th>
                                    <th class="text-right">Hành động</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Tên Menu</th>
                                    <th>Slug</th>
                                    <th>Ngày tạo</th>
                                    <th>Lần cập nhật cuối</th>
                                    <th class="text-right">Hành động</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($data['info'] as $value)
                                <tr>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->slug }}</td>
                                    <td>{{ $value->created_at }}</td>
                                    <td>{{ $value->updated_at }}</td>
                                    <td class="text-right">
                                        <a href="{{base_url('admin/menu/detail/'.$value->id) }}" class="btn btn-simple btn-warning btn-icon edit">Chi tiết</a>
                                        @if (session()->get('permission')->canDelete)
                                        <a href="{{base_url('admin/menu/del/'.$value->id) }}" class="btn btn-simple btn-danger btn-icon remove">Xóa</a>
                                        @endif
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
        $('#menu').parent('li').addClass('active');
        $('#menu .show').addClass('active');
        $('#menu').collapse();

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
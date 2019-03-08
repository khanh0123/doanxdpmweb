@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', 'Danh sách phim')
@section('main')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="purple">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Danh sách phim</h4>
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
                                        <option value="name" {{ @$data['filter']['orderBy'] == 'name' ? 'selected' : ''}}>Tên Phim</option>
                                        <option value="epi_num" {{ @$data['filter']['orderBy'] == 'epi_num' ? 'selected' : ''}}>Số tập</option>
                                        <option value="release_date" {{ @$data['filter']['orderBy'] == 'release_date' ? 'selected' : ''}}>Ngày ra rạp</option>
                                        <option value="is_hot" {{ @$data['filter']['orderBy'] == 'is_hot' ? 'selected' : ''}}>Phim hot</option>
                                        <option value="is_new" {{ @$data['filter']['orderBy'] == 'is_new' ? 'selected' : ''}}>Phim mới</option>
                                        <option value="is_banner" {{ @$data['filter']['orderBy'] == 'is_banner' ? 'selected' : ''}}>Banner</option>
                                        <option value="created_at" {{ @$data['filter']['orderBy'] == 'created_at' ? 'selected' : ''}}>Thời gian tạo</option>
                                        <option value="updated_at" {{ @$data['filter']['orderBy'] == 'updated_at' ? 'selected' : ''}}>Thời gian cập nhật</option>                     
                                    </select>
                                </div>
                                <div style="margin: 5px;width: 30%;display: inline-block">
                                    <span>Từ khóa tìm kiếm </span>
                                    <div class="form-group" style="margin: 0;padding-left: 10px">
                                        <input type="text" class="form-control" value="{{ @$data['filter']['name'] }}" name="name">

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
                                    <th>ID</th>
                                    <th>Tên phim</th>
                                    <th>Danh mục</th>
                                    <th>Số tập</th>
                                    <th>Ngày ra rạp</th>
                                    <th>Phim hot</th>
                                    <th>Phim mới</th>
                                    <th>Banner</th>
                                    <th>Lần cập nhật cuối</th>
                                    <th class="text-center">Chọn làm banner</th>
                                    <th class="text-right">Hành động</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên phim</th>
                                    <th>Danh mục</th>
                                    <th>Số tập</th>
                                    <th>Ngày ra rạp</th>
                                    <th>Phim hot</th>
                                    <th>Phim mới</th>
                                    <th>Banner</th>
                                    <th>Lần cập nhật cuối</th>
                                    <th class="text-center">Chọn làm banner</th>
                                    <th class="text-right">Hành động</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($data['info'] as $value)
                                <tr>
                                    <td class="id_mov">{{ $value->id }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->cat_name }}</td>
                                    <td>{{ $value->epi_num }}</td>
                                    <td>{{ customDate($value->release_date) }}</td>
                                    <td >

                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox" name="is_hot" value="{{$value->is_hot ? 1 : 0}}" {{$value->is_hot ? 'checked' : ''}}>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox" name="is_new" value="{{$value->is_new ? 1 : 0}}" {{$value->is_new ? 'checked' : ''}}>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox" name="is_banner" value="{{$value->is_banner ? 1 : 0}}" {{$value->is_banner ? 'checked' : ''}}>
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{ customDate($value->updated_at , 'daytime') }}</td>
                                    <td class="text-center">
                                        <form method="post" action="{{base_url('admin/banner/add')}}" class="d-block">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="{{$value->id}}" name="mov_id">
                                            <button type="submit" class="btn btn-simple btn-info btn-icon edit">Chọn</button>
                                        </form>
                                    </td>
                                    <td class="text-right">                                       
                                        
                                        <a href="{{ base_url('admin/movie/detail/'.$value->id) }}" class="btn btn-simple btn-warning btn-icon edit">Chi tiết</a>
                                        <a href="{{ base_url('admin/movie/'.$value->id.'/episode') }}" class="btn btn-simple btn-success btn-icon">Quản Lý Tập</a>
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
        $('#movie').parent('li').addClass('active');
        $('#movie .show').addClass('active');
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
        $('.card .material-datatables label').addClass('form-group');
        var url = '{{url("admin/movie/switch")}}';
        $('body .togglebutton input').on('change',function(event) {
            if($(this).is(':checked')){
                $(this).val(1);
            } else {
                $(this).val(0);
            }
            var name = $(this).attr('name');
            var value = $(this).val();
            var id = $(this).parents("td").prevAll(".id_mov").html();
            var data;
            switch (name) {
                case 'is_hot':
                    data = {is_hot:value};
                    break;
                case 'is_new':
                    data = {is_new:value};
                    break;
                case 'is_banner':
                    data = {is_banner:value};
                    break;
                default:
                    return false;
            }

            if(name && parseInt(id) > 0){
                data.id = id;
                data._token = $('input[name="_token"]').val();
                $.ajax({
                    url: `${url}`,
                    type: 'POST',
                    dataType: 'JSON',
                    data: data,
                })
                .done(function(res) {
                    console.log(res);
                })
                .fail(function(err) {
                    console.log(err);
                })
                
            }
            
        });
        
    });
</script>
@stop
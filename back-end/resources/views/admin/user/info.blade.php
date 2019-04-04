@extends('admin/layout' , ['message' => !empty($message) ? $message : []])
@section('title', 'Chi tiết thông tin Admin')
@section('main')
<div class="container-fluid">
    <div class="alert alert-light" role="alert">
        
        <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">perm_identity</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">View Profile
                                        
                                    </h4>
                                    <form>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">ID</label>
                                                    <input type="text" class="form-control" disabled value="{{session('user')->id}}">
                                                </div>
                                            </div>
                                         </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">UserName</label>
                                                    <input type="text" class="form-control" disabled value="{{session('user')->username}}">
                                                </div>
                                            </div>
                                         </div>
                                         <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Vai Trò</label>
                                                    <input type="text" class="form-control" disabled value="{{$data['info']->name}}">
                                                </div>
                                            </div>
                                         </div>
                                         <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Tình Trạng</label>
                                                    <input type="text" class="form-control" disabled value="<?php if (session('user')->status==1): 
                                                    	echo "Hoạt Động"
                                                    ?>
                                                    
                                                    <?php endif ?>">
                                                </div>
                                            </div>
                                         </div>
                                          <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Ngày Gia Nhập</label>
                                                    <input type="text" class="form-control" disabled value="{{session('user')->created_at}}">
                                                </div>
                                            </div>
                                         </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-profile">
                                <div class="card-avatar">
                                    <a href="user.html#pablo">
                                        <img class="img" src="/assets/img/faces/card-profile1-square.jpg" />
                                    </a>
                                </div>
                                <div class="card-content">
                                    <h6 class="category text-gray">{{$data['info']->name}}</h6>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@stop

    @section('css')
    <!-- add custom css here -->
    @stop
    
    @section('js')
    @stop
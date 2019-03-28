@extends('frontend/layout')
@section('title','Tin tức online')
@section('description','Tin tức online')
@section('content')
<div class="row">
	<div class="col-md-8">
		
	</div>
	<div class="col-md-4">
		@include('frontend/includes/more_view')
		@include('frontend/includes/hot_category')
	</div>
</div>


@stop
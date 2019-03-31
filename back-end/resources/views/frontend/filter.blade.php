@extends('frontend/layout' , ['breadcrumb' => $filter[0]])
@section('title','Tin tức online')
@section('description','Tin tức online')
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="row">
			@if(count($filter) > 0)
			<div class="col-md-12">
				<div class="post post-thumb">
					<a class="post-img" href="{{ route('Frontend.Detail.index',['slug' => $filter[0]->slug,'id' => $filter[0]->id]) }}"><img src="{{ $filter[0]->images }}" alt="{{ $filter[0]->title }}"></a>
					<div class="post-body">
						<div class="post-meta">
							<a class="post-category cat-2" href="{{ url($filter[0]->tag_slug) }}">{{ $filter[0]->tag_name }}</a>
							<span class="post-date">{{ customDate($filter[0]->created_at)}}</span>
						</div>
						<h3 class="post-title"><a href="{{ route('Frontend.Detail.index',['slug' => $filter[0]->slug,'id' => $filter[0]->id]) }}">{{ $filter[0]->title }}</a></h3>
					</div>
				</div>
			</div>
			@endif
			@for($i = 1 ; $i < 3 ; $i++)
			<div class="col-md-6">
				<div class="post">
					<a class="post-img" href="{{ route('Frontend.Detail.index',['slug' => $filter[$i]->slug,'id' => $filter[$i]->id]) }}"><img src="{{ $filter[$i]->images }}" alt="{{ $filter[$i]->title }}"></a>
					<div class="post-body">
						<div class="post-meta">
							<a class="post-category cat-2" href="{{ url($filter[$i]->tag_slug) }}">{{ $filter[$i]->tag_name }}</a>
							<span class="post-date">{{ customDate($filter[$i]->created_at)}}</span>
						</div>
						<h3 class="post-title"><a href="{{ route('Frontend.Detail.index',['slug' => $filter[$i]->slug,'id' => $filter[$i]->id]) }}">{{ $filter[$i]->title }}</a></h3>
					</div>
				</div>
			</div>
			@endfor
			<div class="clearfix visible-md visible-lg"></div>
			@for($i = 3 ; $i < count($filter) ; $i++)
			<div class="col-md-12">
				<div class="post post-row">
					<a class="post-img" href="{{ route('Frontend.Detail.index',['slug' => $filter[$i]->slug,'id' => $filter[$i]->id]) }}"><img src="{{ $filter[$i]->images }}" alt="{{ $filter[$i]->title }}"></a>
					<div class="post-body">
						<div class="post-meta">
							<a class="post-category cat-2" href="{{ url($filter[$i]->tag_slug) }}">{{ $filter[$i]->tag_name }}</a>
							<span class="post-date">{{ customDate($filter[$i]->created_at)}}</span>
						</div>
						<h3 class="post-title"><a href="{{ route('Frontend.Detail.index',['slug' => $filter[$i]->slug,'id' => $filter[$i]->id]) }}">{{ $filter[$i]->title }}</a></h3>
					</div>
				</div>
			</div>
			@endfor
			<div class="col-md-12">
				<div class="section-row" style="text-align: center;">
					{{ $filter->links() }}
					<!-- <button class="primary-button center-block">Xem thêm</button> -->
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		@include('frontend/includes/more_view')
		@include('frontend/includes/hot_category')
	</div>
</div>


@stop
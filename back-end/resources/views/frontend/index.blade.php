@extends('frontend/layout')
@section('title','Tin tức online')
@section('description','Tin tức online')
@section('content')
<!-- row -->
<div class="row">	
	@foreach($new_posts as $value)
	<!-- post -->
	<div class="col-md-6">
		<div class="post post-thumb">
			<a class="post-img" href="{{ url('chi-tiet/'.$value->slug.'/'.$value->id) }}"><img src="{{ $value->images }}" alt="{{ $value->title }}"></a>
			<div class="post-body">
				<div class="post-meta">
					<a class="post-category cat-2" href="{{ url($value->tag_slug) }}">{{ $value->tag_name }}</a>
					<span class="post-date">{{ customDate($value->created_at)}}</span>
				</div>
				<h3 class="post-title"><a href="{{ url('chi-tiet/'.$value->slug.'/'.$value->id) }}">{{ $value->title }}</a></h3>
			</div>
		</div>
	</div>
	<!-- /post -->
	@endforeach


</div>
<!-- /row -->

@if(!empty($internet_security_posts))
<!-- row -->
<div class="row">

	<div class="col-md-12">
		<div class="section-title">
			<h2>Chủ đề HOT</h2>
		</div>
	</div>

	<!-- post -->
	@foreach(@$internet_security_posts as $key => $value)
	<div class="col-md-4">
		<div class="post">
			<a class="post-img" href="{{ url('chi-tiet/'.$value->slug.'/'.$value->id) }}"><img src="{{ $value->images }}" alt=""></a>
			<div class="post-body">
				<div class="post-meta">
					<a class="post-category cat-1" href="{{ url($value->tag_slug) }}">{{ $value->tag_name }}</a>
					<span class="post-date">{{ customDate($value->created_at)}}</span>
				</div>
				<h3 class="post-title"><a href="{{ url('chi-tiet/'.$value->slug.'/'.$value->id) }}">{{ $value->title }}</a></h3>
			</div>
		</div>
	</div>
	@if(($key + 1) % 3 == 0)
	<div class="clearfix visible-md visible-lg"></div>
	@endif
	@endforeach
	<!-- /post -->
</div>
<!-- /row -->
@endif

<!-- row -->
<div class="row">
	<div class="col-md-8">
		<div class="row">
			@if(count($hot_posts) > 0)
			<div class="col-md-12">
				<div class="post post-thumb">
					<a class="post-img" href="{{ url('chi-tiet/'.$hot_posts[0]->slug.'/'.$hot_posts[0]->id) }}"><img src="{{ $hot_posts[0]->images }}" alt="{{ $hot_posts[0]->title }}"></a>
					<div class="post-body">
						<div class="post-meta">
							<a class="post-category cat-2" href="{{ url($hot_posts[0]->tag_slug) }}">{{ $hot_posts[0]->tag_name }}</a>
							<span class="post-date">{{ customDate($hot_posts[0]->created_at)}}</span>
						</div>
						<h3 class="post-title"><a href="{{ url('chi-tiet/'.$hot_posts[0]->slug.'/'.$hot_posts[0]->id) }}">{{ $hot_posts[0]->title }}</a></h3>
					</div>
				</div>
			</div>
			@for($i = 1 ; $i < count($hot_posts) ; $i++ )
			<div class="col-md-6">
				<div class="post">
					<a class="post-img" href="{{ url('chi-tiet/'.$hot_posts[$i]->slug.'/'.$hot_posts[$i]->id) }}"><img src="{{$hot_posts[$i]->images}}" alt="{{ $hot_posts[$i]->title }}"></a>
					<div class="post-body">
						<div class="post-meta">
							<a class="post-category cat-4" href="{{ url($hot_posts[$i]->tag_slug) }}">{{$hot_posts[$i]->tag_name}}</a>
							<span class="post-date">{{ customDate($hot_posts[$i]->created_at)}}</span>
						</div>
						<h3 class="post-title"><a href="{{ url('chi-tiet/'.$hot_posts[$i]->slug.'/'.$hot_posts[$i]->id) }}">{{$hot_posts[$i]->title}}</a></h3>
					</div>
				</div>
			</div>
			@if($i % 2 == 0)
			<div class="clearfix visible-md visible-lg"></div>
			@endif

			@endfor
			@endif
		</div>
	</div>

	<div class="col-md-4">
		@include('frontend/includes/more_view')
		@include('frontend/includes/hot_category')
	</div>
</div>
<!-- /row -->
</div>
@stop
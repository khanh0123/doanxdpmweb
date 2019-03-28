<!-- post widget -->
<div class="aside-widget">
	<div class="section-title">
		<h2>Lượt xem nhiều</h2>
	</div>
	@foreach($most_read_posts as $value)
	<div class="post post-widget">
		<a class="post-img" href="blog-post.html"><img src="{{ $value->images }}" alt="{{ $value->title }}"></a>
		<div class="post-body">
			<h3 class="post-title"><a href="{{ url('chi-tiet/'.$value->slug.'/'.$value->id) }}">{{ $value->title }}</a></h3>
		</div>
	</div>
	@endforeach


</div>
<!-- /post widget -->

<!-- ad -->
<div class="aside-widget text-center">
	<a href="#" style="display: inline-block;margin: auto;">
		<img class="img-responsive" src="https://media.sproutsocial.com/uploads/2018/06/Facebook-Ad-Targeting.png" alt="">
	</a>
</div>
				<!-- /ad -->
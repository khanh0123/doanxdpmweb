@if(!empty($menu))
<!-- catagories -->
<div class="aside-widget">
	<div class="section-title">
		<h2>Danh mục hot</h2>
	</div>
	<div class="category-widget">
		<ul>
			@foreach($menu as $value)
			<li><a href="{{url($value->tag_slug)}}" class="cat-1">{{$value->tag_name}}<span>{{ $value->num_post }}</span></a></li>
			@endforeach

		</ul>
	</div>
</div>
<!-- /catagories -->
@endif
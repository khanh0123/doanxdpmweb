
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>WebMag HTML Template</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:700%7CNunito:300,600" rel="stylesheet"> 

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="{{asset('homepage/css/bootstrap.min.css')}}"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="{{asset('homepage/css/font-awesome.min.css')}}">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="{{asset('homepage/css/style.css')}}"/>

		<!-- HTML5 shim and Respond.homepage/js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.homepage/js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.homepage/js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.homepage/js"></script>
		<![endif]-->

    </head>
	<body>

		<!-- Header -->
		<header id="header">
			<!-- Nav -->
			<div id="nav">
				<!-- Main Nav -->
				<div id="nav-fixed">
					<div class="container">
						<!-- logo -->
						<div class="nav-logo">
							<a href="/" class="logo"><img width="114px" height="100px" src="homepage/img/logo.png" alt=""></a>
						</div>
						<!-- /logo -->

						<!-- nav -->
						<ul class="nav-menu nav navbar-nav">

							@foreach($menu as $key => $value)
								<li><a href="{{ url('') }}">{{ $value->name }}</a></li>
							@endforeach
						</ul>
						<!-- /nav -->
					</div>
				</div>
				<!-- /Main Nav -->
			</div>
			<!-- /Nav -->
		</header>
		<!-- /Header -->

		<!-- section -->
		<div class="section">
			<!-- container -->
			<div class="container">
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

						<!-- post widget -->
						<!-- <div class="aside-widget">
							<div class="section-title">
								<h2>Featured Posts</h2>
							</div>
							<div class="post post-thumb">
								<a class="post-img" href="blog-post.html"><img src="homepage/img/post-2.jpg" alt=""></a>
								<div class="post-body">
									<div class="post-meta">
										<a class="post-category cat-3" href="category.html">Jquery</a>
										<span class="post-date">March 27, 2018</span>
									</div>
									<h3 class="post-title"><a href="blog-post.html">Ask HN: Does Anybody Still Use JQuery?</a></h3>
								</div>
							</div>

							<div class="post post-thumb">
								<a class="post-img" href="blog-post.html"><img src="homepage/img/post-1.jpg" alt=""></a>
								<div class="post-body">
									<div class="post-meta">
										<a class="post-category cat-2" href="category.html">JavaScript</a>
										<span class="post-date">March 27, 2018</span>
									</div>
									<h3 class="post-title"><a href="blog-post.html">Chrome Extension Protects Against JavaScript-Based CPU Side-Channel Attacks</a></h3>
								</div>
							</div>
						</div> -->
						<!-- /post widget -->
						
						<!-- ad -->
						<div class="aside-widget text-center">
							<a href="#" style="display: inline-block;margin: auto;">
								<img class="img-responsive" src="https://media.sproutsocial.com/uploads/2018/06/Facebook-Ad-Targeting.png" alt="">
							</a>
						</div>
						<!-- /ad -->
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /section -->
		

		<!-- section -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-8">
						<div class="row">
							<!-- post -->
							<div class="col-md-12" id="posts_ajax">
								<!-- <div class="post post-row">
									<a class="post-img" href="blog-post.html"><img src="homepage/img/post-4.jpg" alt=""></a>
									<div class="post-body">
										<div class="post-meta">
											<a class="post-category cat-2" href="category.html">JavaScript</a>
											<span class="post-date">March 27, 2018</span>
										</div>
										<h3 class="post-title"><a href="blog-post.html">Chrome Extension Protects Against JavaScript-Based CPU Side-Channel Attacks</a></h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...</p>
									</div>
								</div> -->
								
									
							</div>
							


							<!-- /post -->

							
							
							<!-- <div class="col-md-12">
								<div class="section-row">
									<button class="primary-button center-block">Load More</button>
								</div>
							</div> -->
						</div>
					</div>

					<div class="col-md-4">
						<!-- ad -->
						<div class="aside-widget text-center">
							<a href="#" style="display: inline-block;margin: auto;">
								<img class="img-responsive" src="https://media.sproutsocial.com/uploads/2018/06/Facebook-Ad-Targeting.png" alt="">
							</a>
						</div>
						<!-- /ad -->
						
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

					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /section -->

		<!-- Footer -->
		<footer id="footer">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-5">
						<div class="footer-widget">
							<div class="footer-logo">
								<a href="index.html" class="logo"><img  width="114px" height="100px"  src="homepage/img/logo.png" alt=""></a>
							</div>
							<ul class="footer-nav">
								<li><a href="#">Privacy Policy</a></li>
								<li><a href="#">Advertisement</a></li>
							</ul>
							<div class="footer-copyright">
								<span>&copy; <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></span>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="row">
							<div class="col-md-6">
								<div class="footer-widget">
									<h3 class="footer-title">About Us</h3>
									<ul class="footer-links">
										<li><a href="about.html">About Us</a></li>
										<li><a href="#">Join Us</a></li>
										<li><a href="contact.html">Contacts</a></li>
									</ul>
								</div>
							</div>
							<div class="col-md-6">
								<div class="footer-widget">
									<h3 class="footer-title">Catagories</h3>
									<ul class="footer-links">
										<li><a href="category.html">Web Design</a></li>
										<li><a href="category.html">JavaScript</a></li>
										<li><a href="category.html">Css</a></li>
										<li><a href="category.html">Jquery</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="footer-widget">
							<h3 class="footer-title">Join our Newsletter</h3>
							<div class="footer-newsletter">
								<form>
									<input class="input" type="email" name="newsletter" placeholder="Enter your email">
									<button class="newsletter-btn"><i class="fa fa-paper-plane"></i></button>
								</form>
							</div>
							<ul class="footer-social">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
								<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
							</ul>
						</div>
					</div>

				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</footer>
		<!-- /Footer -->

		<!-- jQuery Plugins -->
		<script src="homepage/js/jquery.min.js"></script>
		<script src="homepage/js/bootstrap.min.js"></script>
		<script src="homepage/js/main.js"></script>
		<script>
			var current_page = 1;
			var max_page = 0;
			var is_request = false;
			var url = "{{url('')}}/";
			$(document).ready(function() {
				get_data(current_page);			
				$(window).on('scroll', function(event) {
					if(max_page > current_page) {
						
						var bottom = offsetBottom("#posts_ajax");
						console.log(bottom);
						if(bottom < 600 && !is_request) {
							is_request = true
							current_page++;
							get_data(current_page)
						}
						
					}
					
				});	
			});

			function template(info){
				var link = `/chi-tiet/${info.slug}/${info.id}`;
				var link_tag = `/${info.tag_slug}`;
				var html = `<div class="post post-row">
								<a class="post-img" href="${link}"><img src="${info.images}" alt="${info.title}"></a>
								<div class="post-body">
								<div class="post-meta">
								<a class="post-category cat-2" href="${link_tag}">${info.tag_name}</a>
								<span class="post-date">${info.created_at}</span>
								</div>
								<h3 class="post-title"><a href="${link}">${info.title}</a></h3>
								<p>${info.short_des}...</p>
								</div>
								</div>`;
				return html;
			}
			function get_data(p){
				$('#posts_ajax').append('<div style="text-align: center" id="loading"><div class="fa fa-spinner fa-pulse fa-3x fa-fw"></div></div>');
				$.ajax({
					url: `${url}api/v1/posts`,
					type: 'GET',
					dataType: 'JSON',
					data: {
						limit: 10,
						page:p,
						sort:'desc',
						shuffle:true,
					},
				})
				.done(function(res) {
					if(res && res.info && res.info.data){
						let data = res.info.data;
						let html = '';
						// data.sort(function() {
						// 	return 0.5 - Math.random();
						// });
						for(var i = 0; i < data.length; i++){
							html += template(data[i]);

						}
						$('#posts_ajax').append(html);
						$('#loading').remove();
						// current_page = res.info.current_page;
						max_page = res.info.last_page;

					}
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					is_request = false;
				});
			}
			function offsetBottom(el, i) { i = i || 0; return $(el)[i].getBoundingClientRect().bottom }
		</script>

	</body>
</html>

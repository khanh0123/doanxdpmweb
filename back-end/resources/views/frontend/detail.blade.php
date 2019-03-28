@extends('frontend/layout')
@section('title',$post_info->title)
@section('description',$post_info->short_des)
@section('content')

<!-- row -->
<div class="row">
	<!-- Post content -->
	<div class="col-md-8">
		<div class="section-row sticky-container">
			<div class="main-post" style="overflow-x: hidden;">
				{!! $post_info->content !!}
			</div>
			<div class="post-shares sticky-shares">
				<a href="#" class="share-facebook"><i class="fa fa-facebook"></i></a>
				<a href="#" class="share-twitter"><i class="fa fa-twitter"></i></a>
				<a href="#" class="share-google-plus"><i class="fa fa-google-plus"></i></a>
				<a href="#" class="share-pinterest"><i class="fa fa-pinterest"></i></a>
				<a href="#" class="share-linkedin"><i class="fa fa-linkedin"></i></a>
				<a href="#"><i class="fa fa-envelope"></i></a>
			</div>
		</div>

		<!-- ad -->
		<div class="section-row text-center">
			<a href="#" style="display: inline-block;margin: auto;">
				<img class="img-responsive" src="./img/ad-2.jpg" alt="">
			</a>
		</div>
		<!-- ad -->

		<!-- author -->
				<!-- <div class="section-row">
					<div class="post-author">
						<div class="media">
							<div class="media-left">
								<img class="media-object" src="./img/author.png" alt="">
							</div>
							<div class="media-body">
								<div class="media-heading">
									<h3>John Doe</h3>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
								<ul class="author-social">
									<li><a href="#"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
									<li><a href="#"><i class="fa fa-instagram"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div> -->
				<!-- /author -->

				<!-- comments -->
				<div class="section-row">
					<div class="section-title">
						<h2>3 Comments</h2>
					</div>

					<div class="post-comments">
						<!-- comment -->
						<div class="media">
							<div class="media-left">
								<img class="media-object" src="./img/avatar.png" alt="">
							</div>
							<div class="media-body">
								<div class="media-heading">
									<h4>John Doe</h4>
									<span class="time">March 27, 2018 at 8:00 am</span>
									<a href="#" class="reply">Reply</a>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

								<!-- comment -->
								<div class="media">
									<div class="media-left">
										<img class="media-object" src="./img/avatar.png" alt="">
									</div>
									<div class="media-body">
										<div class="media-heading">
											<h4>John Doe</h4>
											<span class="time">March 27, 2018 at 8:00 am</span>
											<a href="#" class="reply">Reply</a>
										</div>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
									</div>
								</div>
								<!-- /comment -->
							</div>
						</div>
						<!-- /comment -->

						<!-- comment -->
						<div class="media">
							<div class="media-left">
								<img class="media-object" src="./img/avatar.png" alt="">
							</div>
							<div class="media-body">
								<div class="media-heading">
									<h4>John Doe</h4>
									<span class="time">March 27, 2018 at 8:00 am</span>
									<a href="#" class="reply">Reply</a>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
							</div>
						</div>
						<!-- /comment -->
					</div>
				</div>
				<!-- /comments -->

				<!-- reply -->
				<div class="section-row">
					<div class="section-title">
						<h2>Leave a reply</h2>
						<p>your email address will not be published. required fields are marked *</p>
					</div>
					<form class="post-reply">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<span>Name *</span>
									<input class="input" type="text" name="name">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<span>Email *</span>
									<input class="input" type="email" name="email">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<span>Website</span>
									<input class="input" type="text" name="website">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<textarea class="input" name="message" placeholder="Message"></textarea>
								</div>
								<button class="primary-button">Submit</button>
							</div>
						</div>
					</form>
				</div>
				<!-- /reply -->
			</div>
			<!-- /Post content -->

			<!-- aside -->
			<div class="col-md-4">
				@include('frontend/includes/more_view')
				@include('frontend/includes/hot_category')
			</div>
			<!-- /aside -->
		</div>
		<!-- /row -->

		@stop
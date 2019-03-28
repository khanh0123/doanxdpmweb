<!-- Header -->
<header id="header">
    <!-- Nav -->
    <div id="nav">
        <!-- Main Nav -->
        <div id="nav-fixed">
            <div class="container">
                <div class="nav-logo">
                    <a href="/" class="logo"><img width="114px" height="100px" src="homepage/img/logo.png" alt=""></a>
                </div>
                @if(!empty($menu))
                <ul class="nav-menu nav navbar-nav">

                    @foreach(@$menu as $key => $value)
                    <li><a href="{{ url('') }}">{{ $value->name }}</a></li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
        <!-- /Main Nav -->
    </div>
    <!-- /Nav -->
    @if(isset($post_info))
    <!-- Page Header -->
    <div id="post-header" class="page-header">
        <div class="background-img" style="background-image: url({{$post_info->images}});"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <div class="post-meta">
                        <a class="post-category cat-2" href="{{ $post_info->tag_slug }}">{{ $post_info->tag_name }}</a>
                        <span class="post-date">{{ customDate($post_info->created_at) }}</span>
                    </div>
                    <h1>{{ $post_info->title }}</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    @endif
</header>
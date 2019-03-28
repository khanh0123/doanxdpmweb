<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">

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
      @yield('css')
</head>

<body>
    @include('frontend/header')
    <div class="section">
        <div class="container">
            @yield('content')
        </div>
    </div>
    @include('frontend/footer')
    
</body>
<!-- jQuery Plugins -->
<script src="/homepage/js/jquery.min.js"></script>
<script src="/homepage/js/bootstrap.min.js"></script>
<script src="/homepage/js/main.js"></script>
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
                        //  return 0.5 - Math.random();
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


</html>
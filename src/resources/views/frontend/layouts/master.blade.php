<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="{{ isset($curPage)?$curPage->html_keyword:$settings->meta_keyword }}"/>
    <meta name="description" content="{{ isset($curPage)?$curPage->html_description:$settings->meta_desc }}"/>
    <link rel="shortcut icon" href="{{asset('assets/frontend/images/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/jquery.fancybox.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/custom-style.css')}}">
    <script src="{{asset('assets/frontend/js/jquery-3.4.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/frontend/js/forms/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/frontend/js/forms/common.js')}}"></script>
    <title><?php
        $page_title = isset($content) ? ($content->name). ' | ' : '';
        $page_title = isset($is_home) ?'Home | ':$page_title ;
        if (isset($settings->meta_title) && is_string($settings->meta_title)) {
            echo $page_title . $settings->meta_title;
        } else {
            echo 'Scotts';
        }
        ?></title>
    <script>
        function site_url(url) {
            return "<?php echo url('') ?>/" + url;
        }
    </script>
    @stack('links')
</head>

<body class="home-page">
@include('frontend.partials.header')
@yield('content')
@include('frontend.partials.footer')
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('assets/frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/wow.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.matchHeight-min.js')}}"></script>
<script src="{{asset('assets/frontend/js/slick.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/enlarge.js')}}"></script>
<script src="{{asset('assets/frontend/js/enlarge.init.js')}}"></script>
<script src="{{asset('assets/frontend/js/init.js')}}"></script>
<script src="{{asset('assets/frontend/js/main.js')}}"></script>

@stack('scripts')
</body>

</html>

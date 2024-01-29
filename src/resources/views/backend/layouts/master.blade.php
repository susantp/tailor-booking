<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{$title}} :: {{ config('site.title') }} , {{ config('site.subtitle') }} </title>
        <link rel="shortcut icon" href="{{asset('assets/backend/img/favicon.ico')}}" type="image/x-icon">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('assets/bower_components/font-awesome/css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{asset('assets/bower_components/Ionicons/css/ionicons.min.css')}}"> 
        <!-- DataTables -->
        <link rel="stylesheet" href="{{asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{asset('assets/bower_components/jvectormap/jquery-jvectormap.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('assets/backend/dist/css/AdminLTE.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{asset('assets/backend/dist/css/skins/_all-skins.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/backend/css/style.css')}}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        @stack('links')

        <script src="{{asset('assets/bower_components/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{asset('assets/backend/js/jquery.validate.js')}}"></script>
        <script>

$(".user_form").validate();
function site_url(url) {
    return "<?php echo url('/') ?>" + url;
}
var webpath = '<?php echo asset('assets'); ?>';
        </script>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            @include('backend.partials.header')
            <!-- Left side column. contains the logo and sidebar -->
            @include('backend.partials.navigation')
            <!-- Content Wrapper. Contains page content -->
            @yield('content')
            <!-- /.content-wrapper -->
            @include('backend.partials.footer')
            <!-- Control Sidebar -->
            <!-- /.control-sidebar -->

        </div>
        <!-- ./wrapper -->
        <!-- jQuery 3 -->
        <!--<script src="{{asset('assets/bower_components/jquery/dist/jquery.min.js')}}"></script>-->
        <!-- Bootstrap 3.3.7 -->
        <script src="{{asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!-- DataTables -->
        <script src="{{asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
        <!-- FastClick -->
        <script src="{{asset('assets/bower_components/fastclick/lib/fastclick.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('assets/backend/dist/js/adminlte.min.js')}}"></script>
        <!-- Sparkline -->
        <script src="{{asset('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
        <!-- jvectormap  -->
        <script src="{{asset('assets/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script src="{{asset('assets/backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
        <!-- SlimScroll -->
        <script src="{{asset('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
        <!-- ChartJS -->
        <script src="{{asset('assets/bower_components/chart.js/Chart.js')}}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--<script src="{{asset('assets/backend/dist/js/pages/dashboard2.js')}}"></script>-->
        <!-- AdminLTE for demo purposes -->
        <script src="{{asset('assets/backend/dist/js/demo.js')}}"></script>
        <script src="{{asset('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
        <?php
        if (isset($jsfile)) {
            if (is_array($jsfile)) {
                foreach ($jsfile as $jsf) {
                    $jsfile_path = config('site.root') . 'assets/backend/js/private/' . $jsf . '.js';
                    if (file_exists($jsfile_path)) {
                        $jsfile_url = asset('assets/backend/js/private/' . $jsf . '.js');
                        echo '<script src="' . $jsfile_url . '"></script>';
                    }
                }
            } else {
                $jsfile_path = config('site.root') . 'assets/backend/js/private/' . $jsfile . '.js';
                if (file_exists($jsfile_path)) {
                    $jsfile_url = asset('assets/backend/js/private/' . $jsfile . '.js');
                    echo '<script src="' . $jsfile_url . '"></script>';
                }
            }
        }
        ?>

        @yield('ckeditor')
        @stack('scripts')
        <script src="{{asset('assets/backend/js/all.js')}}"></script>
    </body>
</html>

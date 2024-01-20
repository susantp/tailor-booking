<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <title>elFinder 2.0</title>

        <!-- jQuery and jQuery UI (REQUIRED) -->
        <link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/smoothness/jquery-ui.css">
        <!--<link href="{{asset('application/public/colorbox-master/example1/colorbox.css" rel="stylesheet')}}">-->

        <!--<script type="text/javascript" src="{{asset('application/public/colorbox-master/jquery.colorbox-min.js')}}"></script>-->

        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" href="{{ asset('application/public/packages/barryvdh/elfinder/css/elfinder.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('application/public/packages/barryvdh/elfinder/css/theme.css') }}">

        <!-- elFinder JS (REQUIRED) -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="{{asset('application/public/packages/barryvdh/elfinder/js/standalonepopup.js')}}"></script>
        <script src="{{ asset('application/public/packages/barryvdh/elfinder/js/elfinder.min.js') }}"></script>


        <!-- Include jQuery, jQuery UI, elFinder (REQUIRED) -->

        <script type="text/javascript">
$(document).ready(function() {
    var elf = $('#elfinder').elfinder({
        // set your elFinder options here

        customData: {
            _token: '{{ csrf_token() }}'
        },
        url: '{{ route("elfinder.connector") }}', // connector URL
        soundPath: '{{ asset('application / public / packages / barryvdh / elfinder / sounds') }}',
        dialog: {width: 900, modal: true, title: 'Select a file'},
        resizable: false,
        commandsOptions: {
            getfile: {
                oncomplete: 'destroy'
            }
        },
//        getFileCallback: function(file) {
//            console.log(file);
//            window.parent.processSelectedFile(file.path, 'elfinder');
//            parent.jQuery.colorbox.close();
//        }
    }).elfinder('instance');
});
        </script>
    </head>
    <body>
        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder"></div>
    </body>
</html>

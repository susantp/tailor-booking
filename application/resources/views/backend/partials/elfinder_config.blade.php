@push('links')
<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="{{ asset('application/public/packages/barryvdh/elfinder/css/elfinder.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('application/public/packages/barryvdh/elfinder/css/theme.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('application/public/colorbox-master/example1/colorbox.css') }}">
@endpush

@push('scripts')
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

<script src="{{ asset('application/public/packages/barryvdh/elfinder/js/elfinder.min.js') }}"></script>
<script src="{{ asset('application/public/colorbox-master/jquery.colorbox-min.js') }}"></script>
<script type="text/javascript" src="{{asset('application/public/packages/barryvdh/elfinder/js/filepicker.js')}}"></script>
<script type="text/javascript">
$(document).ready(function () {
    var elf = $('#elfinder').elfinder({
        // set your elFinde r options here

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
@endpush
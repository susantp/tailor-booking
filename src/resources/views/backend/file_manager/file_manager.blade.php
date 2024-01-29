@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            File manager
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">File manager</h3>
                    </div>
                    <div class="box-body">
                        <div id="elfinder"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row hidden">
            <div class="col-md-12"> 
                <label for="feature_image">Feature Image</label>
                <input type="text" id="feature_image" name="feature_image" value="">
                <a href="" class="popup_selector" data-inputid="feature_image">Select Image</a>

        <!--<input type="text" onclick="BrowseServer(this)" data-resource-type="image" data-multiple="false" name="menu_icon"  class="form-control" id="menu_icon" placeholder="Menu Icon">-->

                <div class="form-group">
                    <label for="icons">Menu Icon</label>
                    <div class="img-append">
                        <?php if (!empty($menu->menu_icon)): ?>
                            <input type="text" onclick="BrowseServer(this)" data-resource-type="image" data-multiple="false" name="menu_icon" value="<?php echo $menu->menu_icon; ?>"  class="form-control" id="menu_icon" placeholder="Menu Icon">
                            <div class="image-wrapper">
                                <img class="img-responsive" src="<?php echo public_url() . 'assets/backend/' . $menu->menu_icon; ?>" />
                                <a href="javascript:void(0);" class="delete">
                                    Delete
                                </a>
                            </div>
                        <?php else: ?>
                            <input type="text" onclick="BrowseServer(this)" data-resource-type="image" data-multiple="false" name="menu_icon"  class="form-control" id="menu_icon" placeholder="Menu Icon">
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
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
<script type="text/javascript" src="{{asset('application/public/packages/barryvdh/elfinder/js/standalonepopup.js')}}"></script>
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
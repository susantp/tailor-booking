@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $panel_title ?>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"> <?php echo $panel_title ?></h3>
                    </div>
                    <div class="box-body">
                        @include('backend.partials.flash')
                        <?php echo $form; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<!-- //#condition check for elfinder include-->
@php
if ($has_elfinder) {
@endphp
@include('backend.partials.elfinder_config')
@php } @endphp
<!-- //#condition check for ckfinder include-->
@php
if ($has_ckeditor) {
@endphp
@include('backend.partials.ckeditor_config')
@php } @endphp
@endpush
@push('links')
<!--<link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">-->
@endpush
@extends('backend.layouts.master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Welcome To {{ config('site.name') }}  Dashboard
            <small>Version 2.0.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('backend.partials.flash')
        <p>While uploading files in the system, Please organize the files with corresponding folder name
            so that it will be easy to track the files in future.  <br>
            Please use clean name while creating folder.   <br>
            Avoid using spaces and special characters in folder name.  <br>
            You can type/paste the desired folder name in following text box and it will generate the clean folder name for you.   <br> 
            Copy the generated folder name and use in as name while creating folder.</p>
        <p>Generate Clean Folder Name:</p>
        <p><input type="text" name="name" id="name" value="" size="50"></p>
        <p><strong>Clean Folder name:</strong> <span class="slug"></span></p>

        <script>
            $(document).ready(function () {
                $("#name").keyup(function () {
                    slug = $(this).val();
                    new_slug = slug.toLowerCase();
                    new_slug = new_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                    $('.slug').text(new_slug);
                });
            });
        </script>
    </section>
    <!-- /.content -->
</div>
@endsection
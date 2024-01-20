@extends('backend.layouts.login_master')
@section('content')
    <div class="login-logo">
        <a href="#"><b>September</b>SHELL</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        @include('backend.partials.flash')
        <form method="post" action="{{ route('BACKEND-POST-PROCESS-FORGOT-PASSWORD', $passwordToken) }}" class="form-signin">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input type="password" class="form-control m-b-10" placeholder="Enter password" name="password" required="required">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control m-b-10" placeholder="Confirm Password" name="confirmPassword" required="required">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary ">Reset Password </button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
@endsection

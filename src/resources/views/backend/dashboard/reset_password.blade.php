@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reset Password
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Reset Password</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reset Password Form</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('reset.password.action') }}">
                        <div class="box-body">
                            @include('backend.partials.flash')
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label  class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" name="email" value="{{ $email }}" class="form-control"  required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Current Password</label>

                                <div class="col-sm-9">
                                    <input type="password" name="old_password"  placeholder="Current Password" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">New Password</label>

                                <div class="col-sm-9">
                                    <input type="password" name="new_password"  placeholder="New Password" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Re-enter Password</label>

                                <div class="col-sm-9">
                                    <input type="password" name="new_password_confirmation"placeholder="Re-enter Password" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a  class="btn btn-default" href="{{ route('BACKEND-DASHBOARD') }}">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right">Save Password</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
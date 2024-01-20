@extends('backend.layouts.master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $panel_title ?>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-xs-12">
                <div class="box ">
                    <div class="box-header with-border">
                        <?php if (isset($button_action) && ($activeModulePermission['add'])): ?>
                            <a class="btn btn-primary" href="{{ config('site.admin') . $module . '/create'  }}">{{ $button}}</a>
                        <?php endif; ?>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @include('backend.partials.flash')
                        <?php
                        if (!$datas->isEmpty()) {
                            $data_table = $apply_datatable ? 'applyDataTable' : '';
                            ?>
                            <table class="table table-bordered table-striped {{ $data_table }}">
                                <thead>
                                    <tr>
                                        <?php
                                        foreach ($fields as $field):
                                            if ($field == 'Action') {
                                                echo '<th class="table-action">' . $field . '</th>';
                                            } else {
                                                echo '<th>' . $field . '</th>';
                                            }
                                        endforeach;
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = $sn;
                                    foreach ($datas as $kk => $data):
                                        ?>
                                        <tr class="gradeA" id="sort_{{ $i}}"  role="row">
                                            <td class="sorting_1">{{$i++ }}</td>
                                            <td>{{$data->user->name }}</td>
                                            <td>{{$data->role->name }}</td>
                                            <td>{{$data->action }}</td>                                    
                                            <td>{{$data->module }}</td>                                    
                                            <td>{{$data->module_id }}</td>                                    
                                            <td>{{$data->ip_address }}</td>   
                                            <td>{{$data->created_at->format('dS M Y , l - H:i') }}</td>   
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            echo "No $item listed";
                        }
                        ?>
                    </div>
                    <div class="box-footer clearfix">
                        <div class="pull-right">
                            {{ $datas->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

{{-- Confirm Delete --}}
@if( !empty ( $data ) ) 
@include('backend.partials.confirm_delete')
@endif
@endsection
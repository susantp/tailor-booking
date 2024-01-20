<?php

if (substr($permissions, 0, 1) == 'E') { //#checking permissions to display options
    if ($activeModulePermission['edit']) {
        $action = true;
        $edit_url = config('site.admin') . $module . '/' . $data->$field_id . '/edit';
        echo '<a title="Edit  ' . $item . '" href="' . $edit_url . '" class="btn btn-primary btn-xs">
            <i class="fa fa-edit fa-fw"></i>
        </a>';
    }
}
if (substr($permissions, 1, 1) == 'D' || $permissions == 'D') {
    if ($activeModulePermission['delete']) {
        if (!isset($data->status)) {
            $data->status = '';
        }
        $action = true;
        $delete = true;
        //#just in case we need it in future byb!
//        switch ($module) {
//            case 'category':
//                if ($data->is_deletable == 'no') {
//                    $delete = false;
//                }
//                break;
//        }
        if ($delete) {
            $del_url = config('site.admin') . $module . '/' . $data->$field_id;
            echo ' <a class="btn btn-danger" title="Delete ' . $item . '" href="javascript:void(0);" onclick="deleteId(\'' . $del_url . '\')" data-toggle="modal" data-target="#modal-delete" class="delete-row">
                    <i class="fa fa-trash fa-fw tooltips" ></i>
                </a>';
        }
    }
}


if (substr($permissions, 2, 1) == 'S' || $permissions == 'S') {
    if ($activeModulePermission['delete']) {
        $action = true;
        $status = true;
        $status_url = config('site.admin') . $module . '/changeStatus/' . $data->$field_id;
        $hide_status_btn = isset($data->status) ? false : true;
        $class = ($d == '1') ? 'btn-success' : 'btn-warning';
        $title = ($d == '1') ? 'Active' : 'Inactive';
        //#just in case we need it in future byb!
//        switch ($module) {
//            case 'category':
//                if ($data->is_deletable == 'no') {
//                    $status = false;
//                }
//                break;
//            default:
//                $status = true;
//                break;
//        }
        //if ($status && Auth::user()->role_id != 3 && !$hide_status_btn) { Bkesh: updated on june 7 Tuesday. so that client user can also have access to status action
        if ($status  && !$hide_status_btn) {
            echo ' <a title="' . $title . '" onclick="changeStatus(\'#' . $data->$field_id . '\', \'' . $status_url . '\')" id="' . $data->$field_id . '" class="btn ' . $class . '" href="javascript:void(0)"><i class="fa fa-circle fa-fw"></i></a> ';
        }
    }
}
if (substr($permissions, 3, 1) == 'V' || $permissions == 'V') {
    $edit_url = config('site.admin') . $module . '/' . $data->$field_id;
    echo ' <a title="View  ' . $item . ' Data" href="' . $edit_url . '" class="btn btn-primary btn-xs">
            <i class="fa fa-eye fa-fw"></i>
        </a>';
}

if ($module == 'package') {
    echo '<a href = "' . $slide . $data->$field_id . '" class = "delete-row" title = "" data-original-title = "Manage Package Images" ><i class = "fa fa-eye tooltips" data-original-title = "Manage Banners ' . $item . '"></i></a>';
}
    
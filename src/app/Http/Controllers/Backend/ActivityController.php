<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Activity;
use Auth;

class ActivityController extends Controller {

    use FileUploadTrait;

    protected $fields = [];
    protected $model;
    protected $img_folder;
    protected $module = 'activity';
    protected $page_title = 'Activity Management';
    protected $item = 'Activity';
    protected $field_id = 'id';
    protected $has_elfinder = true;
    protected $apply_datatable = false;

    function __construct() {
        $model = new Activity;
        $this->fields = $model->getFillable();
        $this->model = $model;
        $this->img_folder = $model->img_folder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $per_page = 20;
        $data = $this->essentials();
        $data['fields'] = array('SN', 'User Id', 'User Role', 'Action', 'Module', 'Module Id', 'IP Address', 'Date');
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $sn = ($page != 1) ? (($page - 1) * $per_page + 1) : 1;
        $data['sn'] = $sn;
        $data['permissions'] = 'XXX';
//        <--->
        $data['datas'] = Activity::orderBy('id','desc')->select('id', 'user_id', 'user_role', 'action', 'module', 'module_id', 'ip_address','created_at')->paginate($per_page);
        return view('backend.activity.activity_list', $data);
    }

}

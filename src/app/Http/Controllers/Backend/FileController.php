<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Module;

class FileController extends Controller {

    protected $fields = [
        'name' => '',
        'content' => '',
        'ordering' => '1',
    ];
    protected $table = 'files';
    protected $module = 'file';
    protected $page_title = 'File Manager';
    protected $item = 'file';
    protected $img_folder = 'file';
    protected $page_icon = 'fa-hand-o-right';
    protected $nav = 'file';
    protected $parent_nav = '';
    protected $field_id = 'id';

    function __construct() {
        
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data = $this->essentials();
//        return view('vendor.elfinder.standalonepopup', $data);;
        return view('backend.file_manager.file_manager', $data);
        ;
    }

}

<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Inquiry;
use Auth;

class InquiryController extends Controller {

    use FileUploadTrait;

    protected $fields = [];
    protected $model;
    protected $img_folder;
    protected $module = 'inquiry';
    protected $page_title = 'Inquiry Management';
    protected $item = 'Inquiry';
    protected $field_id = 'id';
    protected $has_elfinder = true;
    protected $has_ckeditor = true;

    function __construct() {
        $model = new Inquiry;
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
        $data = $this->essentials();
        $data['button'] = 'Add New ' . $this->item;
//        $data['button_action'] = config('site.admin') . $this->module . '/create';
        $data['fields'] = array('SN', 'Name', 'Email', 'Phone', 'Sent Date','Date');
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $sn = ($page != 1) ? (($page - 1) * config('site.per_page') + 1) : 1;
        $data['sn'] = $sn;
        $data['permissions'] = 'XDXV';
//        <--->
        $data['datas'] = Inquiry::orderBy('id')->select('id', 'name', 'email', 'phone','created_at')->paginate(config('site.per_page'));
        return view('backend.partials._list', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = $this->essentials();
        $data['record'] = $d = Inquiry::findorfail($id);
        $data['panel_title'] = 'View ' . $this->item . ' Details form: ' . $d->name. ' on date: ' . $d->created_at;
        return view('backend.partials._show', $data);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $record = Inquiry::findorfail($id);
        $record->delete();
        return redirect()->back()->withSuccess($this->item . ' is successfully deleted');
    }

}

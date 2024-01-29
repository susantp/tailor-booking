<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Guide;
use App\Models\Activity;
use Auth;

class GuideController extends Controller {

    use FileUploadTrait;

    protected $fields = [];
    protected $model;
    protected $img_folder;
    protected $module = 'guide';
    protected $page_title = 'Guides';
    protected $item = 'Guide';
    protected $field_id = 'id';
    protected $has_elfinder = true;
    protected $has_ckeditor = true;

    function __construct() {
        $model = new Guide;
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
        $data['button_action'] = config('site.admin') . $this->module . '/create';
        $data['fields'] = array('SN', 'Name', 'Image Preview', 'Is Featured', 'Ordering', 'Action');
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $sn = ($page != 1) ? (($page - 1) * config('site.per_page') + 1) : 1;
        $data['sn'] = $sn;
        $data['permissions'] = 'EDS';
//        <--->
        $data['datas'] = Guide::orderBy('id')->select('id', 'name', 'image', 'featured', 'ordering', 'status')->paginate(config('site.per_page'));
        return view('backend.partials._list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = $this->essentials();
        //#  <--->
        $values = array();
        foreach ($this->fields as $field) {
            $values[$field] = '';
        }
        $data['value'] = $values;
        //# form elements >>
        $form['action'] = 'shell/' . $this->module;
        $form['label'] = $data['panel_title'] = 'Create ' . $this->item;
        $form['attribute'] = '';
        $form['fields'] = $this->model->form_builder_array($values);
        $data['form'] = form_builder($form, $this->module);
        //# form elements <<
        return view('backend.partials._form', $data);
    }

    /**
     * Runs the validation
     * @param type $request
     */
    public function validateForm($request) {
        $this->validate($request, [
            'name' => 'required',
            'ordering' => 'required|integer'
                ], [
            'name' => 'The name field is required',
            'ordering.integer' => 'The order must be integer'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validateForm($request);
        $record = new Guide;
        $record->fill($request->all());
        $record->created_by = Auth::user()->id;
        $record->slug = str_slug($request->get('name'));
        $record->save();
        Activity::log(['action' => 'Create', 'module' => $this->module, 'module_id' => $record->id,]);
        return $this->redirect($request->get('save_only'), $request->get('save_new'), $record->id);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = $this->essentials();
        $data['isEdit'] = TRUE;
//        <--->
        $record = Guide::findorfail($id);
        $values['id'] = $id;
        foreach (($this->fields) as $field) {
            $values[$field] = old($field, $record->$field);
        }
        $data['value'] = $values;
        //# form elements >>
        $form['action'] = 'shell/' . $this->module . '/' . $id;
        $form['method'] = 'PUT';
        $form['label'] = $data['panel_title'] = 'Edit' . $this->item;
        $form['attribute'] = '';
        $form['fields'] = $this->model->form_builder_array($values);
        $data['form'] = form_builder($form, $this->module);
        //# form elements <<
        return view('backend.partials._form', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validateForm($request);
        $record = Guide::findorfail($id);
        $record->fill($request->all());
        $record->updated_by = Auth::user()->id;
        $record->slug = str_slug($request->get('name'));
        $record->save();
        Activity::log(['action' => 'Update', 'module' => $this->module, 'module_id' => $id,]);
        return $this->redirect($request->get('save_only'), $request->get('save_new'), $id, 'updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $record = Guide::findorfail($id);
        $record->delete();
        return redirect()->back()->withSuccess($this->item . ' is successfully deleted');
    }

    /**
     * updates the status field in table
     * @param type $id
     * @param type $status
     */
    public function changeStatus($id, $status) {
        $new_status = ($status == 1) ? 0 : $stat = 1;
        $record = Guide::findorfail($id);
        $record->status = $new_status;
        $record->save();
        echo $new_status;
    }

}

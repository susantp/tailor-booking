<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Activity;

class ModuleController extends Controller {

    protected $model;
    protected $fields = [
        'name' => '',
        'slug' => '',
        'parent_id' => '',
        'icon_class' => '',
        'show_in_navigation' => '1',
        'social' => '',
        'ordering' => '1',
    ];
    protected $module = 'module';
    protected $page_title = 'Module Manager';
    protected $item = 'Module';
    protected $field_id = 'id';

    function __construct() {
        $model = new Module;
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
        $data['edit'] = config('site.admin') . $this->module . '/edit/';
        $data['delete'] = config('site.admin') . $this->module . '/delete/';
        $data['fields'] = array('SN', 'Module Name', 'Show In Navigation', 'Ordering', 'Action');
        $data['permissions'] = 'ED';
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $sn = ($page != 1) ? (($page - 1) * config('site.per_page') + 1) : 1;
        $data['sn'] = $sn;
//        <--->
        $data['datas'] = Module::orderBy('ordering')->select('id', 'name','show_in_navigation', 'ordering','status')->paginate(config('site.per_page'));
//        return view('backend.' . $this->module . '.' . $this->module . '_list', $data);
        return view('backend.partials._list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = $this->essentials();
        //#  <--->
        $values = array();
        foreach ($this->fields as $field => $default) {
            $values[$field] = old($field, $default);
        }
        $data['value'] = $values;
        //# form elements >>
        $form['action'] = 'shell/' . $this->module;
        $form['label'] = $data['panel_title'] = 'Create ' . $this->item;
        $form['purpose'] = 'Create';
        $form['attribute'] = '';
        $form['fields'] = $this->model->form_builder_array($values);
        $data['form'] = form_builder($form, $this->module);
        $data['jsfile'] = 'module';
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
        $record = new Module;
        $record->fill($request->all());
        $record->parent_id = $record->parent_id == '' ? 0 : $record->parent_id;
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
        $record = Module::findorfail($id);
        $values['id'] = $id;
        foreach (($this->fields) as $field) {
            $values[$field] = old($field, $record->$field);
        }
        $data['value'] = $values;
        //# form elements >>
        $form['action'] = 'shell/' . $this->module . '/' . $id;
        $form['method'] = 'PUT';
        $form['label'] = $data['panel_title'] = 'Edit' . $this->item;
        $form['purpose'] = 'Update';
        $form['attribute'] = '';
        $data['jsfile'] = 'module';
        $form['fields'] = $this->model->form_builder_array($values, true);
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
        $record = Module::findorfail($id);
        $record->fill($request->all());
        $record->parent_id = $record->parent_id == '' ? 0 : $record->parent_id;
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
        $record = Module::findorfail($id);
        $record->delete();
        return redirect(config('site.admin') . $this->module)->withSuccess($this->item . ' is successfully deleted.');
    }

    /**
     * updates the status field in table
     * @param type $id
     * @param type $status
     */
    public function changeStatus($id, $status) {
        $new_status = ($status == 1) ? 0 : $stat = 1;
        $record = Module::findorfail($id);
        $record->status = $new_status;
        $record->save();
        echo $new_status;
    }

}

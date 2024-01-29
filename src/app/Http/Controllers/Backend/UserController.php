<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Activity;
use Hash;

class UserController extends Controller {

    protected $fields = [
        'name' => '',
        'email' => '',
        'password' => '',
        'role_id' => '',
        'customer_code' => '',
        'country' => '',
        'address' => '',
        'contact' => '',
    ];
    protected $model;
    protected $module = 'user';
    protected $page_title = 'User Management';
    protected $item = 'User';
    protected $field_id = 'id';
    protected $jsfile = 'user';

    function __construct() {
        $model = new User;
        $this->fields = $model->getFillable();
        $this->model = $model;
        $this->img_folder = $model->img_folder;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data = $this->essentials();
        $data['button'] = 'Add New ' . $this->item;
        $data['button_action'] = config('site.admin') . $this->module . '/create';
        $data['edit'] = config('site.admin') . $this->module . '/edit/';
        $data['delete'] = config('site.admin') . $this->module . '/delete/';
        $data['fields'] = array('SN', 'Name', 'Role', 'Action');
        $data['permissions'] = 'EDS';
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $sn = ($page != 1) ? (($page - 1) * config('site.per_page') + 1) : 1;
        $data['sn'] = $sn;
//        <--->
        $result = User::orderBy('id')->select('*')->where('id','<>','1')->paginate(config('site.per_page'));
        $data['datas'] = $d = $this->model->suffle($result);
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
        foreach ($this->fields as $field => $default) {
            $values[$field] = old($field, $default);
        }
        $data['value'] = $values;
        //# form elements >>
        $form['action'] = 'shell/' . $this->module;
        $form['label'] = $data['panel_title'] = 'Create ' . $this->item;
        $form['purpose'] = 'Create';
        $form['attribute'] = '';
        $form['fields'] = $this->model->form_builder_array();
        $data['form'] = form_builder($form, $this->module);
        //# form elements <<
        return view('backend.partials._form', $data);
    }

    /**
     * Runs the validation
     * @param type $request
     */
    public function validateForm($request, $id = '') {
        if ($request->get('new_password') == '') {
            $this->validate($request, [
                'role_id' => 'required',
                'name' => 'required|regex:/^[\pL\s\-]+$/u|max:100',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                    ], [
                'name' => 'The name field is required',
                'name.regex' => 'The name may only contain letters and spaces.',
            ]);
        } else {
            $this->validate($request, [
                'role_id' => 'required',
                'name' => 'required|regex:/^[\pL\s\-]+$/u|max:100',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'new_password' => 'required|min:5|confirmed',
                    ], [
                'name' => 'The name field is required',
                'name.regex' => 'The name may only contain letters and spaces.',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validateForm($request);
        $record = new User;
        $record->fill($request->all());
//        $record->password = bcrypt($request->get('name') . 'hellohhh');  //# for ref
        $record->password = Hash::make(str_replace(' ', '', $request->get('name')) . 'hellohhh');
        $record->status = 1;
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
        $record = User::findorfail($id);
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
        $form['fields'] = $this->model->form_builder_array($values);
        $data['form'] = form_builder($form, $this->module, 'edit');
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
//        pr(Hash::make($request->get('new_password')));
        $this->validateForm($request, $id);
        $record = User::findorfail($id);
        $record->fill($request->all());
        if ($request->get('new_password') == '') {
            unset($record->password);
        } else {
            $record->password = Hash::make($request->get('new_password'));
        }
//        pr($record);
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
        $record = User::findorfail($id);
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
        $record = User::findorfail($id);
        $record->status = $new_status;
        $record->save();
        echo $new_status;
    }

}

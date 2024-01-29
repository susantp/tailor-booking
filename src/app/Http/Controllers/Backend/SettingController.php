<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingController extends Controller {

    protected $model;
    protected $module = 'setting';
    protected $page_title = 'Setting Management';
    protected $item = 'setting';
    protected $field_id = 'id';

    function __construct() {
        $model = new Setting;
        $this->fields = $model->getFillable();
        $this->model = $model;
        $this->img_folder = $model->img_folder;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return $this->edit();
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        $id = 1;
        $data = $this->essentials();
        $data['isEdit'] = TRUE;
//        <--->
        $record = Setting::findorfail($id);
        //# form elements >>
        $form['action'] = 'shell/' . $this->module . '/' . $id;
        $form['method'] = 'PUT';
        $form['label'] = $data['panel_title'] = 'Site Configuration';
        $form['purpose'] = 'Update';
        $form['attribute'] = '';
        $form['save_single'] = true;
        $form['fields'] = $this->model->form_builder_array($record);
        $data['form'] = form_builder($form, $this->module);
        $data['save_single'] = true;
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
        $record = Setting::findorfail($id);
        $record->fill($request->all());
        $record->save();
        return redirect(config('site.admin') . $this->module)->withSuccess($this->item . ' is successfully updated, ');
    }

}

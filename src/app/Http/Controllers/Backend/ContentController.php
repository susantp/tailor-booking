<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Content;
use App\Models\Activity;

class ContentController extends Controller {

    use FileUploadTrait;

    protected $fields = [];
    protected $model;
    protected $img_folder;
    protected $module = 'content';
    protected $page_title = 'Content Management';
    protected $item = 'Content';
    protected $field_id = 'id';
    protected $has_ckeditor = true;

    function __construct() {
        $model = new Content;
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
        $data['fields'] = array('SN', 'Name', 'Category', 'Action');
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $sn = ($page != 1) ? (($page - 1) * config('site.per_page') + 1) : 1;
        $data['sn'] = $sn;
        $data['permissions'] = 'ED';
//        <--->
        $result = Content::orderBy('id')->select('*')->paginate(config('site.per_page'));
        $data['datas'] = $d = $this->model->suffle($result);
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
//        pr($values);
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
                ], [
            'name' => 'The name field is required',
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
        $record = new Content;
        $record->fill($request->all());
        //for image >>
//        $upload = $this->saveFiles($request, 'image', 'image');
//        $iMsg = 'with selected image.';
//        if ($upload['success'] == 1) {
//            $record->image = $upload['msg'];
//        } else {
//            // $iMsg = $upload['msg'];
//            $record->image = '';
//        }
        //for image <<
        $record->slug = str_slug($request->get('name'));
        $record->save();
        Activity::log(['action' => 'Create', 'module' => $this->module, 'module_id' => $record->id,]);
        return $this->redirect($request->get('save_only'), $request->get('save_new'), $record->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = $this->essentials();
        $data['isEdit'] = TRUE;
//        <--->
        $record = Content::findorfail($id);
        $values['id'] = $id;
        foreach (($this->fields) as $field) {
            $values[$field] = old($field, $record->$field);
        }
//        $imgname = $values['image'];
//        $img = $this->getDisplayImage($imgname);
//        $data['img'] = $img;
        $data['value'] = $values;
//        pr($values);
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
        $record = Content::findorfail($id);
        $record->fill($request->all());
        //for image >>
//        $old_image = $request->get('old_img');
//        $upload = $this->saveFiles($request, 'image', 'image', $old_image);
//        $iMsg = 'with selected image.';
//        if ($upload['success'] == 1) {
//            $record->image = $upload['msg'];
//        } else {
//            $record->image = $old_image;
//            // $iMsg = $upload['msg'];
//        }
        //for image <<
        $record->slug = str_slug($request->get('name'));
        $record->save();
        Activity::log(['action' => 'Update', 'module' => $this->module, 'module_id' => $id,]);
        return $this->redirect($request->get('save_only'), $request->get('save_new'), $id, 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $record = Content::findorfail($id);
        //delete images>>
//        $old_image = $record['image'];
//        $this->deleteOldImage($old_image);
        //delete images<<
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
        $record = Content::findorfail($id);
        $record->status = $new_status;
        $record->save();
        echo $new_status;
    }

}

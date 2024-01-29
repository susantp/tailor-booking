<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Gallery;
use App\Models\Activity;
use App\Models\GalleryImage;
use Auth;

class GalleryController extends Controller {

    use FileUploadTrait;

    protected $fields = [];
    protected $model;
    protected $img_folder;
    protected $module = 'gallery';
    protected $page_title = 'Gallery Management';
    protected $item = 'Gallery';
    protected $field_id = 'id';
//    protected $has_ckeditor = true;
    protected $has_elfinder = true;
    protected $jsfile = 'gallery';

    function __construct() {
        $model = new Gallery;
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
        $data['fields'] = array('SN', 'Name', 'image', 'ordering', 'Action');
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $sn = ($page != 1) ? (($page - 1) * config('site.per_page') + 1) : 1;
        $data['sn'] = $sn;
        $data['permissions'] = 'EDS';
//        <--->
        $data['datas'] = Gallery::orderBy('gallery_ordering')->select('id', 'gallery_name', 'cover_image', 'gallery_ordering', 'status')->paginate(config('site.per_page'));
//        return view('backend.' . $this->module . '.' . $this->module . '_list', $data);
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
        $form['purpose'] = 'Create';
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
            'gallery_name' => 'required',
            'name.*' => 'required|integer',
            'ordering.*' => 'required|integer',
            'gallery_ordering' => 'required|integer'
                ], [
            'gallery_name' => 'The name field is required',
            'name.*integer' => 'The image title  is required',
            'ordering.*.integer' => 'The image order must be integer',
            'gallery_ordering.integer' => 'The order must be integer'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        session(['post_images' => $request->all()]);
        $this->validateForm($request);
        $record = new Gallery;
        $record->fill($request->all());
        $record->slug = str_slug($request->get('gallery_name'));
        $record->save();
//# save images       
        $images = $request->get('image');
        $title = $request->get('title');
        $ordering = $request->get('ordering');
        $content = $request->get('content');
        foreach ($images as $k => $v) {
            $record_images = new GalleryImage;
            $record_images->gid = $record->id;
            $record_images->image = $v;
            $record_images->title = isset($title) ? $title[$k] : '';
            $record_images->ordering = isset($ordering) ? $ordering[$k] : '';
            $record_images->content = isset($content) ? $content[$k] : '';
//            pr($record_images);
            $record_images->save();
        }
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
        $record = Gallery::findorfail($id);
        $values['id'] = $id;
//        pr($record->images);
        foreach (($this->fields) as $field) {
            $values[$field] = old($field, $record->$field);
        }
        $data['value'] = $values;
        //# form elements >>
        $form['action'] = 'shell/' . $this->module . '/' . $id;
        $form['method'] = 'PUT';
        $form['label'] = $data['panel_title'] = 'Edit' . $this->item;
        $form['attribute'] = '';
        $form['fields'] = $this->model->form_builder_array($values, $record->images);
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
        session(['post_images' => $request->all()]);
        $this->validateForm($request);
        $record = Gallery::findorfail($id);
        $record->fill($request->all());
        $record->updated_by = Auth::user()->id;
        $record->save();
        //# save images       
        $images = $request->get('image');
        $title = $request->get('title');
        $ordering = $request->get('ordering');
        $content = $request->get('content');
        GalleryImage::where('gid', '=', $id)->delete();
        foreach ($images as $k => $v) {
            $record_images = new GalleryImage;
            $record_images->gid = $record->id;
            $record_images->image = $v;
            $record_images->title = isset($title) ? $title[$k] : '';
            $record_images->ordering = isset($ordering) ? $ordering[$k] : '';
            $record_images->content = isset($content) ? $content[$k] : '';
//            pr($record_images);
            $record_images->save();
        }
        Activity::log(['action' => 'Update', 'module' => $this->module, 'module_id' => $id,]);
        return $this->redirect($request->get('save_only'), $request->get('save_new'), $id, 'updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $record = Gallery::findorfail($id);
        $record->delete();
        GalleryImage::where('gid', '=', $id)->delete();
        return redirect()->back()->withSuccess($this->item . ' is successfully deleted');
    }

    /**
     * updates the status field in table
     * @param type $id
     * @param type $status
     */
    public function changeStatus($id, $status) {
        $new_status = ($status == 1) ? 0 : $stat = 1;
        $record = Gallery::findorfail($id);
        $record->status = $new_status;
        $record->save();
        echo $new_status;
    }

}

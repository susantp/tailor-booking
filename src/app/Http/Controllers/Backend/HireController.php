<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Hire;
use App\Models\Activity;
use App\Models\HireImage;
use Auth;

class HireController extends Controller {

    use FileUploadTrait;

    protected $fields = [];
    protected $model;
    protected $img_folder;
    protected $module = 'hire';
    protected $page_title = 'Hire Product Management';
    protected $item = 'Hire';
    protected $field_id = 'id';
    protected $has_ckeditor = true;
    protected $has_elfinder = true;

//    protected $jsfile = 'gallery';

    function __construct() {
        $model = new Hire;
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
        $data['fields'] = array('SN', 'Name', 'Price', 'Category',  'Ordering', 'Action');
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $sn = ($page != 1) ? (($page - 1) * config('site.per_page') + 1) : 1;
        $data['sn'] = $sn;
        $data['permissions'] = 'EDS';
//        <--->
        $result = Hire::orderBy('acc_ordering')->select('*')->paginate(config('site.per_page'));
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
        foreach ($this->fields as $field) {
            $values[$field] = '';
        }
        $data['value'] = $values;
//# form elements >>
        $form['action'] = 'shell/' . $this->module;
        $form['label'] = $data['panel_title'] = 'Create ' . $this->item;
        $form['purpose'] = 'Create ';
        $form['attribute'] = '';
        $form['fields'] = $this->model->form_builder_array($values);
        $data['form'] = form_builder($form, $this->module);
//# form elements <<
        $data['jsfile'] = ['gallery', 'hire'];
        return view('backend.partials._form', $data);
    }

    /**
     * Runs the validation
     * @param type $request
     */
    public function validateForm($request) {
        $this->validate($request, [
            'name' => 'required|max:255',
            'title.*' => 'required|max:255',
            'ordering.*' => 'required|integer',
            'acc_ordering' => 'required|integer'
                ], [
            'name' => 'The name field is required',
            'title.*' => 'The image title  is required',
            'ordering.*.integer' => 'The image order must be integer',
            'acc_ordering.integer' => 'The order must be integer'
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
        $record = new Hire;
        $record->fill($request->all());
        $record->slug = str_slug($request->get('name'));
//        $record->opening_hours = json_encode($request->get('opening_hours'));
        $record->save();
//# save images       
        $images = $request->get('image');
        $title = $request->get('title');
        $ordering = $request->get('ordering');
        $content = $request->get('content');
        foreach ($images as $k => $v) {
            $record_images = new HireImage;
            $record_images->aid = $record->id;
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
        $record = Hire::findorfail($id);
        $values['id'] = $id;
//        pr($record->images);
        foreach (($this->fields) as $field) {
            $values[$field] = old($field, $record->$field);
        }
        $data['value'] = $values;
        //# form elements >>
        $form['action'] = 'shell/' . $this->module . '/' . $id;
        $form['method'] = 'PUT';
        $form['label'] = $data['panel_title'] = 'Edit ' . $this->item;
        $form['attribute'] = '';
        $template_data = ['images' => $record->images, 'opening_hours' => $record->opening_hours];
        $form['fields'] = $this->model->form_builder_array($values, $template_data);
        $data['form'] = form_builder($form, $this->module);
//        pr($form);
        //# form elements <<
        $data['jsfile'] = ['gallery', 'hire'];
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
//        pr(json_encode($request->get('oh')));
        $this->validateForm($request);
        $record = Hire::findorfail($id);
        $record->fill($request->all());
        $record->updated_by = Auth::user()->id;
        $record->slug = str_slug($request->get('name'));
//        $record->opening_hours = json_encode($request->get('opening_hours'));
        $record->save();
        //# save images       
        $images = $request->get('image');
        $title = $request->get('title');
        $ordering = $request->get('ordering');
        $content = $request->get('content');
        HireImage::where('aid', '=', $id)->delete();
        foreach ($images as $k => $v) {
            $record_images = new HireImage;
            $record_images->aid = $record->id;
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
        $record = Hire::findorfail($id);
        $record->delete();
        HireImage::where('aid', '=', $id)->delete();
        return redirect()->back()->withSuccess($this->item . ' is successfully deleted');
    }

    /**
     * updates the status field in table
     * @param type $id
     * @param type $status
     */
    public function changeStatus($id, $status) {
        $new_status = ($status == 1) ? 0 : $stat = 1;
        $record = Hire::findorfail($id);
        $record->status = $new_status;
        $record->save();
        echo $new_status;
    }

    public function getParentLocationDrop(Request $request) {
        $post = $request->all();
        $category_type = $post['selected_type'];
//        $cd = Category::get
        $types = $this->model->get_parent_location_for_dropdown($category_type);

        $html = '<select class="form-control" name="category_id" id="category_id">';
        foreach ($types as $k => $v) {
            $html .= '<option value="' . $k . '">' . $v . '</option>';
        }
        //echo $html;
        $reponse = array(
            'html' => $html
        );
        echo json_encode($reponse);
    }

    public function getLocationDrop(Request $request) {
        $post = $request->all();
        $category_type = $post['selected_type'];
//        $cd = Category::get
        $types = $this->model->get_location_for_dropdown($category_type);

        $html = '<select class="form-control" name="category_id" id="category_id">';
        foreach ($types as $k => $v) {
            $html .= '<option value="' . $k . '">' . $v . '</option>';
        }
        //echo $html;
        $reponse = array(
            'html' => $html
        );
        echo json_encode($reponse);
    }

}

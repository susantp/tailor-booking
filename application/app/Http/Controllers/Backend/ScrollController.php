<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Scroll;
use App\Models\Category;
use App\Models\Activity;
use App\Models\Retail;
use App\Models\Hire;
use App\Models\Brand;
use Auth;

class ScrollController extends Controller {

    use FileUploadTrait;

    protected $fields = [];
    protected $model;
    protected $img_folder;
    protected $module = 'scroll';
    protected $page_title = 'Scroll Management';
    protected $item = 'Scroll';
    protected $field_id = 'id';
//    protected $has_ckeditor = true;
    protected $has_elfinder = true;

    function __construct() {
        $model = new Scroll;
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
        $data['fields'] = array('SN', 'Product', 'Type','Ordering', 'Action');
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $sn = ($page != 1) ? (($page - 1) * config('site.per_page') + 1) : 1;
        $data['sn'] = $sn;
        $data['permissions'] = 'D';
//        <--->

        $result = Category::tree();
        $result = Scroll::orderBy('created_at', 'Desc')->select('*')->paginate(config('site.per_page'));
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
        $form['attribute'] = '';
        $form['fields'] = $this->model->form_builder_array($values);
        $data['form'] = form_builder($form, $this->module);
        //# form elements <<
        $data['jsfile'] = 'scroll';
        return view('backend.partials._form', $data);
    }

    /**
     * Runs the validation
     * @param type $request
     */
    public function validateForm($request, $i = '') {
        //$edit = $i ? ',category_name,' . $i : '';
        $this->validate($request, [
            'product_id' => 'required',
            'type_id' => 'required',
                ], [
            'product_id' => 'The name field is required',
            'type_id' => 'The type field is required',
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
        $record = new Scroll;
        //dd($request->all());
        $record->fill($request->all());

        $type_id=$request->get('type_id');
        if($type_id==2){
            $type='Hire';
        }else if($type_id==3){
            $type='Retail';
        }else{
            $type='Brand';
        } 
        $record->type = $type;
        if($type_id==2){
            $record->product  = Hire::where('id',$request->get('product_id'))->first()->name;

        }else if($type_id==3){
            $record->product  = Retail::where('id',$request->get('product_id'))->first()->name;

        }else{
            $record->product  = Brand::where('id',$request->get('product_id'))->first()->name;

        }

       // $record->product = $type_id==2?'Hire':'Retail';
        $record->created_by = Auth::user()->id;
        //$record->category_slug = str_slug($request->get('category_name'));
       // dd($record);
        $record->save();
       // Activity::log(['action' => 'Create', 'module' => $this->module, 'module_id' => $record->id,]);
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
        $record = Category::findorfail($id);
        $values['id'] = $id;
        foreach (($this->fields) as $field) {
            $values[$field] = old($field, $record->$field);
        }
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
        $data['jsfile'] = 'category';
        return view('backend.partials._form', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validateForm($request, $id);
        $record = Category::findorfail($id);
        $record->fill($request->all());
        $record->updated_by = Auth::user()->id;
        $record->category_slug = str_slug($request->get('category_name'));
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
        $record = Scroll::findorfail($id);
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
        $record = Category::findorfail($id);
        $record->status = $new_status;
        $record->save();
        echo $new_status;
    }

    public function getProductDrop(Request $request) {
        $post = $request->all();
        $category_type = $post['selected_type'];
//        $cd = Category::get
        $types = $this->model->get_product_for_dropdown($category_type);

        $html = '<select class="form-control" name="product_id" id="product_id">';
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

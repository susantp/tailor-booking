<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Category;
use App\Models\Activity;
use Auth;

class CategoryController extends Controller {

    use FileUploadTrait;

    protected $fields = [];
    protected $model;
    protected $img_folder;
    protected $module = 'category';
    protected $page_title = 'Category Management';
    protected $item = 'Category';
    protected $field_id = 'id';
//    protected $has_ckeditor = true;
    protected $has_elfinder = true;

    function __construct() {
        $model = new Category;
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
        $data['permissions'] = 'EDS';
//        <--->

        $result = Category::tree();
        $data['datas'] = $d = $this->model->suffle($result);
//        $result = Category::orderBy('id')->select('*')->paginate(config('site.per_page'));
//        $data['datas'] = $d = $this->model->suffle($result);
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
        $data['jsfile'] = 'category';
        return view('backend.partials._form', $data);
    }

    /**
     * Runs the validation
     * @param type $request
     */
    public function validateForm($request, $i = '') {
        $edit = $i ? ',category_name,' . $i : '';
        $this->validate($request, [
            'category_name' => 'required|unique:categories' . $edit,
            'type' => 'required',
                ], [
            'category_name' => 'The name field is required',
            'type' => 'The catebory type field is required',
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
        $record = new Category;
//        dd($request->all());
        $record->fill($request->all());
        $record->created_by = Auth::user()->id;
        $record->category_slug = str_slug($request->get('category_name'));
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
        $record = Category::findorfail($id);
        //# check if category is used in other modules before deleting
        $can_be_deleted = true;
        $p = Category::where('parent_id', $id)->count();
        if ($p > 0) {
            $can_be_deleted = false;
        } else if ($record->type == 1) {
            $q = \App\Models\Content::where('category_id', $id)->count();
            if ($q > 0) {
                $can_be_deleted = false;
            }
        } else if ($record->type == 2) {
            $q = \App\Models\Hire::where('location_id', $id)->count();
            if ($q > 0) {
                $can_be_deleted = false;
            }
        } else if ($record->type == 3) {
            $q = \App\Models\Retail::where('category_id', $id)->count();
            if ($q > 0) {
                $can_be_deleted = false;
            }
        } else if ($record->type == 4) {
            $q = \App\Models\Brand::where('category_id', $id)->count();
            if ($q > 0) {
                $can_be_deleted = false;
            }
        }
        if ($can_be_deleted) {
//            dd('deleted');
//            exit;
            $record->delete();
            return redirect()->back()->withSuccess($this->item . ' is successfully deleted');
        } else {
            return redirect()->back()->withErrors($this->item . ' cannot be deleted, It is in use.');
        }
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

    public function getCategoryDrop(Request $request) {
        $post = $request->all();
        $category_type = $post['selected_type'];
//        $cd = Category::get
        $types = $this->model->get_category_for_dropdown($category_type);

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

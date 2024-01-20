<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Content;
use App\Models\Activity;

class MenuController extends Controller {

    use FileUploadTrait;

    protected $fields = [];
    protected $model;
    protected $img_folder;
    protected $menu_link_types;
    protected $menu_types;
    protected $module = 'menu';
    protected $page_title = 'Menu Management';
    protected $item = 'Menu';
    protected $field_id = 'id';

    function __construct() {
        $model = new Menu;
        $this->fields = $model->getFillable();
        $this->model = $model;
        $this->img_folder = $model->img_folder;
        $this->menu_link_types = $model->menu_link_types;
        $this->menu_types = $model->menu_types;
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
        $data['fields'] = array('SN', 'Menu Name', 'Menu Type','Ordering', 'Action');
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $sn = ($page != 1) ? (($page - 1) * config('site.per_page') + 1) : 1;
        $data['sn'] = $sn;
        $data['permissions'] = 'EDS';
//        <--->
        $result = Menu::tree();
        
//        dd($result);
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
        $data['menu_link_types'] = $this->menu_link_types;
        $data['menu_types'] = $this->menu_types;
        $values = array();
        foreach ($this->fields as $field) {
            $values[$field] = '';
        }
        $data['value'] = $values;
        $select = Menu::tree();
        $data['menu_parents'] = make_select_option_tree($select, 'id', 'name', 'Parent menu');
        $content = Category::where(['status' => '1', 'type' => '1'])->orderBy('id')->get();
        $data['content_category'] = make_select_option_tree($content, 'id', 'category_name', 'Category');
        //# form elements >>
        $form['action'] = 'shell/' . $this->module;
        $form['label'] = $data['panel_title'] = 'Create ' . $this->item;
        $form['attribute'] = '';
        $data['form'] = $form;
        $data['jsfile'] = 'menu';
        //# form elements <<
        return view('backend.menu._form', $data);
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
        $record = new Menu;
        $record->fill($request->all());
        $record->parent_id=$request->get('parent_id')?$request->get('parent_id'):0;
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
        $data['menu_link_types'] = $this->menu_link_types;
        $data['menu_types'] = $this->menu_types;
//        <--->
        $record = Menu::findorfail($id);
        $values['id'] = $id;
        foreach (($this->fields) as $field) {
            $values[$field] = old($field, $record->$field);
        }
        $data['value'] = $values;
        $select = Menu::tree($id);
        $data['menu_parents'] = make_select_option_tree($select, 'id', 'name', 'Parent menu');
        $content = Category::where(['status' => '1', 'type' => '1'])->orderBy('id')->get();
        $data['content_category'] = make_select_option_tree($content, 'id', 'category_name', 'Category');
        //# form elements >>
        $form['action'] = 'shell/' . $this->module . '/' . $id;
        $form['method'] = 'PUT';
        $form['label'] = $data['panel_title'] = 'Edit' . $this->item;
        $form['attribute'] = '';
        $data['form'] = $form;
        //# form elements <<
        $data['jsfile'] = 'menu';
        return view('backend.menu._form', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validateForm($request);
        $record = Menu::findorfail($id);
        $record->fill($request->all());
        $record->parent_id=$request->get('parent_id')?$request->get('parent_id'):0;
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
        $record = Menu::findorfail($id);
        $record->delete();
        return redirect()->back()->withSuccess($this->item . ' is successfully deleted');
    }

    /**
     * updates the status field in table
     * @param type $id
     * @param type $status
     */public function changeStatus($id, $status) {
        $new_status = ($status == 1) ? 0 : $stat = 1;
        $record = Menu::findorfail($id);
        $record->status = $new_status;
        $record->save();
        echo $new_status;
    }

    public function check_slug(Request $request) {
        $post = $request->all();
        $slug = $post['slug'];
        $id = $post['id'];
        if (!empty($id)) {
            $condition = [ ['slug', $slug], ['id', '<>', $id]];
        } else {
            $condition = array('slug' => $slug);
        }
        $slug_data = Menu::where($condition)->get();
        if ($slug_data->count()) {
            $has_slug = true;
        } else {
            $has_slug = false;
        }
        $reponse = array(
            'has_slug' => $has_slug
        );
        echo json_encode($reponse);
    }

    public function getContentDrop(Request $request) {
        $post = $request->all();
        $category_id = $post['category_id'];
        $contents = Content::where(array('category_id' => $category_id, 'status' => '1'))->get();
        $html = '<select class="form-control" name="content_id" id="content_id">';
        $html .= '<option value="">Select Content</option>';
        if (!empty($contents)) {
            foreach ($contents as $content) {
                if (isset($post['selected_content'])) {
                    if ($post['selected_content'] == $content['id']) {
                        $selected = 'selected = "selected"';
                    } else {
                        $selected = '';
                    }
                    $html .= '<option ' . $selected . ' value="' . $content['id'] . '">' . $content['name'] . '</option>';
                } else {
                    $html .= '<option value="' . $content['id'] . '">' . $content['name'] . '</option>';
                }
            }
        }
        $html .= '</select>';
        $reponse = array(
            'html' => $html
        );
        echo json_encode($reponse);
    }

    public function getCategoryDrop(Request $request) {
        $post = $request->all();
        $category_id = $post['selected_category'];
        $option_type = $post['menu_link_type_value'];

        $category = Category::where(array('slug' => $option_type, 'status' => '1'))
                        ->select('categories.*', 'category_types.slug')
                        ->leftJoin('category_types', 'category_types.id', '=', 'categories.type')->get();
        $html = '<select class="form-control" name="category_id" id="category_id">';
        $html .= '<option value="">Select Category</option>';
        foreach ($category as $category) {
            if (isset($post['selected_category'])) {
                if ($post['selected_category'] == $category['id']) {
                    $selected = 'selected = "selected"';
                } else {
                    $selected = '';
                }
                $html .= '<option ' . $selected . ' value="' . $category['id'] . '">' . $category['category_name'] . '</option>';
            } else {
                $html .= '<option value="' . $category['id'] . '">' . $category['category_name'] . '</option>';
            }
        }
        //echo $html;
        $reponse = array(
            'html' => $html
        );
        echo json_encode($reponse);
    }

}

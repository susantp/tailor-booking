<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $dateFormat = 'U';
    protected $fillable = [
        'id',
        'parent_id',
        'category_name',
        'type',
        'title',
        'image',
        'description',
        'status',
        'html_keyword',
        'html_description',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public function parents() {
        //originally there is no 's' in above function :: just remainder
        return $this->hasOne(static::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(static::class, 'parent_id');
    }

    public static function tree() {
        return static::with('children')->where('parent_id', 0)->orWhere('parent_id', NULL)->orderBy('id', 'desc')->orderBy('type', 'desc')->get();
    }

    function category_type() {
        return $this->belongsTo('App\Models\Category_type', 'type');
    }

    function sufflex($result) {
        $new_arr = array();
        if ($result) {
            foreach ($result as $k => $v) {
//                pr($v->category_type);
                //# create new array with necessary items only
                $new['id'] = $v->id;
                $new['Category name'] = $v->category_name;
                $new['Type'] = $v->category_type->name;
                $new['status'] = $v->status;
                $new_arr[] = collect($new);
            }
        }
        return collect($new_arr);
    }

    function suffle($result) {
        $new_arr = array();
        if ($result) {
            foreach ($result as $k => $v) {
                //# create new array with necessary items only
                $new['id'] = $v['id'];
                $new['Category name'] = $v->category_name;
                $new['Type'] = $v->category_type->name;
                $new['status'] = $v->status;
                $new_arr[] = collect($new);
                if ($v['children']->count()) {
                    foreach ($v['children'] as $vv) {
                        $new['id'] = $vv['id'];
                        $new['Category name'] = '- ' .$vv->category_name;
                        $new['Type'] = $vv->category_type->name;
                        $new['status'] = $vv->status;
                        $new_arr[] = collect($new);
                    }
                }
            }
        }
        return collect($new_arr);
    }

    function form_builder_array($values = array()) {
        $data = array(
            'group1' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Category Type',
                        'name' => 'type',
                        'type' => 'dropdown',
                        'option' => $this->get_category_type_for_dropdown(),
                        'selected' => $values['type'],
                        'attributes' => array('class' => "selectpicker form-control required"),
                    ),
                    /*array('label' => 'Category Parent',
                        'name' => 'parent_id',
                        'type' => 'dropdown',
                        'option' => $this->get_category_for_dropdown($values['type']),
                        'selected' => $values['parent_id'],
                        'attributes' => array('class' => "selectpicker form-control"),
                        'instruction' => 'Do not choose parent same as the category name itself. EG: Do not choose "Slatters Shoes" as category parent for the category "Slatters Shoes". Just keep it empty',
                    ),*/
                    array('label' => 'Category Name',
                        'name' => 'category_name',
                        'type' => 'text',
                        'value' => $values['category_name'],
                        'class' => 'form-control required',
                    ),
                    array('label' => 'Image',
                        'name' => 'image',
                        'type' => 'image', //# image byb!
                        'value' => $values['image'],
                        'class' => 'form-control',
                        'onclick' => 'BrowseServer(this)',
                        'data-resource-type' => 'image',
                        'data-multiple' => "false",
                        'id' => "menu_icon",
                        'placeholder' => "Banner Image"
                    ),
                    array('label' => 'HTML Keyword',
                        'name' => 'html_keyword',
                        'type' => 'text',
                        'value' => $values['html_keyword'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'HML Description',
                        'name' => 'html_description',
                        'type' => 'textarea',
                        'value' => $values['html_description'],
                        'class' => 'form-control',
                    ),
                ),
            ),
            'group2' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Content Title',
                        'name' => 'title',
                        'type' => 'text',
                        'value' => $values['title'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Content Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'value' => isset($values['description']) ? html_entity_decode($values['description']) : '',
                        'class' => 'form-control',
                        'id' => 'ckeditor',
                    ),
                )
            )
        );
        return $data;
    }

    function get_category_type_for_dropdown() {
        $record = [];
        $data = Category_type::orderBy('id')->get();
        if ($data) {
            $record = make_select_option_tree($data, 'id', 'name', 'Category');
        }
        return $record;
    }

    function get_category_for_dropdown($type_id = 2) {
        $record = [];
        $data = Category::where(['type' => $type_id, 'status' => 1])->where(function($q){
            $q->where('parent_id', 0)->orWhere('parent_id', NULL);
        })->orderBy('ordering', 'asc')->get();
        if ($data) {
            $record = make_select_option_tree($data, 'id', 'category_name', 'Category',FALSE);
        }
        return $record;
    }

}

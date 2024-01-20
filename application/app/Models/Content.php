<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model {

    protected $dateFormat = 'U';
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'status',
        'html_keyword',
        'html_description',
        'created_by',
        'updated_by',
    ];

    function category() {
        return $this->belongsTo('App\Models\Category');
    }

//    public function parents() {
//        //originally there is no 's' in above function :: just remainder
//
//        return $this->hasOne(static::class, 'parent_id');
//    }
//
//    public function children() {
//
//        return $this->hasMany(static::class, 'parent_id');
//    }
//
//    public static function tree() {
////    return static::with(implode('.', array_fill(0, 100, 'children')))->where('parent_id', '=', NULL)->get();
//        return static::with('children')->where('parent_id', 0)->orderBy('ordering')->get();
//    }



    function suffle($result) {
        $new_arr = array();
        if ($result) {
            foreach ($result as $k => $v) {
                //# create new array with necessary items only
                $new['id'] = $v->id;
                $new['name'] = $v->name;
                $new['category'] = $v->category->category_name;
                $new['status'] = $v->status;
                $new_arr[] = collect($new);
            }
        }
        return collect($new_arr);
    }

    function form_builder_array($values = array()) {
        $data = array(
            'group1' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Category',
                        'name' => 'category_id',
                        'type' => 'dropdown',
                        'option' => $this->get_category_for_dropdown(),
                        'selected' => isset($values['category_id']) ? $values['category_id'] : '',
                        'attributes' => array('class' => "selectpicker form-control required"),
                    ),
                    array('label' => 'Content Title',
                        'name' => 'name',
                        'type' => 'text',
                        'value' => isset($values['name']) ? $values['name'] : '',
                        'class' => 'form-control required',
                    ),

                    array('label' => 'HTML Keyword',
                        'name' => 'html_keyword',
                        'type' => 'text',
                        'value' => isset($values['html_keyword']) ? $values['html_keyword'] : '',
                        'class' => 'form-control',
                    ),
                    array('label' => 'HML Description',
                        'name' => 'html_description',
                        'type' => 'textarea',
                        'value' => isset($values['html_description']) ? $values['html_description'] : '',
                        'class' => 'form-control',
                    ),
//                    array('label' => 'Short Description',
//                        'name' => 'short_description',
//                        'type' => 'textarea',
//                        'value' => isset($values['short_description']) ? html_entity_decode($values['short_description']) : '',
//                        'class' => 'form-control',
//                    ),
                ),
            ),
            'group2' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'value' => isset($values['description']) ? html_entity_decode($values['description']) : '',
                        'class' => 'form-control required',
                        'id' => 'ckeditor',
                    ),
                )
            )
        );
        return $data;
    }

    function get_category_for_dropdown() {
        $record = [];
        $data = Category::where(['type' => 1, 'status' => 1])->orderBy('ordering', 'asc')->get();
        if ($data) {
            $record = make_select_option_tree($data, 'id', 'category_name', 'Category');
        }
        return $record;
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model {

    protected $dateFormat = 'U';
    protected $fillable = [
        'title',
        'slug',
        'sub_title',
        'category_id',
        'short_description',
        'long_description',
        'image',
        'publish_date',
        'ordering',
        'status',
        'created_by',
        'updated_by'
    ];

    function category() {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    function suffle($result) {
        $new_arr = array();
        if ($result) {
            foreach ($result as $k => $v) {
                //# create new array with necessary items only
                $new['id'] = $v->id;
                $new['title'] = $v->title;
                $new['category'] = $v->category->category_name;
//                $new['publish_date'] = date('Y-m-d',$v->created_at);
                $new['created_date'] =$v->created_at;
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
                    array('label' => 'News  Title',
                        'name' => 'title',
                        'type' => 'text',
                        'value' => $values['title'],
                        'class' => 'form-control',
                    ),
//                    array('label' => 'News Category',
//                        'name' => 'category_id',
//                        'type' => 'dropdown',
//                        'option' => $this->get_category_for_dropdown(),
//                        'selected' => $values['category_id'],
//                        'attributes' => array('class' => "selectpicker form-control"),
//                    ),
                    array('label' => 'Image',
                        'name' => 'image',
                        'type' => 'image', //# image byb!
                        'value' => $values['image'],
                        'class' => 'form-control',
                        'onclick' => 'BrowseServer(this)',
                        'data-resource-type' => 'image',
                        'data-multiple' => "false",
                        'id' => "news_image",
                        'placeholder' => "News Image"
                    ),
                    array('label' => 'Short description',
                        'name' => 'short_description',
                        'type' => 'textarea',
                        'value' => $values['short_description'],
                        'class' => 'form-control',
                    ),
                    array('label' => 'Status',
                        'name' => 'status',
                        'type' => 'dropdown',
                        'option' => ['1' => 'Active', '0' => 'Inactive'],
                        'selected' => $values['status'],
                        'attributes' => array('class' => "selectpicker form-control"),
                    ),
                ),
            ),
            'group2' => array(
                'width' => '6',
                'field' => array(
                    array('label' => 'Long Description',
                        'name' => 'long_description',
                        'type' => 'textarea',
                        'value' => $values['long_description'],
                        'class' => 'form-control',
                        'id' => 'ckeditor',
                    ),
//                    array('label' => 'Ordering',
//                        'name' => 'ordering',
//                        'type' => 'text',
//                        'instruction' => '(Only Integers.)',
//                        'value' => $values['ordering'],
//                        'class' => 'form-control ',
//                    ),
                ),
            )
        );
        return $data;
    }

    function get_category_for_dropdown() {
        $record = [];
        $data = Category::where(['type' => 3, 'status' => 1])->orderBy('ordering', 'asc')->get();
        if ($data) {
            $record = make_select_option_tree($data, 'id', 'category_name', 'Category');
        }
        return $record;
    }

}

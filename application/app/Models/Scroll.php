<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scroll extends Model {

    protected $dateFormat = 'U';
    protected $fillable = [
        'id',
        'parent_id',
        'category_name',
        'type',
        'type_id',
        'product',
        'product_id',
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

    function suffle($result) {
        $new_arr = array();
        if ($result) {
            foreach ($result as $k => $v) {
//                pr($v->category_type);
                //# create new array with necessary items only
                $new['id'] = $v->id;
                $new['Product name'] = $v->product;
                $new['Type'] = $v->type;
                $new['Ordering'] = $v->ordering;
                $new_arr[] = collect($new);
            }
        }
        return collect($new_arr);
    }

    function sufflex($result) {
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
                        'name' => 'type_id',
                        'type' => 'dropdown',
                        'option' => $this->get_category_type_for_dropdown(),
                        'selected' => $values['type_id'],
                        'attributes' => array('class' => "selectpicker form-control required"),
                    ),
                    array('label' => 'Product',
                        'name' => 'product_id',
                        'type' => 'dropdown',
                        'option' => $this->get_product_for_dropdown($values['type']),
                        'selected' => $values['product_id'],
                        'attributes' => array('class' => "selectpicker form-control required"),
                       // 'instruction' => 'Do not choose parent same as the category name itself. EG: Do not choose "Slatters Shoes" as category parent for the category "Slatters Shoes". Just keep it empty',
                    ),

                    array('label' => 'Ordering',
                        'name' => 'ordering',
                        'type' => 'text',
                        'instruction' => '(Only Integers.)',
                        'value' => $values['ordering'],
                        'class' => 'form-control required number',
                    ),
                    
                    /* array('label' => 'Category Name',
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
                    ),*/
                ),
            ),  
        );
        return $data;
    }

    function get_category_type_for_dropdown() {
        $record = [];
        $data = Category_type::orderBy('id')->whereNotIn('id',[1,8])->get();
        if ($data) {
            $record = make_select_option_tree($data, 'id', 'name', 'Category');
        }
        return $record;
    }

    function get_product_for_dropdown($type_id = 2) {
        $record = [];
        if($type_id==2){
            $data = Hire::orderBy('acc_ordering')->select('*')->get();

        }else if($type_id==3){
            $data = Retail::orderBy('acc_ordering')->select('*')->get();

        }else{
            $data = Brand::orderBy('acc_ordering')->select('*')->get();

        }
        if ($data) {
            $record = make_select_option_tree($data, 'id', 'name', 'Product',FALSE);
        }
        return $record;
    }

}

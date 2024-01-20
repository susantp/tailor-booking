<?php

/**
 * form builder byb
 * mode, check if certain block is to be displayed in create view only or edit view only
 * @param type $variables
 * @param type $module
 * @param type $mode  create/edit 
 * @return type
 */
function form_builder($variables, $module, $mode = 'create') {
    $method = isset($variables['method']) ? $variables['method'] : 'POST';
    $attributes = array('url' => $variables['action'], 'method' => $method, 'files' => true, 'id' => "formID", 'class' => "form-horizontalx form-bordered user_form");
    $HTMLform = Form::open($attributes);
    $HTMLform .= '<div class="row">';
    foreach ($variables['fields'] as $gk => $group):
        $HTMLform .= '<div class="col-sm-' . $group['width'] . '">';
        foreach ($group['field'] as $fk => $field):
            if ($field['type'] == 'template') {
                $HTMLform .=$field['name'];
                continue;
            }
            //#check if mode is defined >>
            $hidden = '';
            if (isset($field['mode']) && $field['mode'] != $mode) {
                $hidden = 'hidden';
            }
            //#check if mode is defined <<
            if (!isset($field['display']) || (isset($field['display']) && $field['display'] == 'inline_start')) {
                $HTMLform .= '<div class="form-group ' . $hidden . '">';
//                $HTMLform .= '<label class="col-sm-2 control-label">' . $field['label'];
                $HTMLform .= '<label>' . $field['label'];
                if (isset($field['instruction'])):
                    $HTMLform .= ' <span class="instructions">' . $field['instruction'] . '</span>';
                endif;
                $HTMLform .= '</label>';
//                $HTMLform .= '<div class="col-sm-8">'; 

                if (isset($field['additional'])):
                    $HTMLform .= '<div class="input-group">';
                    $HTMLform .= '<span class="input-group-addon">' . $field['additional'] . '</span>';
                endif;
            }
            if (isset($field['display'])) {
                if ($field['display'] == 'inline_start') {
                    $HTMLform .= '<div class="row">';
                }
                $HTMLform .= '<div class="col-sm-' . $field['width'] . '">';
//                $HTMLform .= '<div class="form-group">';
            }

            if (isset($field['name'])) {
                $name = $field['name'];
                unset($field['name']);
            }
            $value = '';
            if (isset($field['value'])) {
                $value = $field['value'];
                unset($field['value']);
            }
            if ($field['type'] == 'text'):
                $HTMLform .= Form::text($name, $value, $field);
            elseif ($field['type'] == 'hidden'):
                $HTMLform .= Form::hidden($name, $value, $field);
            elseif ($field['type'] == 'password'):
                $HTMLform .= Form::password($name, $field);
            elseif ($field['type'] == 'textarea'):
                $HTMLform .= Form::textarea($name, $value, $field);
            elseif ($field['type'] == 'filezzz'):
                $file_name = $field['props']['name'];
                unset($field['props']['name']);
                $HTMLform .= Form::file($file_name, Request::old('image'), $field['props']);
                if ($field['isEdit'] != '') :
                    $isEditName = isset($field['isEditName']) ? $field['isEditName'] : 'old_img';
                    $HTMLform .= '<input type="hidden" value="' . $field['isEdit'] . '" name="' . $isEditName . '"/>';
                    $HTMLform .=$field['showImage'];
                endif;
            elseif ($field['type'] == 'image'):
                $HTMLform .=' <div class="img-append">';
                if (!empty($value)):
                    $field['type'] = 'text'; //# as we dont have and need input type 'image' so replace to 'text'
                    $HTMLform .= Form::text($name, $value, $field);
                    $HTMLform .=' <div class="image-wrapper">
                        <img class="img-responsive" src="' . asset('assets/') . '/' . $value . '" />
                        <a href="javascript:void(0);" class="delete">
                            Delete
                        </a>
                    </div>';
                else:
                    $HTMLform .= Form::text($name, $value, $field);
                endif;
                $HTMLform .=' </div>';
            elseif ($field['type'] == 'dropdown'):
                $selected = (isset($field['selected'])) ? $field['selected'] : '';
                $HTMLform .= Form::select($name, $field['option'], $selected, $field['attributes']);
            elseif ($field['type'] == 'multiselect'):
                $selected = '';
                if (isset($field['selected'])):
                    $selected = $field['selected'];
                endif;
                $HTMLform .= form_multiselect($field['name'], $field['option'], $selected, $field['class']);
            elseif ($field['type'] == 'radio'):
                foreach ($field[0] as $fields):
                    $HTMLform .= '<div class="radio">';
                    $selected = ($fields['value'] == $field['selected']) ? TRUE : FALSE;
                    $id = 'rd-' . $fields['name'] . '-' . $fields['value'];
                    $fields['attributes']['id'] = $id;
                    $radio = Form::radio($fields['name'], $fields['value'], $selected, $fields['attributes']);
                    $HTMLform .= '<label for="' . $id . '"> ' . $radio . ' ' . $fields['label'] . '</label>';
                    $HTMLform .= '</div>';
                endforeach;
            elseif ($field['type'] == 'checkbox'):
                foreach ($field[0] as $fields):
                    $HTMLform .= '<div class="checkbox">';
                    $selected = $field['selected'];
                    $id = 'chk-' . $fields['name'] . '-' . $fields['value'];
                    $fields['attributes']['id'] = $id;
                    $chk = Form::checkbox($fields['name'], $fields['value'], in_array($fields['value'], $selected), $fields['attributes']);
                    $HTMLform .= '<label for="' . $id . '"> ' . $chk . ' ' . $fields['label'] . '</label>';
                    $HTMLform .= '</div>';
                endforeach;
            elseif ($field['type'] == 'checkboxyz'):
                $HTMLform .='<div class="floatL mr10">';
                $HTMLform .= form_checkbox($field);
                $HTMLform .='</div>';
            elseif ($field['type'] == 'date'):
                $HTMLform .='<div class="input-group date" data-picker-position="bottom-left"  data-date-format="dd MM yyyy">';
//                $field['type'] = 'text';
                $HTMLform .= Form::text($name, $value, $field);
                $HTMLform .='
        
            <div class = "input-group-addon">
            <i class = "fa fa-calendar"></i>
            </div>
            </div>';
            endif;
            if (isset($field['additional'])):
                $HTMLform .= '</div>';
            endif;
            if (isset($field['display'])) {
                $HTMLform .= '</div>';
                if ($field['display'] == 'inline_end') {
                    $HTMLform .= '</div>'; //#inline row closes
                } else {
                    continue;
                }
            }
//            $HTMLform .= '</div></div>';
            $HTMLform .= '</div>';
        endforeach;
        $HTMLform .= '</div>';
    endforeach;
    $HTMLform .= '</div>';
    $HTMLform .= isset($variables['save_single']) ? form_save_single($module) : form_save_options($module);
    $HTMLform .= Form::close();
    return $HTMLform;
}

function form_save_options($module) {
    $HTMLform = '';
    $HTMLform .= '<div class="row"><div class="col-lg-12 col-md-12 "><div class="form-group">';
    $HTMLform .= ' ' . Form::submit('Save', array('class' => 'btn btn-info', 'name' => 'save_only'));
    $HTMLform .= ' ' . Form::submit('Save and New', array('class' => 'btn btn-info', 'name' => 'save_new'));
    $HTMLform .= ' ' . Form::submit('Save and Exit', array('class' => 'btn btn-primary'));
    $HTMLform .= ' <a class="btn btn-warning" href="' . config('site.admin') . $module . '"><span>Cancel</span></a>  ';
    $HTMLform .='</div></div></div>';
    return $HTMLform;
}

function form_save_single($module) {
    $HTMLform = '';
    $HTMLform .= '<div class="row"><div class="col-lg-12 col-md-12 "><div class="form-group">';
    $HTMLform .= ' ' . Form::submit('Save', array('class' => 'btn btn-info'));
    $HTMLform .='</div></div></div>';
    return $HTMLform;
}

function make_select_option_treeNOT($data, $selected) {
    $html = '';
    if (!empty($data)) {
        foreach ($data as $item) {
            $sel = ($selected == $item->id) ? 'selected' : '';
            $html .= '<option ' . $sel . ' value="' . $item->id . '">' . $item->name . '</option>';
            ##ONLY IF WORKING WITH MORE LEVELS
            if ($item->children->count()) {
                foreach ($item['children'] as $child) {
                    $html .= ' <option value="' . $child->id . '"> ' . spaces(7) . $child->name . '</option>';
                    ##ONLY IF WORKING WITH MORE LEVELS
                    if ($child->children->count()) {
                        foreach ($child['children'] as $small) {
                            $html .= '<option value="' . $small->id . '"> ' . spaces(15) . $small->name . '</option>';
                        }
                    }
                }
            }
        }
    }
    return $html;
}

/**
 * makes the select option tree on multi level base
 * @param type $data
 * @param type $value
 * @param type $display_name
 * @return string
 */
function make_select_option_tree($data, $value, $display_name, $select, $multilevel = true) {
    $arr[''] = 'Select ' . $select;
    if (!empty($data)) {
        foreach ($data as $item) {
            $arr[$item->$value] = $item->$display_name;
            //# ONLY IF WORKING WITH MORE LEVELS
            if ($multilevel) {
                if (isset($item->children) && $item->children->count()) {
                    foreach ($item['children'] as $child) {
                        $arr[$child->$value] = spaces(7) . $child->$display_name;
                        //# ONLY IF WORKING WITH MORE LEVELS
                        if ($child->children->count()) {
                            foreach ($child['children'] as $small) {
                                $arr[$small->$value] = spaces(15) . $small->$display_name;
                            }
                        }
                    }
                }
            }
        }
    }
    return $arr;
}

function spaces($times) {
    $spaces = ' ';
    for ($i = 1; $i <= $times; $i++) {
        $spaces .='&nbsp;';
    }
    return $spaces . ' - ';
}

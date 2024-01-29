<?php

namespace App\Http\Controllers\Traits;

trait EssentialsTrait {

    public function essentials() {
        $data = array(
            'module' => $this->module,
            'title' => $this->page_title,
            'item' => $this->item,
            'panel_title' => $this->item . ' List',
            'img_folder' => $this->img_folder,
            'field_id' => $this->field_id,
            'has_ckeditor' => isset($this->has_ckeditor) ? $this->has_ckeditor : false,
            'has_elfinder' => isset($this->has_elfinder) ? $this->has_elfinder : false,
            'jsfile' => isset($this->jsfile) ? $this->jsfile : false,
            'apply_datatable' => isset($this->apply_datatable) ? $this->apply_datatable : true, //apply by default, :: i think it failed due to lack of pagination for collections, tried for activity module
        );
        return $data;
    }

    function redirect($save_only, $save_new, $id, $action = 'added') {
        if (isset($save_only) && $save_only != '') {
            return redirect(config('site.admin') . $this->module . '/' . $id . '/edit')->withSuccess($this->item . ' is successfully ' . $action . '.');
        } elseif (isset($save_new) && $save_new != '') {
            return redirect(config('site.admin') . $this->module . '/create')->withSuccess($this->item . ' is successfully ' . $action . ', Add new one.');
        } else {
            return redirect(config('site.admin') . $this->module)->withSuccess($this->item . ' is successfully ' . $action . '.');
        }
    }

}

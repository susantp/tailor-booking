<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Content;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Setting;

class MyFrontController extends Controller {

    public $data = array();

    public function __construct() {
        $menu = new Menu;
        $this->data['main_menu'] = $menu->main_menu_tree();
        $this->data['openingTime'] = Content::where('id', 8)->first();
        $this->data['hire'] = Category::where('status', 1)->where('type', 2)->orderBy('ordering')->get();
        $this->data['retail'] = Category::where('status', 1)->where('type', 3)->orderBy('ordering')->get();
        $this->data['brand'] =  Category::where('status', 1)->where('type', 8)->orderBy('ordering')->get();
        $this->data['footerCatListing'] = Category::where('status', 1)->where(function($q){
            return $q->where('type', 2)->orWhere('type', 3);
        })->orderBy('type')->orderBy('ordering')->get();
        
        //site configurations
        $this->data['settings'] =  Setting::findorfail(1);
        $this->data['key'] = ''; //# just a setter for empty cases
    }

}

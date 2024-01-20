<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Content;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Retail;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\News;
use App\Models\Suit;
use App\Models\Scroll;
use App\Models\Affiliates;
use App\Models\Advertisement;
use App\Models\Hire;

class HomeController extends MyFrontController {

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->data['banners'] = Banner::where('status', 1)->orderBy('ordering')->get();
        $this->data['content'] = Content::where('id', 1)->first();
        $scroll=Scroll::orderBy('ordering','desc')->get();
        $pro=[];
        foreach($scroll as $v){
            if($v->type_id==2){
               $pro[]= Hire::where('id', $v->product_id)->first();
            }else if ($v->type_id==3){
                $pro[]=Retail::where('id', $v->product_id)->first();
            }else{
                $pro[]=Brand::where('id', $v->product_id)->first();
            }


        }
        $this->data['products'] =$pro;
        $this->data['brands'] = Brand::where('status', 1)->orderBy('acc_ordering')->get();
//        $this->data['brands'] = GalleryImage::where('status', 1)->where('gid', 17)->orderBy('ordering', 'desc')->get();
//        $this->data['listings'] = Hire::where('status', 1)->where('featured', 1)->orderBy('acc_ordering')->limit(6)->get();
        $this->data['is_home'] = true;
//        pr($this->data['news']->count() );
//        pr(url(''));
        return view('frontend.pages.home', $this->data);
    }

}

<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Hire;
use App\Models\HireImage;

class AccommodationController extends MyFrontController {

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    public function index($name,$id='', $slug = '') {
        $segments = \Request::segments();
        switch ($segments[0]) {
            case 'hotel':
                $type = 'h';
                break;
            case 'lodges':
                $type = 'l';
                break;
            case 'restaurant':
                $type = 'r';
                break;
            case 'home-stay':
                $type = 'hs';
                break;
            default :
                $type = 'h';
        }
        $this->data['search_type'] = '';
        $this->data['recent_listings'] = Hire::where('status', 1)->orderBy('created_at','desc')->limit(3)->get();
        if ($id == '') {
            $this->data['breadcrumb'] = array('Home' => '', $name => '');
            $this->data['listings'] = Hire::where('status', 1)->where('type', $type)->orderBy('acc_ordering')->paginate();
            return view('frontend.pages.accommodation.list', $this->data);
        } else {
            $this->data['listing'] = $a = Hire::where('id', $id)->first();
            if(!$a){
                abort(404,'No Data Found.');
            }
            $this->data['breadcrumb'] = array('Home' => '', $name => $name, $a->name => '');
            Hire::find($id)->increment('views');
            return view('frontend.pages.accommodation.detail', $this->data);
        }
    }

}

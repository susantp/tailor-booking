<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Brand;
use App\Models\BrandImage;
use App\Models\Category;
use App\Models\GalleryImage;
use App\Models\HireImage;
use App\Models\Retail;
use App\Models\RetailImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Menu;
use App\Models\Content;
use App\Models\Suit;
use App\Models\Hire;
use App\Models\Guide;
use App\Models\News;

class PageController extends MyFrontController
{

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
//        $segment = \Request::segment(1); //# just for ref
        $segments = \Request::segments();
        $method_slug = $segments[0];
        $method_params = ($segments);
        array_shift($method_params);
        $slug = end($segments);
        $this->data['slug'] = $slug;
        $this->data['recent_listings'] = Hire::where('status', 1)->orderBy('created_at', 'desc')->limit(3)->get();
        $menu = new Menu;
        $this->data['tg'] = $menu->get_menus('tg');
        $menu_data = $menu->menu_data($slug);
        //#NOTE:: Before Proceeding, validation of hierarchy of parent slugs can be done. 
        if (($menu_data)) {
            //# for breadcrumbs >>
            $menu_parents = Menu::with('parentRecursive')->where('id', $menu_data->id)->get();
            foreach ($menu_parents as $mp) {
                $breadcrumb[$mp->name] = '';
                if (isset($mp['parentRecursive']) && $mp['parentRecursive']->count()) {
                    $mpp = $mp['parentRecursive'];
                    $breadcrumb[$mpp->name] = '';
                    if ($mp['parentRecursive']->count()) {
                        $mppp = $mpp['parentRecursive'];
                        $breadcrumb[$mppp->name] = '';
                    }
                }
            }
            $breadcrumb['Home'] = '';
            $this->data['breadcrumb'] = array_reverse($breadcrumb);
            //# for breadcrumbs <<
            if ($menu_data->menu_link_type == 'content') {
                $this->data['menu'] = $menu_data;
                $this->data['addCss'] = array(//                    'assets/frontend/css/pages/about.css'
                );
                $this->data['addJs'] = array(//                    'assets/frontend/js/common/inner-page.js'
                );
                $this->data['page_banner'] = $menu_data->image?$menu_data->image:config('site.page_banner');
//            pr($menu_data);
                $this->data['content'] = Content::where('id', $menu_data->content_id)->first();
                $this->data['curPage'] = $this->data['content'];
                return view('frontend.pages.content', $this->data);
            } else if ($menu_data->menu_link_type == 'url') {
                $method = $this->check_method_exists($method_slug);
                if ($method) {
                    $slug = str_slug($method_slug, '_');
                    return $this->$slug($method_params);
                } else {
                    if ($menu_data->url == 'contact-us-or-some-other-thing') {
                        return view('frontend.pages.some_other_page', $this->data);
                    }
                    if ($menu_data->url == 'measurement') {
                        return app()->call('\Modules\Measurement\Http\Controllers\MeasurementController@index', ['data' => $this->data, 'menuData' => $menu_data]);
                    }
                }
            }
        } else {
            $method = $this->check_method_exists($method_slug);
            if ($method) {
                $slug = str_slug($method_slug, '_');
                return $this->$slug($method_params);
            } else {
                if ($slug == 'send-email') {
                    return app()->call('\Modules\Measurement\Http\Controllers\MeasurementController@sendEmail');
                }
                abort(404, "We Do not serve such requests!");
            }
        }
    }

    function check_method_exists($slug)
    {
        $slug = str_slug($slug, '_');
        return method_exists($this, (string)$slug) ? true : false;
    }

    ##########################################################################################
    ##########################################################################################
    ############################## - REST OF THE METHODS! - #################################
    ##########################################################################################
    ##########################################################################################

    public function hire($params = '')
    {
        if (count($params) > 1) {
            abort(404, "We Do not serve such requests for category!");
        }
        $type = (reset($params));
        $this->data['type'] = $type;
        $this->data['displayTitle'] = 'Hire';
        $this->data['prodDesc'] = Content::where('id', 11)->first();
        $category = Category::where('category_slug', $type)->first();
        $this->data['curPage'] = $category;
        $this->data['page_banner'] = $category->image ? $category->image : config('site.page_banner');
        if (!$category) {
            abort(404, "We Do not serve such requests for category!");
        }
        $this->data['listings'] = Hire::where('status', 1)->where('category_id', $category->id)->orderBy('acc_ordering')->paginate(20);
        return view('frontend.pages.listing', $this->data);
    }

    public function retail($params = '')
    {
        if (count($params) > 1) {
            abort(404, "We Do not serve such requests for category!");
        }
        $type = (reset($params));
        $this->data['type'] = $type;
        $this->data['displayTitle'] = 'Retail';
        $this->data['prodDesc'] = Content::where('id', 11)->first();
        $category = Category::where('category_slug', $type)->first();
        $this->data['curPage'] = $category;
        $this->data['page_banner'] = $category->image ? $category->image : config('site.page_banner');
        if (!$category) {
            abort(404, "We Do not serve such requests for category!");
        }
        $this->data['listings'] = Retail::where('status', 1)->where('category_id', $category->id)->orderBy('acc_ordering')->paginate(20);
        return view('frontend.pages.listing', $this->data);
    }

    public function brand($params = '')
    {
        if (count($params) > 1) {
            abort(404, "We Do not serve such requests for category!");
        }
        $type = (reset($params));
        $this->data['type'] = $type;
        $this->data['displayTitle'] = 'Brand';
        $this->data['prodDesc'] = Content::where('id', 11)->first();
        $category = Category::where('category_slug', $type)->first();
        $this->data['curPage'] = $category;
        $this->data['page_banner'] = $category->image ? $category->image : config('site.page_banner');
        if (!$category) {
            abort(404, "We Do not serve such requests for category!");
        }
        $this->data['listings'] = Brand::where('status', 1)->where('category_id', $category->id)->orderBy('acc_ordering')->paginate(20);
        return view('frontend.pages.listing', $this->data);
    }

    function product($params = '')
    {
        if ($params) {
            if (count($params) > 1) {
                abort(404, "We Do not serve such requests for product!");
            }
            $slug = reset($params);

            $this->data['product'] = $a = Hire::where('slug', $slug)->first();
            $imgsrc = 'hire';
            if (!$a) {
                $this->data['product'] = $b = Retail::where('slug', $slug)->first();
                $imgsrc = 'retail';
                if (!$b) {
                    $this->data['product'] = $c = Brand::where('slug', $slug)->first();
                    $imgsrc = 'brand';
                    if (!$c) {
                        abort(404, "No product found!");
                    }
                }
            }
            $this->data['curPage'] = $this->data['product'];
            $this->data['page_banner'] = $this->data['product']->banner_image ? $this->data['product']->banner_image : config('site.page_banner');
//            pr( $this->data['curPage']);
            if ($imgsrc == 'hire') {
                $this->data['images'] = HireImage::where('aid', $this->data['product']->id)->get();
            } else if ($imgsrc == 'brand') {
                $this->data['images'] = BrandImage::where('aid', $this->data['product']->id)->get();
            } else {
                $this->data['images'] = RetailImage::where('aid', $this->data['product']->id)->get();
            }

            return view('frontend.pages.product_detail', $this->data);
        } else {
            abort(404, "We Do not serve such requests for product!");
        }
    }

    public function gallery()
    {
        $menu = Menu::where('id', 13)->first();
        $this->data['page_banner'] = $menu->image ? $menu->image : config('site.page_banner');
        $this->data['images'] = GalleryImage::where('gid', 6)->get();
        return view('frontend.pages.gallery', $this->data);
    }

    function contact_us()
    {
        $menu = Menu::where('id', 11)->first();
        $this->data['page_banner'] = $menu->image ? $menu->image : config('site.page_banner');
        $this->data['recent_listings'] = Hire::where('status', 1)->orderBy('created_at', 'desc')->limit(3)->get();
        $this->data['addJs'] = array(//            'assets/frontend/js/pages/contact.js',
        );
        $this->data['addCss'] = array(//            'assets/frontend/css/pages/contact.css',
        );
        return view('frontend.pages.contact', $this->data);
    }

    function send_your_data()
    {
        $this->data['recent_listings'] = Hire::where('status', 1)->orderBy('created_at', 'desc')->limit(3)->get();
        $this->data['addJs'] = array(//            'assets/frontend/js/pages/contact.js',
        );
        $this->data['addCss'] = array(//            'assets/frontend/css/pages/contact.css',
        );
        return view('frontend.pages.send_your_data', $this->data);
    }


}

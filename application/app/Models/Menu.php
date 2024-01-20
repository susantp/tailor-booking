<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {

    protected $dateFormat = 'U';
    protected $fillable = [
        'id',
        'parent_id',
        'name',
        'slug',
        'menu_icon',
        'image',
        'meta_title',
        'meta_description',
        'menu_type',
        'menu_link_type',
        'category_id',
        'content_id',
        'url',
        'file',
        'status',
        'ordering',
        'created_by',
        'updated_by',
    ];
    public $menu_link_types = [
        '' => 'None',
        'content' => 'Content',
        'url' => 'URL',
//        'product' => 'Product',
//        'file' => 'file',
    ];
    public $menu_types = [
        'main' => 'Main Menu',
//        'top' => 'Top Menu',
//        'f1' => 'Footer Menu Section 1',
//        'f2' => 'Footer Menu Section 2',
//        'f3' => 'Footer Menu Section 3',
//        'f4' => 'Footer Menu Section 4',
//        'tg' => 'Travel Guide',
        'custom' => 'Custom Menu',
    ];

    public function parents() {
        //originally there is no 's' in above function :: just remainder
        return $this->hasOne(static::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(static::class, 'parent_id');
    }

    public static function tree($exclude_id='') {
//    return static::with(implode('.', array_fill(0, 100, 'children')))->where('parent_id', '=', NULL)->get();
        return static::with('children')
                ->where('parent_id', 0)
                ->when($exclude_id != '', function ($query) use($exclude_id) {
                    $query->where('id','!=',$exclude_id);
                })
                ->orderBy('menu_type', 'ordering')
                ->get();
    }

    function suffle($result) {
        $new_arr = array();
        if ($result) {
            foreach ($result as $k => $v) {
                //# create new array with necessary items only
                $new['id'] = $v['id'];
                $new['name'] = $v['name'];
                $new['menu_type'] = $this->menu_types[$v['menu_type']];
                $new['ordering'] = $v['ordering'];
                $new['status'] = $v['status'];
                $new_arr[] = collect($new);
                if ($v['children']->count()) {
                    foreach ($v['children'] as $vv) {
                        $new['id'] = $vv['id'];
                        $new['name'] = '- ' . $vv['name'];
                        $new['menu_type'] = $this->menu_types[$vv['menu_type']];
                        $new['ordering'] = $vv['ordering'];
                        $new['status'] = $vv['status'];
                        $new_arr[] = collect($new);
                        if ($vv['children']->count()) {
                            foreach ($vv['children'] as $vvv) {
                                $new['id'] = $vvv['id'];
                                $new['name'] = '-- ' . $vvv['name'];
                                $new['menu_type'] = $this->menu_types[$vvv['menu_type']];
                                $new['ordering'] = $vvv['ordering'];
                                $new['status'] = $vvv['status'];
                                $new_arr[] = collect($new);
                                if ($vvv['children']->count()) {
                                    foreach ($vvv['children'] as $vvvv) {
                                        $new['id'] = $vvvv['id'];
                                        $new['name'] = '--- ' . $vvvv['name'];
                                        $new['menu_type'] = $this->menu_types[$vvvv['menu_type']];
                                        $new['ordering'] = $vvvv['ordering'];
                                        $new['status'] = $vvvv['status'];
                                        $new_arr[] = collect($new);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return collect($new_arr);
    }

    ##########################################################################################
    ##########################################################################################
    ############################## - FRONTEND BEGINS HERE! - #################################
    ##########################################################################################
    ##########################################################################################

    public static function main_menu_tree() {
        return static::with('children')->where('parent_id', 0)->where('menu_type', 'main')->orderBy('ordering')->get();
    }

    function get_menus($menu_type) {
        $data = $this::where('parent_id', 0)->where('menu_type', $menu_type)->orderBy('ordering')->get();
        return $data;
    }

    // parent
    public function parentCategory() {
        return $this->belongsTo('App\Models\Menu', 'parent_id');
    }

    // all ascendants
    public function parentRecursive() {
        return $this->parentCategory()->with('parentRecursive');
    }

//    public function main_menu_list() {
//        $tree = $this::main_menu_tree();
//        $data = $this->prepareMenu($tree);
//        return $data;
//    }

    /**
     * BACKUP CODE FROM NET FOR REF
     * @param type $tree
     * @return string
     */
    function prepareMenu($tree, $level = 0) {
        $data = $level == 0 ? '<ul class="nav nav-pills nav-right">' : '<ul class="submenu">';
        foreach ($tree as $item) {
            $sub = count($item->children) > 0 ? ' has-submenu' : '';
            $data .= '<li class="nav-item' . $sub . '"><a href="' . $item->url . '">' . $item->name . '</a></li>';
            if (count($item->children) > 0) {
                $data .= self::prepareMenu($item->children, $level + 1);
            }
        }
        $data .= '</ul>';
        return $data;
    }

    /**
     * checks if  menu data for the given slug is available
     * @return type
     */
    function menu_data($slug) {
        $data = $this::where('status', '1')
                ->where(function($query) use($slug) {
                    $query->where('slug', $slug)
                    ->where('menu_link_type', 'content');
                })
                ->orWhere(function($query) use($slug) {
                    $query->where('url', $slug)
                    ->where('menu_link_type', 'url');
                })
//                                ->toSql();
                ->first();
        return $data;
    }

}

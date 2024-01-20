<?php

function get_select($data, $default_value = '', $name_column = '', $id_column = '') {
    $result = array();
    if (!empty($data)) {
        if ($default_value != '')
            $result[''] = $default_value;
        if ($name_column == '')
            $name_column = 'name';
        if ($id_column == '')
            $id_column = 'id';
        foreach ($data as $row) {
            $result[$row->$id_column] = $row->$name_column;
        }
    }
    return $result;
}

/**
 * change plain number to formatted currency
 *
 * @param $number
 * @param $currency
 */
function formatNumber($number, $currency = 'IDR') {
    if ($currency == 'USD') {
        return number_format($number, 2, '.', ',');
    }
    return number_format($number, 0, '.', '.');
}

function pr($data, $exit = true) {
    echo '<pre>';
    print_r($data);
    if ($exit) {
        exit;
    }
}

function logged_in($key) {
    return (get_userdata($key)) ? true : false;
}

function get_target() {
    return array('' => 'Current window (default)', '_blank' => 'New window (_blank)');
}

function show_image($image, $title, $folder = '', $w = 'auto', $h = 'auto', $class = 'img-responsive', $alt = TRUE, $sample = 'sample.jpg') {
    $return = '';
    if ($image != '') {
        $return = '<img src="' . asset('assets/' . $folder . '/' . $image) . '" title="' . $title . '" alt="' . $title . '"  height="' . $h . '"  width="' . $w . '" class="' . $class . '"/>';
    } else {
        if ($alt) {
            $return = '<img src="' . asset('assets/' . $sample) . '" title="' . $title . '"  alt="' . $title . '"  height="' . $h . '"  width="' . $w . '" alt="' . $title . '" class="' . $class . '"/>';
        }
    }
    return $return;
}

function check_parent_active($children, $current_segment) {
    foreach ($children as $child) {
        if ($child->slug == $current_segment) {
            return true;
        }
    }
}

function check_menu_links($item = [], $prefix = '') {
    $target = '';
    if ($item['menu_link_type'] == 'url') {
        if (strpos($item['url'], 'http') !== false) {
            $page_url = $item['url'];
            $target = 'target="_blank"';
        } else {
            $page_url = url($item['url']);
        }
    } else if ($item['menu_link_type'] == 'file') {
        $page_url = config('site.root') . 'assets/' . $item['file'];
    } else if ($item['menu_link_type'] == '') {
        $page_url = 'javascript:void(0)';
    } else {
        $page_url = url($prefix . '/' . $item['slug']);
    }
    if ($item->children->count()) {
        $page_url = 'javascript:void(0)';
    }
    $menu_icon = empty($item['menu_icon']) ? '' : asset('assets/' . $item['menu_icon']);
    return ['target' => $target, 'page_url' => $page_url, 'menu_icon' => $menu_icon];
}

function display_breadcrumb_front($breadcrumb, $base_url) {
    $bread = '<ul class="breadcrumb">';
    $i = 1;
    foreach ($breadcrumb as $key => $value):
        if ($value == '' && $key != 'Home'):
            $arrow = $i == count($breadcrumb) ? '' : '<i class="md-icon">keyboard_arrow_right</i>';
            $bread .= '<li><a class="breadcrumb-item active" href="javascript:void()">' . ucfirst($key) . '</a> ' . $arrow . '</li>';
        else:
            $bread .= '<li><a class="breadcrumb-item" href="' . $base_url . '/' . $value . '">' . ucfirst($key) . '</a> <i class="md-icon">keyboard_arrow_right</i></li>';
        endif;
        $i++;
    endforeach;
    $bread .= '</ul> ';
    return $bread;
}

function get_accommodation_url($name, $id, $acc_type) {
    switch ($acc_type) {
        case 'h':
            $type = 'hotel';
            break;
        case 'l':
            $type = 'lodges';
            break;
        case 'r':
            $type = 'restaurant';
            break;
        case 'hs':
            $type = 'home-stay';
            break;
    }
    return $url = $type . '/' . $id . '/' . str_slug($name);
}

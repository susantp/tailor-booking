<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\Request;

class Activity extends Model {

    protected $table = 'activity_log';
    protected $fillable = [
        'user_id',
        'user_role',
        'action',
        'module',
        'module_id',
        'new_value',
        'old_value',
        'description',
        'ip_address',
        'user_agent',
    ];

    function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    function role() {
        return $this->belongsTo('App\Models\Role', 'user_role');
    }

    public static function log($data = []) {
        $activity = [
            'user_id' => Auth::user()->id,
            'user_role' => Auth::user()->role_id,
            'action' => $data['action'],
            'module' => $data['module'],
            'module_id' => $data['module_id'],
            'new_value' => isset($data['new_value']) ? $data['new_value'] : '',
            'old_value' => isset($data['old_value']) ? $data['old_value'] : '',
            'description' => isset($data['description']) ? $data['description'] : '',
            'ip_address' => Request::getClientIp(true),
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'No User Agent',
        ];
        static::create($activity);
        return TRUE;
    }

}

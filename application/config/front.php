<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [
    'name' => 'HHH',
    'title' => 'September Shell',
//    'admin' => url('shell').'/', // this line cause php artisan to work with errors i.e. not working  << -- sept23 seems working <<--oct1 well works in normal case but it caues artisan commands to fail and pop out error.
    'admin' => 'http://hhh.test/shell/',
    'root' => $_SERVER['DOCUMENT_ROOT'] . '/',
    'page_image' => 'dido.jpg',
    'subtitle' => 'Reaching out to the world',
    'description' => 'Simply, an admin panel, wake me up when september ends, HA HA!',
    'author' => 'bkesh',
    'page_image' => 'home-bg.jpg',
    'contact_email' => 'limited.sky710@gmail.com',
    'per_page' => 7000,
    'rss_size' => 25,
    'contact_email' => env('MAIL_FROM'),
    'uploads' => [
        'storage' => 'local',
        'webpath' => '/uploads',
    ],
    'content' => [
        'w' => '1366',
        'h' => '768',
    ],
    'image' => [
        'w' => '400',
        'h' => '400',
    ]
];

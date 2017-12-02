<?php

use cri2net\php_pdo_db\PDO_DB;

$settings = [
    'Subject' => 'New Email',
];

$arr = [
    'to_email'         => 'user@example.com',
    'to_username'      => 'Username',
    'created_at'       => microtime(true),
    'updated_at'       => microtime(true),
    'template'         => 'some_template',
    'settings'         => json_encode($settings),
    'min_sending_time' => microtime(true),
    'replace_data'     => json_encode([
        'some_var'      => 'Hello',
        'date'          => date('Y.m.d'),
    ]),
];
PDO_DB::insert($arr, TABLE_PREFIX . 'emails');

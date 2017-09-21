<?php
$db[DEV] = [
    'type'           => 'mysql',
    'hostname'       => '192.168.71.236',
    'database'       => 'op_auction',
    'username'       => 'root',
    'password'       => '123456',
    'hostport'       => '',
    'charset'        => 'utf8',
    'prefix'         => 'opa_',
    'debug'          => true,
    'deploy'         => 0,
    'rw_separate'    => false,
    'master_num'     => 1,
    'slave_no'       => '',
    'fields_strict'  => true,
    'resultset_type' => 'array',
    'auto_timestamp' => false,
    'auto_datetime_format' => false,
];

$db[TEST] = [

];

$db[PRO] = [

];

return $db[ENVIRONMENT];
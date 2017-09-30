<?php
$sphinx[DEV] = [
    'host'           => '192.168.71.237',
    'rt'             => 'auction',
    'port'           => '9306'
];

$sphinx[TEST] = [

];

$sphinx[PRO] = [
    'host'           => '10.28.32.35',
    'rt'             => 'auction',
    'port'           => '9306'
];

return $sphinx[ENVIRONMENT];
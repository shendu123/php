<?php
$sphinx[DEV] = [
    'host'           => '192.168.71.237',
    'rt'             => 'item',
    'port'           => '9308'
];

$sphinx[TEST] = [

];

$sphinx[PRO] = [
    'host'           => '10.28.32.35',
    'rt'             => 'item',
    'port'           => '9308'
];

return $sphinx[ENVIRONMENT];
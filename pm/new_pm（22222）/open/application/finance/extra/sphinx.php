<?php
$sphinx[DEV] = [
    'host'           => '192.168.71.237',
    'rt'             => 'crowd',
    'port'           => '9307'
];

$sphinx[TEST] = [

];

$sphinx[PRO] = [
    'host'           => '10.28.32.35',
    'rt'             => 'crowd',
    'port'           => '9307'
];

return $sphinx[ENVIRONMENT];
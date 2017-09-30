<?php
$couchbase[DEV] = [
    'host'           => '192.168.71.201,192.168.71.202,192.168.71.203',
    'bucket'         => 'crowd'

];

$couchbase[TEST] = [

];

$couchbase[PRO] = [
    'host'           => '10.45.22.117,10.29.114.114',
    'bucket'         => 'crowd'
];

return $couchbase[ENVIRONMENT];
<?php
require __DIR__ . '/vendor/autoload.php';

use Firebase\JWT\JWT;

$payload = ['foo' => 'bar'];
$jwt = JWT::encode($payload, 'secret', 'HS256');
echo $jwt;
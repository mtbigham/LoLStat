<?php

$response = file_get_contents('https://lan.api.pvp.net/api/lol/lan/v2.2/matchhistory/4130247?beginIndex=0&endIndex=14&api_key=5d8531ab-35eb-4502-8032-2dcd11a82683');
echo '<pre>';
var_dump(json_decode($response));

$response = file_get_contents('https://lan.api.pvp.net/api/lol/lan/v2.2/matchhistory/4130247?beginIndex=15&endIndex=29&api_key=5d8531ab-35eb-4502-8032-2dcd11a82683');
echo '<pre>';
var_dump(json_decode($response));

$response = file_get_contents('https://lan.api.pvp.net/api/lol/lan/v2.2/matchhistory/4130247?beginIndex=30&endIndex=44&api_key=5d8531ab-35eb-4502-8032-2dcd11a82683');
echo '<pre>';
var_dump(json_decode($response));

$response = file_get_contents('https://lan.api.pvp.net/api/lol/lan/v2.2/matchhistory/4130247?beginIndex=45&endIndex=59&api_key=5d8531ab-35eb-4502-8032-2dcd11a82683');
echo '<pre>';
var_dump(json_decode($response));

$response = file_get_contents('https://lan.api.pvp.net/api/lol/lan/v2.2/matchhistory/4130247?beginIndex=60&endIndex=74&api_key=5d8531ab-35eb-4502-8032-2dcd11a82683');
echo '<pre>';
var_dump(json_decode($response));

?>
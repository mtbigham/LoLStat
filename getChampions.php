<?php
/*
$champID = 222;

$baseURL = "https://na.api.pvp.net/api/lol/";
$mattAPIKEY = "dc2ba6c8-4971-4a8a-87a9-d3c59db6f26b";

$result = file_get_contents($baseURL . "static-data/na/v1.2/champion/" . $champID . "?champData=info&api_key=" . $mattAPIKEY);
$result = json_decode($result, true);

print_r($result);
*/

$result = json_decode(file_get_contents("https://global.api.pvp.net/api/lol/static-data/na/v1.2/champion?champData=all&api_key=5d8531ab-35eb-4502-8032-2dcd11a82683"), true);
$print_r($result);
?>
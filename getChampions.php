<?php

$response = file_get_contents('https://global.api.pvp.net/api/lol/static-data/na/v1.2/champion?champData=all&api_key=5d8531ab-35eb-4502-8032-2dcd11a82683');
echo '<pre>';
var_dump(json_decode($response));

?>
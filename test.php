<?php

$response = file_get_contents('https://lan.api.pvp.net/api/lol/lan/v2.2/matchhistory/4130247?api_key=5d8531ab-35eb-4502-8032-2dcd11a82683');
echo '<pre>';
var_dump(json_decode($response));

?>
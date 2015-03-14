<?php
	ini_set('display_errors',1);  
	error_reporting(E_ALL);
	
	$result = file_get_contents("https://lan.api.pvp.net/api/lol/lan/v2.5/league/challenger?type=RANKED_SOLO_5x5&api_key=dc2ba6c8-4971-4a8a-87a9-d3c59db6f26b");
	$result = json_decode($result,true);
	
	echo "<pre>";
	$result = $result['entries'];
		foreach($result as $player){
			foreach($player as $key => $val){
				${$key}[] = $val;
			}
		}
		
		array_multisort($leaguePoints, SORT_DESC, $result);
		//var_dump($result);
	for($i = 0; $i<10; $i++){
		echo "<b>",$result[$i]["playerOrTeamName"],"</b> LP: ",$result[$i]['leaguePoints'];
		echo "<br>";
	}
?>

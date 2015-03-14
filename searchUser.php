<?php

#GET SUMMONER ID FROM SUMMONER NAME
	$summonerName = htmlspecialchars($_POST['name']);
	$summonerName = rawurlencode($summonerName);

	$baseURL = "https://na.api.pvp.net/api/lol/";
	$mattAPIKEY = "dc2ba6c8-4971-4a8a-87a9-d3c59db6f26b";

	$result = file_get_contents($baseURL . "na/v1.4/summoner/by-name/" . $summonerName . "?api_key=" . $mattAPIKEY);
	$result = json_decode($result, true);

	$key = array_keys($result)[0];
	$summonerID = $result[$key]['id'];
	$summonerName = $result[$key]['name'];
	
#CHECK FOR A CURRENT GAME AND FIND THE CHAMPION THEY ARE PLAYING
	$championID = '';
	$game = file_get_contents("https://na.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/NA1/" . $summonerID . "?api_key=" . $mattAPIKEY);
	
	if($game){
		$game = json_decode($game, true);
		$matchIDS = [];
		//print_r($game);
		
		foreach($game['participants'] as $player){
			if($player['summonerName'] == $summonerName){
				$championID = $player['championId'];
				break;
			}
		}
		
		#SEARCH USER MATCH HISTORY FOR CHAMPIONID
		$matches = file_get_contents("https://na.api.pvp.net/api/lol/na/v2.2/matchhistory/" . $summonerID . "?championIds=" . $championID . "&rankedQueues=RANKED_SOLO_5x5&api_key=" . $mattAPIKEY);
		$matches = json_decode($matches, true);
		foreach($matches['matches'] as $match){
			$matchIDS[] = $match['matchId'];
		}
		print_r($matchIDS);
		
		#INSERT YOUR CODE HERE
	}
	else{
		echo "not currently playing a game";
	}

?>

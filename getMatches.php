<?php
/*
 For each match in matchIDs, aggregate metrics by minute
 
 HAVE: matchID, summonerID, champID
 SEARCH: participants->champID
 RETRIEVE: participants->participantID
 
 HAVE: matchID, summonerID, champID, participantID
 SEARCH: timeline->foreach(frames)->participantFrames[participantID]->gold, lvl, xp, etc
 */
 
 error_reporting(E_ALL);
 ini_set('display_errors', '1');
 
if(isset($_GET['summonerID']) && isset($_GET['champID']))
{
	$matchIDs = [137226490, 137269904];
	
	$stats = array();
	
	foreach($matchIDs as $match)
	{
		$myStats = array(
			"currentGold" => [],
			"totalGold" => [],
			"level" => [],
			"xp" => [],
			"minionsKilled" => [],
			"jungleMinionsKilled" => []
		);
		
		$game = json_decode(file_get_contents("https://lan.api.pvp.net/api/lol/lan/v2.2/match/{$match}?includeTimeline=true&api_key=5d8531ab-35eb-4502-8032-2dcd11a82683"));
		
		$partID = '';
		
		foreach($game->participants as $participant => $vals)
		{
			if($game->participants[$participant]->championId == $_GET['champID'])
			{
				$partID = $game->participants[$participant]->participantId;
			}
		}
		
		foreach($game->timeline->frames as $frame => $frameArr)
		{
			foreach($frameArr->participantFrames->$partID as $valName=>$val)
			{
				if(array_key_exists($valName, $myStats))
				{
					array_push($myStats[$valName], $val);
				}
			}
		}
		
		array_push($stats, $myStats);
	}
	print_r($stats);
	
	
	
	
	
	/*
    $myStats = array(
        "CSpm" => [],
        "XPpm" => [],
        "Gpm" => [],
        "CSpmd" => [],
        "XPpmd" => []
    );

    foreach($myGames->matches as $match)
    {
        array_push($myStats["CSpm"], $match->participants[0]->timeline->creepsPerMinDeltas);
        array_push($myStats["XPpm"], $match->participants[0]->timeline->xpPerMinDeltas);
        array_push($myStats["Gpm"], $match->participants[0]->timeline->goldPerMinDeltas);
        array_push($myStats["CSpmd"], $match->participants[0]->timeline->csDiffPerMinDeltas);
        array_push($myStats["XPpmd"], $match->participants[0]->timeline->xpDiffPerMinDeltas);
    }

    echo '<pre>';
    var_dump($myStats);

    $myStatsAvg = array(
        "zeroToTen" => ["CSpm" => 0.0, "XPpm" => 0.0, "Gpm" => 0.0, "CSpmd" => 0.0, "XPpmd" => 0.0],
        "tenToTwenty" => ["CSpm" => 0.0, "XPpm" => 0.0, "Gpm" => 0.0, "CSpmd" => 0.0, "XPpmd" => 0.0],
        "twentyToThirty" => ["CSpm" => 0.0, "XPpm" => 0.0, "Gpm" => 0.0, "CSpmd" => 0.0, "XPpmd" => 0.0],
        "thirtyToEnd" => ["CSpm" => 0.0, "XPpm" => 0.0, "Gpm" => 0.0, "CSpmd" => 0.0, "XPpmd" => 0.0]
    );

    foreach($myStats as $typeName => $type)
    {
        foreach($type as $gameNum => $game)
        {
            foreach($game as $key => $val)
            {
                if(array_key_exists($key, $myStatsAvg) && array_key_exists($typeName, $myStatsAvg[$key]))
                {
                    $myStatsAvg[$key][$typeName] += $val;
                }
            }
        }
    }

	foreach($myStatsAvg as $timeName => $time)
	{
		foreach($time as $typeName => $type)
		{
			$myStatsAvg[$timeName][$typeName] = $type / count($myStats["CSpm"]);
		}
	}

    echo '<pre>';
    var_dump($myStatsAvg);
	*/
}

?>

<?php

$championID = 67;

$matchIDS = array(
	"1681263045",
	"1684827093",
	"1684847240",
	"1686599293"
);

$csCounter = [];

$cs = [];
$level = [];
$gold = [];

foreach($matchIDS as $matchID){
	
	$api = "https://na.api.pvp.net/api/lol/na/v2.2/match/" . $matchID . "?includeTimeline=true&api_key=dc2ba6c8-4971-4a8a-87a9-d3c59db6f26b";
	$api = json_decode(file_get_contents($api),true);

	$participantID = '';

	foreach($api['participants'] as $player){
		if($player['championId'] == $championID){
			$participantID = $player['participantId'];
			break;
		}
	}

	//echo $participantID;

	$count = 0;
	foreach($api['timeline']['frames'] as $minute){
		//print_r($minute['participantFrames'][$participantID]);
		$handle = $minute['participantFrames'][$participantID];
		
		$cs[$count] += $handle['minionsKilled'];
			$csCounter[$count] += 1;
		$level[$count] += $handle['level'];
		$gold[$count] += $handle['totalGold'];

		$count++;
	}

	$herp = array("herp","derp");
	//echo ($herp[2] == NULL ? "nothing here" : $herp[2]);
}

$max = count($csCounter);
echo $max;
for($i = 0; $i<$max; $i++){
	$cs[$i] = $cs[$i] / $csCounter[$i];
	$level[$i] = $level[$i] / $csCounter[$i];
	$gold[$i] = $gold[$i] / $csCounter[$i];
}

echo "cs";
print_r($cs);
echo "level";
print_r($level);
echo "gold";
print_r($gold);
print_r($csCounter);
?>

<?php

if(isset($_POST['name']))
{
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
        //print_r($matchIDS);

        #SEARCH USER MATCHES TO RETRIEVE AVERAGE PERFORMANCE DATA
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

    }
    else{
        echo "not currently playing a game";
    }
}
else
{
    //ask for a post to be made?
}

?>
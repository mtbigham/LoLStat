<?php

/*
 * 1. Pull last 15 games for X champion
 * 2. Pull top 10 challengers
 *      a. foreach: search match history for X champion
 *      b. Compile all stats from 2a into single avg
 * 3. Compare user avg to pro summary
 * 4. Graph, etc.
 */

if(isset($_GET['champID']) && isset($_GET['summonerID']))
{
    $myGames = json_decode(file_get_contents("https://na.api.pvp.net/api/lol/na/v2.2/matchhistory/{$_GET['summonerID']}?championIds={$_GET['champID']}&api_key=5d8531ab-35eb-4502-8032-2dcd11a82683"));

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
    //var_dump($myStats);

    $myStatsAvg = array(
        "zeroToTen" => ["CSpm" => 0.0, "XPpm" => 0.0, "Gpm" => 0.0, "CSpmd" => 0.0, "XPpmd" => 0.0],
        "tenToTwenty" => ["CSpm" => 0.0, "XPpm" => 0.0, "Gpm" => 0.0, "CSpmd" => 0.0, "XPpmd" => 0.0],
        "twentyToThirty" => ["CSpm" => 0.0, "XPpm" => 0.0, "Gpm" => 0.0, "CSpmd" => 0.0, "XPpmd" => 0.0],
        "thirtyToEnd" => ["CSpm" => 0.0, "XPpm" => 0.0, "Gpm" => 0.0, "CSpmd" => 0.0, "XPpmd" => 0.0]
    );

    foreach($myStats as $typeName => $type)
    {
        //echo '<br>', $typeName, '<br>'; //$type = array
        foreach($type as $gameNum => $game)
        {
            //echo $gameNum, '<br>';
            foreach($game as $key => $val)
            {
                //echo "$key: $val<br>";

                if(array_key_exists($key, $myStatsAvg) && array_key_exists($typeName, $myStatsAvg[$key]))
                {
                    echo $myStatsAvg[$key[$typeName]]; //= $myStatsAvg[$key[$typeName]] + $val;
                }
            }
        }
    }

    //echo '<pre>';
    //var_dump($myStatsAvg);
}

?>
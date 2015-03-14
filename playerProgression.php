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
    var_dump($myStats);
}

?>
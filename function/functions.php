<?php


// function for start game
function gameStart($uniqueIds, $gameStart, $gameEnd) {
    global $connection;
    $query = "UPDATE player_group SET game_start = '".$gameStart."', game_end = '".$gameEnd."' WHERE player_group_id IN (".$uniqueIds.")";
    mysqli_query($connection, $query);
    echo "game started for ids ". $uniqueIds." \n";
}

// validate is game already running
function validateGame($groupId) {
    global $connection;
    $currentTime = time();
    $query = "SELECT game_end FROM player_group WHERE group_id = '".$groupId."' AND game_end >= '".$currentTime."' LIMIT 1";
    $result = mysqli_query($connection, $query);
    echo mysqli_num_rows($result)."\n";
    if (mysqli_num_rows($result)) {
        return true;
    }
    return false;
}

// function for get players details by groupId
function getPlayerAndGameInformation($groupId) {
    global $connection;
    $currentTime = time();
    $query = "SELECT * FROM player_group WHERE group_id = '".$groupId."' AND is_killed = 0 AND (game_end IS NULL OR game_end >= '".$currentTime."')";
    $result = mysqli_query($connection, $query);  
    $finalResult = array();  
    while ($res = mysqli_fetch_assoc($result)) {
        $finalResult[] = $res;
    }
   return $finalResult;
}

// function for get group Information
function getAllGroups() {
    global $connection;
    $currentTime = time();
    $query = "SELECT * FROM groups";
    $result = mysqli_query($connection, $query);  
    $finalResult = array();  
    while ($res = mysqli_fetch_assoc($result)) {
        $finalResult[] = $res;
    }
   return $finalResult;
}

//join Group
function joinGroup($groupId, $playerId, $playerName) {
    global $connection;
    $query = "INSERT INTO player_group (group_id, player_id, player_name) VALUES ('".$groupId."', '".$playerId."', '".$playerName."')";
    mysqli_query($connection, $query);    
}

function maintainHitCount($playerGroupId) {
    global $connection;
    $query = "UPDATE player_group SET hit_count = hit_count+1 WHERE player_group_id = ".$playerGroupId;

    mysqli_query($connection, $query);    
}





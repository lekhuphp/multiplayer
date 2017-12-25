<?php 
require('config/connection.php');
require_once('function/functions.php');
try {
    $groupId = $_REQUEST['groupId'];
    $playerId = $_REQUEST['playerId'];
    $playerName = $_REQUEST['playerName'];
    sleep(1);
    $playerLists = getPlayerAndGameInformation($groupId);
    $result = array('status' => false);
    $validatePlayer = false;
 

    if($playerLists) {
        foreach($playerLists as $playerList) {
            if($playerList['player_id'] == $playerId) {
                $validatePlayer = true;
            }
        } 
    }

    if(!$validatePlayer) {
        if(count($playerLists) >= 5) {
            $result['message'] = "Queue is full. Only 5 Members are Allowed";
            echo json_encode($result); die; 
        }

        joinGroup($groupId, $playerId, $playerName);
    }

    $result['status'] = true;
    $result['message'] = "Group Joined";
    echo json_encode($result);

} catch (\Exeption $e) {
  $result['message'] = "Internal Error!";
  echo json_encode($result);
}





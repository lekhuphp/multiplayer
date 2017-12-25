<?php
require('config/connection.php');
require_once('function/functions.php');

echo "Game Starter Start \n";
try {
    while (true) {
        sleep(2);
        $query = "SELECT count(*) count, group_concat(player_group_id) as unique_ids, group_id FROM player_group WHERE game_start IS NULL GROUP BY group_id having count >= ".REQUIRED_PLAYER;
        $result = mysqli_query($connection, $query);
        while($res = mysqli_fetch_assoc($result)) {
            print_r($res);
            if(validateGame($res['group_id'])) {
                continue; 
            }
            $game_start = time() + MARGIN_TIME_IN_SECOND;
            $game_end = $game_start + GAME_RUNNIG_TIME_IN_SECOND; 
            gameStart($res['unique_ids'], $game_start, $game_end);
        
        }
        echo "loop End \n\n\n";        
    }
} catch (\Exception $e) {
    echo $e->getMessage()."\n";   
}


?>

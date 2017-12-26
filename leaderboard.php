<?php 
require('config/connection.php');
require_once('function/functions.php');

$type = WEEKLY;
$leaderboardData = array();
if(isset($_REQUEST['type']) && $_REQUEST['type'] == MONTHLY) {
    $type = MONTHLY;
    $leaderboardData = getMonthlyTopPlayers(LIMIT);
} else {
    $leaderboardData = getWeeklyTopPlayers(LIMIT);
}

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<h2>Select Type</h2>


<div class="dropdown">
    <button class="dropbtn"><?php echo ucfirst($type);?></button>
  <div class="dropdown-content">
    <a href="?type=weekly">Weekly</a>
    <a href="?type=monthly">Monthly</a>    
  </div>
</div>
<table id="player">
  <tr>
    <th>Name</th>
    <th>Points</th>    
  </tr>
  <?php if($leaderboardData) {
      foreach($leaderboardData as $leaderboard) {
          echo "<tr><td>".$leaderboard['player_name']."</td><td>".$leaderboard['points']."</td></tr>";
      }
  } else {
      echo "No Records Found!";
  }
  ?>  
</table>
</body>
</html>



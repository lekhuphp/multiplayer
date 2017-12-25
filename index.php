<!DOCTYPE html>
<html>
<head>
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/styles.css">
</head>

<?php 
$playerName = '';
session_start();
$playerId = session_id();
if(isset($_SESSION['player_name']) && $_SESSION['player_name']) {
$playerName = $_SESSION['player_name'];
} else if(isset($_REQUEST['player_name']) && $_REQUEST['player_name']) {
  $_SESSION['player_name'] = $_REQUEST['player_name'];
  $playerName = $_REQUEST['player_name'];
}

if(isset($_REQUEST['group_id']) && $_REQUEST['group_id'] && $playerName) {
  $groupId = $_REQUEST['group_id'];
?>
<div class="dn" id="playerList"><b>Player List</b><table></table></div>
<div class="dn" id="queueList"><b>Queue List</b><table></table></div>
<center><span id="timer"></span><h1 id="_start_hit"></h1><h1 id="_start"></h1></center>
<script type="text/javascript">
$("document").ready(function() {
    var group_id = "<?php echo $groupId;?>";
    var player_id = "<?php echo $playerId;?>";
    var player_name = "<?php echo $playerName;?>";
    startGame(group_id, player_id, player_name);
    setInterval(function()
{ 
    
     $.ajax({
      type: "GET",      
      url: "gameStart.php", 
      data: {groupId: group_id, playerId: player_id},
      success: function(data) { 
        var data = JSON.parse(data);
        $('#playerList').find('table').html('');
        $('#queueList').find('table').html('');
        $('#queueList').hide();
        $('#_start').html('');
        if (data.length > 0) {
            if(data.length==1) {
                $('#timer').html('Waiting for Other participants....');
                $('#playerList').hide();
            }
            var d = new Date();            
            var d = new Date();
            var n = Math.floor(d.getTime()/1000);
            var myid = false;   
            var hitme = false;            
            for (var i = 0; i < data.length; i++) {
                if(data[i]['game_start']) {
                    $('#playerList').show();
                    $('#playerList').find('table').append("<tr><td class='active'>"+data[i]['player_name']+"</td></tr>");
                    startTime = data[i]['game_start'] - n;
                    if(startTime > 0 ) {
                        $('#_start').html('');
                        $('#timer').html("Game will be start within "+ (startTime) + ' seconds');
                        continue;                        
                    }
                    if (data[i]['game_end'] - n > 0) {
                        $('#timer').html(data[i]['game_end'] - n);
                        if(player_id == data[i]['player_id']) {
                            myid = true;
                            $('#_start').html('');
                            hitme = true;
                            pgi = data[i]['player_group_id'];        
                        }
                     
                    } else { 
                        $('#timer').html('Game Over');
                        $('#_start_hit').html('');                       
                       
                    }                                                            
                     
                } else {                   
                    $('#queueList').show();
                    if(player_id == data[i]['player_id']) {
                        myid = true;
                        $('#_start_hit').html('');
                    }
                    $('#queueList').find('table').append("<tr><td class='inactive'>"+data[i]['player_name']+"</td></tr>");
                }
            }

        if(!myid) {
            $('#_start').html('<button>Start</button>');
        }
        if(hitme) {
            $('#_start_hit').html("<button id = '"+pgi+"'>Hit Me</button>");
        } else {
            $('#_start_hit').html("");
        }
        } else { 
            $('#timer').html('Waiting for new game to start...');
            $('#_start_hit').html('');   
            $('#_start').html('<button>Start</button>');         
            $('#playerList').hide();
            $('#queueList').hide();    
        } 
      }
    });
}, 1000);  
  

function startGame(group_id, player_id, player_name) {
     $.ajax({
      type: "POST",      
      url: "joinPlayer.php", 
      data: {groupId: group_id, playerId: player_id, playerName: player_name},
      success: function(data) { 
      console.log(data);
      var data = JSON.parse(data);
      if(!data.status) {
          alert(data.message);
      }
      }
    });
}

$('#_start').click(function() {
    location.reload();
})

$('#_start_hit').click(function() {
   player_group_id = $(this).find("button").attr('id');
   $.ajax({
      type: "POST",      
      url: "hitCount.php", 
      data: {playerGroupId: player_group_id, count: 1},
      success: function(data) { 
      }
    });
})

   
});
</script>
<?php } else { 
require('config/connection.php');
require_once('function/functions.php');
$groupDetails = getAllGroups();
echo "<h2>Join Groups</h2><div class='row'>";
if($groupDetails) {
    foreach($groupDetails as $groupDetail) {
        echo "<form><div class='column'>
        <h2>".$groupDetail['group_name']."</h2>         
        <input type='hidden' name='group_id' value='".$groupDetail['group_id']."'>";
        if(!$playerName) {
            echo "Enter your Name";
            echo "<input type='text' name='player_name' required>";
        }
        echo "<input type='submit' value='Join'></div></form>";
    }
} else {
   echo "No groups Found";
}
  
echo "</div>";

} ?>



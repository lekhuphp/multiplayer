<?php 
require('config/connection.php');
require_once('function/functions.php');

$groupId = $_REQUEST['groupId'];
$playerId = $_REQUEST['playerId'];
echo json_encode(getPlayerAndGameInformation($groupId));






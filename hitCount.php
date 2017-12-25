<?php 
require('config/connection.php');
require_once('function/functions.php');

$playerGroupId = $_REQUEST['playerGroupId'];
maintainHitCount($playerGroupId);






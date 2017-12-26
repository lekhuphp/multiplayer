<?php 
ini_set('display_errors', 1);
$connection = mysqli_connect('localhost', 'root', 'root', 'multiplayer_game');
define('MARGIN_TIME_IN_SECOND', 3);
define('GAME_RUNNIG_TIME_IN_SECOND', 15);
define('REQUIRED_PLAYER', 2);
define('MONTHLY', 'monthly');
define('WEEKLY', 'weekly');
define('LIMIT', 10);

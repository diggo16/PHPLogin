<?php
session_start();
//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once('controller/StartController.php');

$controller = new StartController();
$controller->showWebsite();

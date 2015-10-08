<?php
session_start();
//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once('controller/StartController.php');
require_once('model/User.php');
require_once('view/LoginView.php');
require_once('controller/LoginController.php');


$user = new User();

$loginController = new LoginController(new LoginView());

$controller = new StartController($user, $loginController);
$controller->changeUser();
$controller->showWebsite();

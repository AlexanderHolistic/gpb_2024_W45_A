<?php
require_once 'User.php';
session_start();

$user = new User($db);
$user->logout();
header('Location: login.php');
exit;

<?php

session_start();
error_reporting(1);

$_SESSION['input']   = json_encode(file_get_contents('php://input'), true);
include (__DIR__.'/../src/Deezer.php');


$deezer = new deezer\Deezer();
$deezer->execute();

?>

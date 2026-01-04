<?php 
require_once 'db.php';

session_start();
logout();
redirectAndExit('index.php');
?>
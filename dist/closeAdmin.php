<?php
session_start();
//if(isset($_SESSION['user_active'])) session_destroy();
//header("Location: loginEsDoc.php");
if(isset($_SESSION['user_authorized'])){
  	session_destroy();
  	header("Location: login.php");
 }
?>
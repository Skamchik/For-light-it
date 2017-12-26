<?php
session_start();
require "classes.php";
  		if (isset($_POST['addmessage'])) {
  			$username = $_SESSION['name'];
  			$perentid = $_POST['perentid'];
  			$text = $_POST['message'];
  			$text = trim($text);
		    $text = stripslashes($text);
		    $text = strip_tags($text);
		    $text = htmlspecialchars($text);
  			$message = new message($username, $text, $perentid);
  			$message->intoDB();
  			header ('Location:../fb.php');
  			exit;

  		};
  	 ?>
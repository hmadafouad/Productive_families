<?php 
session_start();
include 'include.php'; 

if(isset($_GET['itemid'] , $_GET['rating'])) {
	$itemid = $_GET['itemid'];
	$rating = $_GET['rating'];


	if(in_array($rating , [1,2,3,4,5] )){

		$insert=$connect-> prepare("
		INSERT INTO 
		rating(Rating,Item_ID)
		VALUES
		( {$rating}, {$itemid} )");
$insert->execute();
}

header('Location:items.php?do=disp&itemid='.$itemid.' ');
}

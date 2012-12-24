<?php
// 
//  utils.php
//  
//  Created by Aleks on 2012-05-20.
//  Copyright 2012 Aleks. All rights reserved.
// 

$name = $_SERVER['REMOTE_ADDR'];
$vote = "";
$file = 0;
$resultsFile = "results";
$voteFile = "vote";
$newFile = "new";

if (isset($_GET['vote'])) {
	$vote = $_GET['vote'];
}
if (isset($_POST['vote'])) {
	$vote = $_POST['vote'];
}

function createColor($v) {
	$red = ($v & 0x04) ? 0xFF - (($v / 8) * 0x40) : 0x00;
	$blue = ($v & 0x02) ? 0xFF - (($v / 8) * 0x40) : 0x00;
	$green = ($v & 0x01) ? 0xFF - (($v / 8) * 0x40) : 0x00;
	return sprintf('#%06X', (($red<<16) | ($blue<<8) | $green) % 0xFFFFFF);
}

function lockIt() {
	global $file;
	$file = fopen('db/.lock', 'r');
	if ($file == false)
		exit("Permissions problem");
	if (flock($file, LOCK_EX) == false) {
		exit("Lock problem");
	}
	return simplexml_load_file('db/data.xml');
}

function unlockIt() {
	global $file;
	fclose($file);
}
?>

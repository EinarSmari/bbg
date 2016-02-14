<?php
 
session_start();

$name = $_SESSION['username'];
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/dump.include.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
require $_SERVER['DOCUMENT_ROOT'] . '/browsergame/inc/logincheck.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/stats.function.php';
 

 
$phand = getStat('phand',$userID);
$shand = getStat('shand',$userID);
if($_POST) {
	setStat('phand',$userID,$shand);
	setStat('shand',$userID,$phand);
	$temp = $shand;
	$shand = $phand;	
	$phand = $temp;
}

try
{
	$sql = "SELECT name FROM items WHERE id = :phand";
	$s = $pdo->prepare($sql);
	$s->bindValue(':phand', $phand);
	$s->execute();			
}
catch (PDOException $e)
{
	$error = 'Error fetching primary hand.' . $e->getMessage();
	include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
	exit();
}

if($s) {
	list($phand_name) = $s->fetch(PDO::FETCH_ASSOC);
	$phand = $phand_name;
}

try
{
	$sql = "SELECT name FROM items WHERE id = :shand";
	$s = $pdo->prepare($sql);
	$s->bindValue(':shand', $shand);
	$s->execute();			
}
catch (PDOException $e)
{
	$error = 'Error fetching secondary hand.' . $e->getMessage();
	include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
	exit();
}

if($result) {
	list($shand_name) = $s->fetch(PDO::FETCH_ASSOC);
	$shand = $shand_name;
}

require 'equipment.html.php'; 
?>
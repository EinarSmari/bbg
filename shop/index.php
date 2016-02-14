<?php
 
 
session_start();
$name = $_SESSION['username'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';		// our database settings
require $_SERVER['DOCUMENT_ROOT'] . '/browsergame/inc/logincheck.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/stats.function.php';

$phand = getStat('phand',$userID);
$shand = getStat('shand',$userID);
if($_POST) {
	if($_POST['sell']) {
		$weaponID = getStat($_POST['sell'],$userID);
		try
		{
			$sql = "SELECT price FROM items WHERE id = :weaponid";
			$s = $pdo->prepare($sql);
			$s->bindValue(':weaponid', $weaponID);
			$s->execute();			
		}
		catch (PDOException $e)
		{
			$error = 'Error fetching weapon price.' . $e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
			exit();
		}
		list($price) = $s->fetch();
		$gold = getStat('gc',$userID);
		setStat('gc',$userID,($gold + $price));
		setStat($_POST['sell'],$userID,'');
		$phand = getStat('phand',$userID);
		$shand = getStat('shand',$userID);
	} else {
		$weaponID = $_POST['weapon-id'];
		try
		{
			$sql = "SELECT price FROM items WHERE id = :weaponid";
			$s = $pdo->prepare($sql);
			$s->bindValue(':weaponid', $weaponID);
			$s->execute();			
		}
		catch (PDOException $e)
		{
			$error = 'Error fetching weapon price.' . $e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
			exit();
		}
		list($cost) = $s->fetch();
		$gold = getStat('gc',$userID);
		if($gold > $cost) {
			// subtract gold, equip weapon, go from there.
			if(!$phand) {
				setStat('phand',$userID,$weaponID);
				setStat('gc',$userID,($gold - $cost));
				$phand = $weaponID;
				$message = 'You equipped the weapon in your primary hand.';
			} else {
				if(!$shand) {
					setStat('shand',$userID,$weaponID);
					setStat('gc',$userID,($gold - $cost));
					$shand = $weaponID;
					$message = 'You equipped the weapon in your secondary hand.';
				} else {
					$error = 'You already have two weapons! You must sell one before equipping another one.';
				}
			}
		} else {
			$error = 'You cannot afford that weapon!';
		}
	}
}
try
{
	$result = $pdo->query("SELECT DISTINCT(id), name, price FROM items WHERE type = 'Weapon' ORDER BY RAND() LIMIT 5;");
}
catch (PDOException $e)
{
	$error = 'Error fetching weapon list.' . $e->getMessage();
	include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
	exit();
}
$weapons = array();
while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	array_push($weapons,$row);
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
	$error = 'Error fetching phand status.' . $e->getMessage();
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
	$error = 'Error fetching weapon price.' . $e->getMessage();
	include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
	exit();
}

if($s) {
	list($shand_name) = $s->fetch(PDO::FETCH_ASSOC);
	$shand = $shand_name;
}
require "shop.html.php"; 
?>
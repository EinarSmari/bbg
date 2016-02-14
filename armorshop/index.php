<?php
  
session_start();
$name = $_SESSION['username'];
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/dump.include.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
require $_SERVER['DOCUMENT_ROOT'] . '/browsergame/inc/logincheck.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/stats.function.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/armorstats.function.php';
 
if($_POST) {
	if($_POST['sell']) {
		$armorSlot = getArmorStat('aslot',$_POST['sell']);
		$armorID = getStat($armorSlot,$userID);
		try
		{
			$sql = 'SELECT price FROM items WHERE id = :armorid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':armorid', $armorID);
			$s->execute();
		}
		catch (PDOException $e)
		{
			$error = 'Error item price details.';
			include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
			exit();
		}
		list($price) = $s->fetch(PDO::FETCH_ASSOC);
		$gold = getStat('gc',$userID);
		setStat('gc',$userID,($gold + $price));
		setStat($armorSlot,$userID,'');		
	} else {	
		$armorID = $_POST['armor-id'];
		try
		{
			$sql = 'SELECT price FROM items WHERE id = :armorid';
			$s = $pdo->prepare($sql);
			$s->bindValue(':armorid', $armorID);
			$s->execute();
		}
		catch (PDOException $e)
		{
			$error = 'Error item cost details.';
			include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
			exit();
		}
		list($cost) = $s->fetch(PDO::FETCH_ASSOC);
		$gold = getStat('gc',$userID);
		if ($gold > $cost) {
			$slot = getArmorStat('aslot',$armorID);
			$equipped = getStat($slot,$userID);
			if(!$equipped) {
				setStat($slot,$userID,$armorID);
				setStat('gc',$userID,($gold - $cost));
				$message = 'You purchased and equipped the new armor.';
			} else {
				// they already have something equipped - display an error
				$error ='You are already wearing a piece of that kind of armor! You will need to sell your current armor before you can buy new armor.';
			}
		} else {
			$error = 'You cannot afford that piece of armor.';
		}
	}
}
try
{
	$result = $pdo->query('SELECT DISTINCT(id), name, price FROM items WHERE type = \'Armor\' ORDER BY RAND() LIMIT 10');
}
catch (PDOException $e)
{
	$error = 'Error fetching item name and price from the database!';
	include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
	exit();
}
foreach ($result as $row)
{
	$armor[] = array('id' => $row['id'], 'name' => $row['name'], 'price' => $row['price']);
}

$stats = array('atorso','ahead','alegs','aright','aleft');
foreach ($stats as $key) {
	$id = getStat($key,$userID);
	try
	{
		$sql = 'SELECT name FROM items WHERE id = :id';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $id);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error getting name from items,';
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}

	if($s) {
		list($name) = $s->fetch(PDO::FETCH_ASSOC);
		$key = $name;
	}
}

include 'armorshop.html.php'; 
?>
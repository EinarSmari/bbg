<?php
 
 
session_start();

$name = $_SESSION['username'];

require $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
require $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/items.function.php';
require $_SERVER['DOCUMENT_ROOT'] . '/browsergame/inc/logincheck.inc.php';


 
$actions = array('potion' => 'use_potion','crystal_ball' => 'use_crystal_ball');
 
if($_POST) {
	if($_POST['item-id']) {
	
		try
		{
			$sql = "SELECT item_id FROM user_items WHERE user_id = :userid AND id = :id";
			$s = $pdo->prepare($sql);
			$s->bindValue(':userid', $userID);
			$s->bindValue(':id', $_POST['item-id']);
			$s->execute();			
		}
		catch (PDOException $e)
		{
			$error = 'Error item id.' . $e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
			exit();
		}
		list($itemID) = $s->fetch();		
		$token = getItemStat('token',$itemID);
		call_user_func($actions[$token]);
	}
}
try
{
			$sql = "SELECT 
						user_items.id, user_items.item_id, user_items.quantity, items.name 
					FROM 
						user_items 
							INNER JOIN
						items
							ON user_items.item_id = items.id
					WHERE 
						user_items.user_id = :userid";
			$s = $pdo->prepare($sql);
			$s->bindValue(':userid', $userID);
			$s->execute();
}
catch (PDOException $e)
{
	$error = 'Error getting quantity and name of items!' . $e->getMessage();
	include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
	exit();
}
foreach ($s as $row)
{
	$invetory[] = array('id' => $row['user_items.id'], 'itemid' => $row['user_items.item_id'],  'name' => $row['items.name'], 'quantity' => $row['user_items.quantity']);
}
function use_potion() {
	echo 'This is code that would run when the user used a potion.';
}
function use_crystal_ball() {
	echo 'This is code that would run when the user used a crystal ball.';
}


require 'inventory.html.php';
 

?>
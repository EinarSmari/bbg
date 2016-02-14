<?php
  
session_start();
 
$name = $_SESSION['username'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';		// our database settings
require $_SERVER['DOCUMENT_ROOT'] . '/browsergame/inc/logincheck.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/stats.function.php';

if($_POST) {
	if($_POST['item-id']) {
		$itemID = $_POST['item-id'];
		try
		{
			$sql = "SELECT price FROM items WHERE id = :itemid";
			$s = $pdo->prepare($sql);
			$s->bindValue(':weaponid', $itemID);
			$s->execute();			
		}
		catch (PDOException $e)
		{
			$error = 'Error fetching item price.' . $e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
			exit();
		}
		list($cost) = $s->fetch();
		$gold = getStat('gc',$userID);
		if($gold >= $cost) {
			setStat('gc',$userID,($gold - $cost));
			try
			{
				$sql = "SELECT COUNT(id) FROM user_items WHERE user_id = :userid AND item_id = :item_id";
				$s = $pdo->prepare($sql);
				$s->bindValue(':itemid', $itemID);
				$s->bindValue(':userid', $userID);
				$s->execute();			
			}
			catch (PDOException $e)
			{
				$error = 'Error counting items.' . $e->getMessage();
				include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
				exit();
			}			
			list($count) = $s->fetch();
			if ($count > 0) {
				# already has one of the item
				try
				{
					$sql = "UPDATE user_items
							SET
								quantity = quantity + 1
							WHERE
								user_id = :userid AND item_id = :itemid";
					$s = $pdo->prepare($sql);
					$s->bindValue(':itemid', $itemID);
					$s->bindValue(':userid', $userID);
					$s->execute();			
				}
				catch (PDOException $e)
				{
					$error = 'Error counting items.' . $e->getMessage();
					include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
					exit();
				}	
			} else {
				# has none - new row
				try{
					$sql = "INSERT INTO
								user_items
							SET
								quantity = 1
								,user_id = :userid
								,item_id = :itemid";
					$s = $pdo->prepare($sql);
					$s->bindValue(':itemid', $itemID,PDO::PARAM_INT);
					$s->bindValue(':userid', $userID,PDO::PARAM_INT);

					$s->execute();
				}
				catch (PDOException $e)
				{

					$error = 'Error inserting into user item list.';
					include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
					exit();
				}
			}
			$message = "You purchased the item.";
		} else {
			$error ='You cannot afford that weapon!';
		}
	} else if($_POST['sell-id']) {
		$itemID = $_POST['sell-id'];
		try
		{
			$sql = "SELECT price FROM items WHERE id = :itemid";
			$s = $pdo->prepare($sql);
			$s->bindValue(':itemid', $itemID);
			$s->execute();			
		}
		catch (PDOException $e)
		{
			$error = 'Error getting cost for items.' . $e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
			exit();
		}			
		list($cost) = $s->fetch();
		$gold = getStat('gc',$userID);
		setStat('gc',$userID,($gold + $cost));
		try
		{
			$sql = "SELECT quantity FROM user_items WHERE user_id = :userid AND item_id = :itemid";
			$s = $pdo->prepare($sql);
			$s->bindValue(':itemid', $itemID);
			$s->bindValue(':userid', $userID);
			$s->execute();			
		}
		catch (PDOException $e)
		{
			$error = 'Error getting quantity for items.' . $e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
			exit();
		}			
		list($quantity) = $s->fetch();

		if ($quantity > 1) {
			try
			{
				$sql = "UPDATE user_items
						SET
							quantity = quantity - 1
						WHERE
							user_id = :userid AND item_id = :itemid";
				$s = $pdo->prepare($sql);
				$s->bindValue(':itemid', $itemID);
				$s->bindValue(':userid', $userID);
				$s->execute();			
			}
			catch (PDOException $e)
			{
				$error = 'Error counting items.' . $e->getMessage();
				include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
				exit();
			}
		} else {
			try
			{
				$sql = "DELETE FROM user_items
						WHERE
							user_id = :userid AND item_id = :itemid";
				$s = $pdo->prepare($sql);
				$s->bindValue(':itemid', $itemID);
				$s->bindValue(':userid', $userID);
				$s->execute();			
			}
			catch (PDOException $e)
			{
				$error = 'Error counting items.' . $e->getMessage();
				include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
				exit();
			}
		}
		$message  = 'You sold the item.';
	}
}
try
{
	$result = $pdo->query("SELECT DISTINCT(id), name, price FROM items WHERE type = 'Usable' ORDER BY RAND() LIMIT 5");
}
catch (PDOException $e)
{
	$error = 'Error usable items!';
	include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
	exit();
}
foreach ($result as $row)
{
	$items[] = array('id' => $row['id'], 'name' => $row['name'], 'price' => $row['price']);
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
foreach ($result as $row)
{
	$invetory[] = array('id' => $row['user_items.id'], 'itemid' => $row['user_items.item_id'],  'name' => $row['items.name'], 'quantity' => $row['user_items.quantity']);
}
	
require 'itemshop.html.php';
?>
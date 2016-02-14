<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/dump.include.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/drystats.function.php';


function getItemStat($statName,$userID) {
	return getStatDRY('user',$statName,$userID);
}
function setItemStat($statName,$userID,$value) {
	setStatDRY('user',$statName,$userID,$value);
}
/*


function getItem($itemID) {
	settype($itemID, "int");

	require $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	try
	{
		$sql = "SELECT name, type
		FROM 
			items
		WHERE 
			id = :itemid";
		$s = $pdo->prepare($sql);
		$s->bindValue(':itemid',$itemID);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error fetching weapon list.' . $e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}	
	$item = $s->fetch(PDO::FETCH_ASSOC);
	$item['id']	= $itemID;
	return $item;
}

function getItemStat($statName,$itemID) {
	require $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	settype($itemID, "int");

	createIfNotExistsItem($statName,$itemID);
	try
	{
		$sql = "SELECT value
		FROM 
			item_stats
		WHERE 
			stat_id = (SELECT id FROM stats WHERE short_name = :shortname) AND item_id = :itemid";		
		$s = $pdo->prepare($sql);
		$s->bindValue(':shortname',$statName);
		$s->bindValue(':itemid',$itemID);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error fetching item value list list.' . $e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}	
	list($value) = $s->fetch();
	return $value;
		
}
function setItemStat($statName,$itemID,$value) {
	require $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	settype($itemID, "int");

	createIfNotExistsItem($statName,$itemID);
	try
	{
		$sql = "UPDATE item_stats SET 
		value = :value 
		WHERE stat_id = 
			(SELECT id 
			FROM stats 
			WHERE short_name = :shortname) 
			AND item_id = :itemid";
		$s = $pdo->prepare($sql);
		$s->bindValue(':value',$value,PDO::PARAM_INT);
		$s->bindValue(':shortname',$statName);
		$s->bindValue(':itemid', $itemID,PDO::PARAM_INT);
		$s->execute();
	}
	catch (PDOException $e)
	{	
		$error = 'Error updating item stats value list.' . $e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}
		
}

 
function createIfNotExistsItem($statName,$itemID) {
	require $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	settype($itemID, "int");

	try
	{ 
		$sql = "SELECT COUNT(value)
		FROM
			item_stats
		WHERE
			stat_id =(
				SELECT id
				FROM
					stats
				WHERE
					short_name = :shortname)
					AND item_id = :itemid";
		$s = $pdo->prepare($sql);
		$s->bindValue(':shortname',$statName);
		$s->bindValue(':itemid', $itemID,PDO::PARAM_INT);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error counting item stats value list.';
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}
	
	list($count) = $s->fetch();


	if((int)$count == "0") {
		// the stat doesn't exist; insert it into the database
		try{ 
			$sql = "INSERT INTO
						item_stats
					SET
						stat_id = (SELECT id FROM stats WHERE short_name = :shortname)
						,item_id = :itemid
						,value = 0";
			$s = $pdo->prepare($sql);
			$s->bindValue(':shortname', $statName,PDO::PARAM_STR);
			$s->bindValue(':itemid', $itemID,PDO::PARAM_INT);

			$s->execute();
		}
		//catch (PDOException $e)
			catch (Exception $e) 
		{

			$error = 'Error inserting into user stats list.';
			include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
			exit();
		}
	}	
}
*/

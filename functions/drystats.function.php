<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/dump.include.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';

function getStatDRY($type,$statName,$trackingID) {
	createIfNotExistsDRY($type,$statName,$trackingID);
	require $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';

	try
	{
		$sql = "SELECT value
		FROM 
			entity_stats
		WHERE 
			stat_id =(SELECT id FROM stats WHERE short_name = :shortname) AND entity_id = :trackingid AND entity_type = :type";
		$s = $pdo->prepare($sql);
		$s->bindValue(':shortname',$statName);		
		$s->bindValue(':type',$type);
		$s->bindValue(':trackingid',$trackingID);		
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error fetching DRY stats value list.' . $e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}	
	list($value) = $s->fetch();
	return $value;
}	

function setStatDRY($type,$statName,$trackingID,$value) {
	include $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	settype($trackingID, "int");
	settype($value, "int");


	createIfNotExistsDRY($type,$statName,$trackingID);
	try
	{
		$sql = "UPDATE entity_stats SET 
		value = :value 
		WHERE stat_id = 
			(SELECT id 
			FROM stats 
			WHERE short_name = :shortname) 
			AND entity_id = :trackingid
			AND entity_type = :type";
		$s = $pdo->prepare($sql);
		$s->bindValue(':value',$value);
		$s->bindValue(':type',$type);
		$s->bindValue(':shortname',$statName);		
		$s->bindValue(':trackingid',$trackingID);
		$s->execute();
	}
	catch (PDOException $e)
	{	
		$error = 'Error updating DRY stats value list.' . $e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}
		
}

function createIfNotExistsDRY($type,$statName,$trackingID) {


	include $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';

	try
	{
		
		$sql = "SELECT COUNT(value) FROM entity_stats
		WHERE stat_id = (SELECT id FROM stats WHERE short_name = :shortname)AND entity_id = :trackingid AND entity_type = :type";
		$s = $pdo->prepare($sql);
		$s->bindValue(':type',$type);
		$s->bindValue(':shortname',$statName);		
		$s->bindValue(':trackingid',$trackingID);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error counting DRY stats value list.' . $e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}
	
	list($count) = $s->fetch();


	if((int)$count == "0") {
		// the stat doesn't exist; insert it into the database
		try{
			$sql = "INSERT INTO
						entity_stats
					SET
						stat_id = (SELECT id FROM stats WHERE short_name = :shortname)
						,entity_id = :trackingid
						,value = 0
						,entity_type = :type";
			$s = $pdo->prepare($sql);
			$s->bindValue(':shortname',$statName);		
			$s->bindValue(':trackingid',$trackingID);
			$s->bindValue(':type',$type);
			$s->execute();
		}
		//catch (PDOException $e)
			catch (Exception $e) 
		{

			$error = 'Error inserting into DRY stats list.';
			include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
			exit();
		}
	}	
}
	



?>
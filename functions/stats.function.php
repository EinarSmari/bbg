<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/dump.include.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/drystats.function.php';


function getStat($statName,$userID) {
	return getStatDRY('user',$statName,$userID);
}
function setStat($statName,$userID,$value) {
	setStatDRY('user',$statName,$userID,$value);
}
/*
function getStat($statName,$userID) {
	settype($userID, "int");
	require $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	createIfNotExists($statName,$userID);
	try
	{
		$sql = "SELECT user_stats.value
		FROM 
		user_stats
			INNER JOIN 
		stats
			ON user_stats.stat_id = stats.id
		WHERE 
			stats.short_name = :shortname
			AND user_stats.user_id = :userid";
		$s = $pdo->prepare($sql);
		$s->bindValue(':shortname',$statName);
		$s->bindValue(':userid', $userID,PDO::PARAM_INT);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error fetching user stats value list.' . $e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}	
	list($value) = $s->fetch();
	return $value;
}
function setStat($statName,$userID,$value) {
	include $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	settype($userID, "int");
	settype($value, "int");


	createIfNotExists($statName,$userID);
	try
	{
		$sql = "UPDATE user_stats SET 
		value = :value 
		WHERE stat_id = 
			(SELECT id 
			FROM stats 
			WHERE short_name = :shortname) 
			AND user_id = :userid";
		$s = $pdo->prepare($sql);
		$s->bindValue(':value',$value,PDO::PARAM_INT);
		$s->bindValue(':shortname',$statName);
		$s->bindValue(':userid', $userID,PDO::PARAM_INT);
		$s->execute();
	}
	catch (PDOException $e)
	{	
		$error = 'Error updating user stats value list.' . $e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}
		
}

function createIfNotExists($statName,$userID) {


	include $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	try
	{
		$sql = "SELECT COUNT(value)
		FROM
			user_stats
		WHERE
			stat_id =(
				SELECT id
				FROM
					stats
				WHERE
					short_name = :shortname)
					AND user_id = :userid";
		$s = $pdo->prepare($sql);
		$s->bindValue(':shortname',$statName);
		$s->bindValue(':userid', $userID,PDO::PARAM_INT);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error counting user stats value list.';
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}
	
	list($count) = $s->fetch();


	if((int)$count == "0") {
		// the stat doesn't exist; insert it into the database
		try{
			$sql = "INSERT INTO
						user_stats
					SET
						stat_id = (SELECT id FROM stats WHERE short_name = :shortname)
						,user_id = :userid
						,value = 0";
			$s = $pdo->prepare($sql);
			$s->bindValue(':shortname', $statName,PDO::PARAM_STR);
			$s->bindValue(':userid', $userID,PDO::PARAM_INT);

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
}*/

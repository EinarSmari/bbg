<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/drystats.function.php';


function getMonsterStat($statName,$userID) {
	return getStatDRY('user',$statName,$userID);
}
function setMonsterStat($statName,$userID,$value) {
	setStatDRY('user',$statName,$userID,$value);
}
/*


function getMonsterStat($statName,$monsterID) {
	settype($monsterID, "int");
	include $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	createMonsterStatIfNotExists($statName,$monsterID);
	try
	{
		$sql = "SELECT monster_stats.value
		FROM 
		monster_stats
			INNER JOIN 
		stats
			ON monster_stats.stat_id = stats.id
		WHERE 
			stats.short_name = :shortname
			AND monster_stats.monster_id = :monsterid";
		$s = $pdo->prepare($sql);
		$s->bindValue(':shortname',$statName);
		$s->bindValue(':monsterid', $monsterID,PDO::PARAM_INT);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error fetching monster stats value list.' . $e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}	
	list($value) = $s->fetch();
	return $value;
}
 
function createMonsterStatIfNotExists($statName,$monsterID) {
	settype($monsterID, "int");
	include $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	try
	{
		$sql = "SELECT COUNT(value)
		FROM
			monster_stats
		WHERE
			stat_id =(
				SELECT id
				FROM
					stats
				WHERE
					short_name = :shortname)
					AND monster_id = :monsterid";
		$s = $pdo->prepare($sql);
		$s->bindValue(':shortname',$statName);
		$s->bindValue(':monsterid', $monsterID,PDO::PARAM_INT);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error counting monster stats value list.';
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}
	
	list($count) = $s->fetch();
	if((int)$count == "0") {
		// the stat doesn't exist; insert it into the database
		try{
			$sql = "INSERT INTO
						monster_stats
					SET
						stat_id = (SELECT id FROM stats WHERE short_name = :shortname)
						,monster_id = :monsterid
						,value = 0";
			$s = $pdo->prepare($sql);
			$s->bindValue(':shortname', $statName,PDO::PARAM_STR);
			$s->bindValue(':monsterid', $monsterID,PDO::PARAM_INT);

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
 
?>
<?php
	session_start();
	$name = $_SESSION['username'];
	include_once $_SERVER['DOCUMENT_ROOT'] . '/include/dump.include.php';

	
	require_once $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	require $_SERVER['DOCUMENT_ROOT'] . '/browsergame/inc/logincheck.inc.php';

	
	if($_POST) {
		if($_POST['action'] == 'Attack') {
			require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/stats.function.php';	// player stats
			require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/armorstats.function.php';	// armor stats
			require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/weapons.function.php';	// weapon stats
			require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/monsterstats.function.php';	// monster stats
			// fighting the monster	
			try
			{
				$sql = "SELECT id FROM users WHERE UPPER(username) = UPPER(:username)";
				$s = $pdo->prepare($sql);
				$s->bindValue(':username', $name);
				$s->execute();			
			}
			catch (PDOException $e)
			{
				$error = 'Error fetching usernames list.' . $e->getMessage();
				include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
				exit();
			}
			list($userID) = $s->fetch();
			if(!$userID) {
				// not logged in!
				header('Location: http://www.skolahysing.com/browsergame/index.php');	
			}
			
			$player = array (
				'name'		=>	$_SESSION['username'],
				'attack' 	=>	getStat('atk',$userID),
				'defence'	=>	getStat('def',$userID),
				curhp		=>	getStat('curhp',$userID)
			);
			$phand = getStat('phand',$userID);
			$atk = getWeaponStat('atk',$phand);
			$player['attack'] += $atk;
			$armor = array('atorso','ahead','alegs','aright','aleft');
			foreach ($armor as $key) {
				$id = getStat($key,$userID);
				$defence = getArmorStat('defence',$id);
				$player['defence'] += $defence;
			}
			
			$monstername = $_POST['monster'];
			try
			{
				$sql = "SELECT id FROM monsters WHERE name = :name";
				$s = $pdo->prepare($sql);
				$s->bindValue(':name', $monstername);
				$s->execute();			
			}
			catch (PDOException $e)
			{
				$error = 'Error fetching monstername list.' . $e->getMessage();
				include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
				exit();
			}
			list($monsterID) = $s->fetch();
			$monster = array (
				"name"		=>	$monstername,
				"attack"		=>	getMonsterStat('atk',$monsterID),
				"defence"		=>	getMonsterStat('def',$monsterID),
				"curhp"		=>	getMonsterStat('maxhp',$monsterID)
			);
			$combat = array();
			$turns = 0;		
			while($player['curhp'] > 0 && $monster['curhp'] > 0) {
				if($turns % 2 != 0) {
					$attacker = &$monster;
					$defender = &$player;	
				} else {
					$attacker = &$player;
					$defender = &$monster;
				}
				$damage = 0;
				if($attacker['attack'] > $defender['defence']) {
					$damage = $attacker['attack'] - $defender['defence'];	
				}
				$defender['curhp'] -= $damage;
				$combat[$turns] = array(
					attacker	=>	$attacker['name'],
					defender	=>	$defender['name'],
					damage		=>	$damage
				);
				$turns++;
			}
			setStat('curhp',$userID,$player['curhp']);
			if($player['curhp'] > 0) {
				// player won
				setStat('gc',$userID,getStat('gc',$userID)+getMonsterStat('gc',$monsterID));
				

				$won = 1;
				$gold = getMonsterStat('gc', $monsterID);
				$rand = rand(0,100);
				try
				{
					$sql = "SELECT item_id FROM monster_items WHERE monster_id = :monsterid AND rarity >= :rand ORDER BY RAND() LIMIT 1";
					$s = $pdo->prepare($sql);
					$s->bindValue(':monsterid', $monsterID);
					$s->bindValue(':rand', $rand);
					$s->execute();			
				}
				catch (PDOException $e)
				{
					$error = 'Error fetching item from monster.' . $e->getMessage();
					include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
					exit();
				}
				list($itemID) = $s->fetch();
				try
				{
					$sql = "SELECT COUNT(id) FROM user_items WHERE user_id = :userid AND item_id = :itemid";
					$s = $pdo->prepare($sql);
					$s->bindValue(':userid', $userID);
					$s->bindValue(':itemid', $itemID);
					$s->execute();			
				}
				catch (PDOException $e)
				{
					$error = 'Error fetching item from monster.' . $e->getMessage();
					include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
					exit();
				}
				list($count) = $s->fetch();
				if ($count > 0) {
					# already has one of the item
					try
					{
						$sql = "UPDATE user_items 
								SET quantity = quantity + 1 
								WHERE user_id = :userid 
								AND item_id = :itemid";
						$s = $pdo->prepare($sql);
						$s->bindValue(':userid', $userID);
						$s->bindValue(':itemid', $itemID);
						$s->execute();			
					}
					catch (PDOException $e)
					{
						$error = 'Error updating user_items.' . $e->getMessage();
						include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
						exit();
					}
				} else {
					# has none - new row
					dump($itemID);
					try
					{
						$sql = "INSERT INTO user_items
								SET quantity = 1
								,user_id = :userID
								,item_id = :itemid";
						$s = $pdo->prepare($sql);
						$s->bindValue(':userid', $userID);
						$s->bindValue(':itemid', $itemID);
						$s->execute();			
					}
					catch (PDOException $e)
					{
						$error = 'Error Insert into user_items.' . $e->getMessage();
						include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
						exit();
					}
					
				}
				# retrieve the item name, so that we can display it
				try
				{
					$sql = "SELECT name FROM items WHERE id = :itemid";
					$s = $pdo->prepare($sql);
					$s->bindValue(':itemid', $itemID);
					$s->execute();			
				}
				catch (PDOException $e)
				{
					$error = 'Error getting item name.' . $e->getMessage();
					include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
					exit();
				}
				list($item) = $s->fetch();
			} else {
			// monster won
				$lost = 1;
			}	
		} else {
			// Running away! Send them back to the main page
			header('Location: http://www.skolahysing.com/browsergame/main/index.php');	
		}
	}else {
	try
	{
		$result = $pdo->query('SELECT name FROM monsters ORDER BY RAND() LIMIT 1');		
	}
	catch (PDOException $e)
	{
		$error = 'Error fetching usernames list.' . $e->getMessage() ;
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	}
	list($monster) = $result->fetch();
	}
	require $_SERVER['DOCUMENT_ROOT'] . '/browsergame/forrest/forrest.html.php';


 
?>
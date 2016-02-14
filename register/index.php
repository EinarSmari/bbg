<?php
 include_once $_SERVER['DOCUMENT_ROOT'] . '/include/dump.include.php'; 
if($_POST['password']) {
	$password = $_POST['password'];
	$confirm =  $_POST['confirm'];
	if($password != $confirm) {
		$error = 'Password do not match!';
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
	} 
	else {
		include $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
		$securepass = password_hash($password, PASSWORD_DEFAULT);
		try
		{
			$sql = "SELECT id, username FROM users WHERE UPPER(username) = UPPER(:username)";
			$s = $pdo->prepare($sql);
			$s->bindValue(':username', $_POST['username']);
			$s->execute();			
		}
		catch (PDOException $e)
		{
			$error = 'Error fetching usernames list.' . $e->getMessage();
			include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
			exit();
		}
		$row = $s->fetch();
		if($row){
		$error = 'Error: that username is taken.';
		include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
		exit();
		}
		else {
			try
			{
				$sql = 'INSERT INTO users SET 
				username = :username
				,password = :password';
				$s = $pdo->prepare($sql);
				$s->bindValue(':username', $_POST['username']);
				$s->bindValue(':password', $securepass);
				$s->execute();
			}
			catch (PDOException $e)
			{
					$error = 'Error adding submitted user and password.';
					include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
					exit();
			}
			$userID = $pdo->lastInsertId(); 
			require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/stats.function.php';
			setStat('atk',$userID,'5');
			setStat('def',$userID,'5');			
			setStat('mag',$userID,'5');

			header('Location:http://www.skolahysing.com/browsergame/main/index.php');
			exit();
		}
	}
}

include 'register.html.php';
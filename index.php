<?php
	session_start();
	include_once $_SERVER['DOCUMENT_ROOT'] . '/include/dump.include.php'; 
	if($_POST['username']) {
		include $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
		$username = $_POST['username'];
		$password = $_POST['password'];		

		try
		{
			$sql = 'SELECT id, username, password FROM users WHERE UPPER(username) = UPPER(:username)';
			$s = $pdo->prepare($sql);
			$s->bindValue(':username', $username);
			$s->execute();			
		}
		catch (PDOException $e)
		{
			$error = 'Error fetching usernames list.' . $e->getMessage() ;
			include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
			exit();
		}
		$row = $s->fetch();
		$securepass = $row['password'];
		
		if(password_verify($password, $securepass)) {
			$_SESSION['authenticated'] = true;
			$_SESSION['username'] = $username;
			try
			{
				$sql = 'UPDATE users SET
				last_login = NOW()
				WHERE UPPER(username)= UPPER(:username)
				AND password = :password';
				$s = $pdo->prepare($sql);
				$s->bindValue(':username', $username);
				$s->bindValue(':password', $securepass);
				$s->execute();
			}
			catch (PDOException $e)
			{
				$error = 'Error updating timestamp for user.' . $e->getMessage();
				include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
				exit();
			}
			try
			{
				$sql = "SELECT username, is_admin FROM users WHERE UPPER(username) = UPPER(:username)
				AND password = :password";
				$s = $pdo->prepare($sql);
				$s->bindValue(':username', $_POST['username']);
				$s->bindValue(':password', $password);
				$s->execute();			
			}
			catch (PDOException $e)
			{
				$error = 'Error fetching admin list.';
				include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
				exit();
			}
			list($row) = $s->fetch();
			if($row == 1){
				header('Location:admin/index.php');
			}
			else{
				header('Location:http://www.skolahysing.com/browsergame/main/index.php');
			}
		}
		else {
			$error = 'Error: that username and password combination does not match any currently within our database.';
			include $_SERVER['DOCUMENT_ROOT'] . '/include/error.html.php';
			exit();
		}
	}
	include 'login.html.php';
?>
<?php
	// retrieve user ID
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
?>
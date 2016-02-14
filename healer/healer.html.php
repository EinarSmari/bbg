<html>
	<head>
		<title>The Healer</title>
		<script type='text/javascript'>
			document.getElementById('amount').focus();
		</script>
	</head>
	<body>
		<?php 
			echo "<p>Welcome to the healer. You currently have <strong>{$curhp}</strong> HP out of a maximum of <strong>{$maxhp}</strong>.</p>";
			echo "<p>You have <strong>{$gold}</strong> gold to heal yourself with, and it will cost you <strong>1 gold per HP healed</strong> to heal yourself.</p>";
			if($healed > 0){
				echo "<p>You have been healed for <strong>{$healed}</strong> HP.</p>";
			}
		?>
		<form action='' method='post'>
			<input type='text' name='amount' id='amount' /><br />
			<input type='submit' name='action' value='Heal Me' />
		</form>
		<p><a href='../main/index.php'>Back to main</a></p>

	</body>
</html>
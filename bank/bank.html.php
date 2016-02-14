<html>
	<head>
		<title>The Bank</title>
	</head>
	<body>
		<?php
			if($deposited > 0){
				echo "<p>You deposited <strong>{$deposited}</strong> gold into your bank account. Your total in the bank is now <strong>{$inbank}</strong>.</p>";
			}
			if ($withdrawn > 0){
				echo "<p>You withdraw <strong>{$withdrawn}</strong> gold from your bank account. Your total gold in hand is now <strong>{$gold}</strong>.</p>";
			}
			echo "<p>Welcome to the bank. You currently have <strong>{$inbank}</strong> gold in the bank, and <strong>{$gold}</strong> gold in hand.</p>";?>
		<form action='' method='post'>
			<input type='text' name='amount' /><br />
			<input type='submit' name='action' value='Deposit' /> or 
			<input type='submit' name='action' value='Withdraw' />
		</form>
		<p><a href='../main/index.php'>Back to main</a></p>
	</body>
</html>
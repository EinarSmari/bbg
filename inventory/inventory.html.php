<html>
	<head>
		<title>Your Inventory</title>
	</head>
	<body>
		<p>This is your inventory. Check out all the stuff you've got!</p>
		<ul>
			<?php
				foreach($inventory as $i){
				echo "<li>";
				echo 	"<strong>{$i['name']} x {$i['quantity']}</strong>";
				echo	"<form action='inventory.php' method='post'>";
				echo		"<input type='hidden' name='item-id' value='{$i['id']}' />";
				echo		"<input type='submit' value='Use' />";
				echo 	"</form>";
				echo "</li>";
				}
			?>
		</ul>
	</body>
</html>
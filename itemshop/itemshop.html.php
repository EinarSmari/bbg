<html>
	<head>
		<title>The Item Shop</title>
	</head>
	<body>
		<p>Welcome to the Item Shop.</p>
		<p><a href='../main/index.php'>Back to main</a></p>
		<h3>Current Inventory:</h3>
		<ul>
			<?php
				foreach($inventory as $i){
					echo "<li>";
					echo "{$i['name']} x {$i['quantity']}";
					echo "<form action='' method='post'>";
					echo 	"<input type='hidden' name='sell-id' value='{$i['item_id']}' />";
					echo 	"<input type='submit' value='Sell' />"; 
					echo "</form>";
					echo "</li>";
				}
			?>
		</ul>
		<p>You may purchase any of the items listed below.</p>
		<?php
			if($error){
				echo "<p style='color:red'>{$error}</p>";
			}
			if($message){
				echo "<p style='color:green'>{$message}</p>";
			}
			echo "<ul>";
			foreach($items as $i){
				echo "<li>";
				echo	"<strong>{$i['name']}</strong> - <em>{$i['price']} gold coins</em>";
				echo	"<form action='item-shop.php' method='post'>";
				echo		"<input type='hidden' name='item-id' value='{$i['id']}' />";
				echo		"<input type='submit' value='Buy' />";
				echo	"</form>";
			}
		?>	
		</ul>
	</body>
</html>
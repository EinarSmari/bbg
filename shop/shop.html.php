<html>
<head>
	<title>The Weapon Shop</title>
</head>
	<body>
		<p>Welcome to the Weapon Shop.</p>
		<h3>Current Equipment:</h3>
		<ul>
			<li>
				Primary Hand:
				<?php 

				if($phand){
					echo $phand;
					echo "<form action='' method='post'>";
					echo	"<input type='hidden' name='sell' value='phand' />";
					echo	"<input type='submit' value='Sell' />";
					echo "</form>";
				}else{
					echo "None";
				}
			echo "</li>";
			echo "<li>";
			echo "Secondary Hand:";
				if ($shand){
					echo $shand;
					echo "<form action='weapon-shop.php' method='post'>";
					echo  "<input type='hidden' name='sell' value='shand' />";
					echo "<input type='submit' value='Sell' />";
					echo "</form>";
				}else{
					echo "None"; }?>
			</li>
		</ul>
		<p>Below are the weapons currently available for purchase.</p>
		<?php
		if ($error !== ''){
			echo "<p style='color:red'>{$error}</p>";
		}
		if ($message !== ''){
			echo "<p style='color:green'>{$message}</p>";
		}
		echo "<ul>";
			foreach ($weapons as $weapon){
				echo "<li>";
					echo "<strong>{$weapon['name']}</strong> - <em>{$weapon['price']} gold coins</em>";
					echo "<form action='' method='post'>";
						echo "<input type='hidden' name='weapon-id' value=$weapon.id />";
						echo "<input type='submit' value='Buy' />";
					echo "</form>";
			} ?>
		</ul>
	</body>
</html>
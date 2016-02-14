<html>
<head>
	<title>The Armor Shop</title>
</head>
<body>
	<p>Welcome to the Armor Shop.</p>
	<p><a href='../main/index.php'>Back to main</a></p>
	<h3>Current Armor:</h3>
	<ul>
		<li>
			Head:
			<?php
			if($ahead){
				echo $ahead;
				echo "<form action='' method='post'>";
				echo	"<input type='hidden' name='sell' value='ahead' />";
				echo	"<input type='submit' value='Sell' />";
				echo "</form>";
			}else{
				echo "None";
			}?>
		</li>
		<li>
			Torso:
			<?php
			if($atorso){
				echo $atorso;
				echo "<form action='' method='post'>";
				echo	"<input type='hidden' name='sell' value='atorso' />";
				echo	"<input type='submit' value='Sell' />";
				echo "</form>";
			}else{
				echo "None";
			}?>
		</li>
		<li>
			Legs:
			<?php
			if($alegs){
				echo $alegs;
				echo "<form action='' method='post'>";
				echo	"<input type='hidden' name='sell' value='alegs' />";
				echo	"<input type='submit' value='Sell' />";
				echo "</form>";
			}else{
				echo "None";
			}?>
		</li>
		<li>
			Right Arm:
			<?php
			if($aright){
				echo $aright;
				echo "<form action='' method='post'>";
				echo	"<input type='hidden' name='sell' value='aright' />";
				echo	"<input type='submit' value='Sell' />";
				echo "</form>";
			}else{
				echo "None";
			}?>
		</li>
		<li>
			Left Arm:
			<?php
			if($aleft){
				echo $aleft;
				echo "<form action='' method='post'>";
				echo	"<input type='hidden' name='sell' value='aleft' />";
				echo	"<input type='submit' value='Sell' />";
				echo "</form>";
			}else{
				echo "None";
			}?>
		</li>
 
	</ul>
	<p>You may purchase any of the armor listed below.</p>
	<?php
	if($error){
		echo "<p style='color:red'>{$error}</p>";
	}
	if($message){
		echo "<p style='color:green'>{$message}</p>";
	}
	echo "<ul>";
		foreach($armor AS $a){
			echo "<li>";
			echo	"<strong>{$a['name']}</strong> - <em>{$a['price']} gold coins</em>";
			echo	"<form action='' method='post'>";
			echo		"<input type='hidden' name='armor-id' value='{$i['id']}' />";
			echo		"<input type='submit' value='Buy' />";
			echo	"</form>";
		}?>
	</ul>
</body>
</html>
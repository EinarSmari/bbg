<html>
	<head>
		<title>Equipment Management</title>
	</head>
	<body>
		<h3>Current Equipment:</h3>
		<p><a href='../main/index.php'>Back to main</a></p>
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
				}?>
			</li>
			<li>
				Secondary Hand:
				<?php
				if($shand){
					echo $shand;
					echo "<form action='weapon-shop.php' method='post'>";
					echo	"<input type='hidden' name='sell' value='shand' />";
					echo	"<input type='submit' value='Sell' />";
					echo "</form>";
				}else{
					echo "None";
				}?>
			</li>
		</ul>
		<p>
			<form action='' method='post'>
				<input type='submit' value='Swap' name='swap' />
			</form>
		</p>
	</body>
</html>
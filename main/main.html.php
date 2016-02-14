<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/include/dump.include.php';
?>
<html>
	<head>
		<script type='text/javascript'>
			window.onload = function() {
				document.getElementById('username').focus();	
			}		
		</script>
		<title>Main page</title>
	</head>
	<body>
		<?php
			echo "<p>Hello, {$name}!</p>";
			echo "<ul>:";
			echo	"<li>Attack: <strong>{$attack}</strong></li>";
			echo	"<li>Defence: <strong>{$defence}</strong></li>";
			echo	"<li>Magic: <strong>{$magic}</strong></li>";
			echo	"<li>Gold in hand: <strong>{$gold}</strong></li>";
			echo	"<li>Current HP: <strong>{$currentHP}/{$maximumHP}</strong>";
			echo "</ul>";
		?>
		<p><a href='../logout/index.php'>Logout</a></p>
		<p><a href='../forrest/index.php'>The Forest</a></p>
		<p><a href='../bank/index.php'>The Bank</a></p>
		<p><a href='../healer/index.php'>The Healer</a></p>
		<p><a href='../shop/index.php'>The Shop</a></p>
		<p><a href='../equipment/index.php'>The Equipment</a></p>
		<p><a href='../armorshop/index.php'>The Armor Shop</a></p>
		<p><a href='../itemshop/index.php'>The Item Shop</a></p>
		<p><a href='../inventory/index.php'>Your inventory</a></p>





	</body>
</html>
<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/include/text.include.php'; 
	include_once $_SERVER['DOCUMENT_ROOT'] . '/include/dump.include.php';
?>
<html>
<head>
	<title>The Forest</title>
</head>
	<body>
		<?php
			
			if($combat == ''){
				echo "<p>You've encountered a {$monster}!</p>";
				echo "<form action='' method='post'>";
				echo "<input type='submit' name='action' value='Attack' />"; 
				echo "<input type='submit' name='action' value='Run Away' />";
				echo "<input type='hidden' name='monster' value='{$monster}' />"; 
				echo "</form>";}
			else{
				echo "<ul>";
				foreach ($combat as $c){
					echo "<li><strong>" . $c['attacker'] . "</strong> attacks " . $c['defender'] . " for " . $c['damage'] . "damage!</li>";
				}
				
				echo "</ul>";
				if($won == 1){
					echo "<p>You killed <strong>{$monster['name']}</strong>! You gained <strong>{$gold}</strong> gold.</p>";
					echo "<p>You found a <strong>{$item}</strong>!</p>";
					echo "<p><a href='index.php'>Explore Again</a></p>";
				}
				if($lost == 1){
					echo "<p>You were killed by <strong>{$monster['name']}</strong>.</p>";

					echo "<p><a href='../main/index.php'>Back to main</a></p>";
				}
			}	
		?>

	</body>
</html>
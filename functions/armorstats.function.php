<?php
 
require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/drystats.function.php';
 
function getArmorStat($statName,$armorID) {
	return getStatDRY('Item',$statName,$armorID);
}
 
?>
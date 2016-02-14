<?php
 
require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/drystats.function.php';
 
function getWeaponStat($statName,$weaponID) {
	return getStatDRY('Weapon',$statName,$weaponID);
}
 
?>
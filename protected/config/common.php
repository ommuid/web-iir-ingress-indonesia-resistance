<?php
/**
 * Merge file modules and developments
 */
return CMap::mergeArray(
	require(dirname(__FILE__).'/production.php'),
	require(dirname(__FILE__).'/setting.php'),
	require(dirname(__FILE__).'/database.php'),
	require(dirname(__FILE__).'/modules.php')
);
?>
<?php
/**
 * Merge file module_core and module_addon
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */
return CMap::mergeArray(
	require(dirname(__FILE__) . '/module_core.php'),
	require(dirname(__FILE__) . '/module_addon.php')
);
?>
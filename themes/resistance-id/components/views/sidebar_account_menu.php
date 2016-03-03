<div class="account-menu">
	<ul>
		<li class="account active"><a class="menu-groups" href="javascript:void(0);" title="My Resistance">My Resistance<span></span></a>
			<ul>
				<li <?php echo ($module == null && $currentAction == 'site/index') ? 'class="active"' : '';?>><a href="<?php echo Yii::app()->createUrl('site/index');?>" title="Activity Stream"><span>Activity Stream</span></a></li>
				<li <?php echo ($module != null && $currentModule == 'daop/member') ? 'class="active"' : '';?>><a href="<?php echo Yii::app()->createUrl('daop');?>" title="My Area"><span>My Area</span></a></li>
			</ul>
		</li>
		<li class="daops active"><a class="menu-groups" href="javascript:void(0);" title="Operation Area">Operation Area<span></span></a>
			<ul>
				<li <?php echo ($module != null && $currentModule == 'daop/city') ? 'class="active"' : '';?>><a href="<?php echo Yii::app()->createUrl('daop/city');?>" title="City Area"><span>City</span></a></li>
				<li <?php echo ($module != null && $currentModule == 'daop/another') ? 'class="active"' : '';?>><a href="<?php echo Yii::app()->createUrl('daop/another');?>" title="Specific City Area"><span>Specific City</span></a></li>
				<li <?php echo ($module != null && $currentModule == 'daop/province') ? 'class="active"' : '';?>><a href="<?php echo Yii::app()->createUrl('daop/province');?>" title="Province Area"><span>Province</span></a></li>
			</ul>
		</li>
		<li class="support active"><a class="menu-groups" href="javascript:void(0);" title="Enlightened">Enlightened<span></span></a>
			<ul>
				<li><a href="javascript:void(0);" title="Review Agents"><span>Review Agents</span></a></li>
			</ul>
		</li>
		<?php /*
		<li class="support active"><a class="menu-groups" href="javascript:void(0);" title="Support">Support<span></span></a>
			<ul>
				<li><a href="" title=""><span>My Resistance</span></a></li>
				<li><a href="" title=""><span>My Resistance</span></a></li>
				<li><a href="" title=""><span>My Resistance</span></a></li>
			</ul>
		</li>
		*/?>
	</ul>
</div>
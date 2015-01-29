<?php //begin.Statistic ?>
<div class="boxed">
	<h3><?php echo Phrase::trans(249,0);?></h3>
	<table>
		<tr>
			<th colspan="3"><?php echo Phrase::trans(250,0);?></th>
		</tr>
		<tr>
			<td><?php echo Phrase::trans(254,0);?></td>
			<td colspan="2"><?php echo $model->license_key?></td>
		</tr>
		<tr>
			<td><?php echo Phrase::trans(255,0);?></td>
			<td colspan="2"><?php echo $model->site_creation?></td>
		</tr>
		<tr>
			<td><?php echo Phrase::trans(256,0);?></td>
			<td colspan="2"><?php echo $model->ommu_version?></td>
		</tr>
		<tr>
			<td><?php echo Phrase::trans(295,0);?></td>
			<td colspan="2"><?php echo $model->site_type == 1 ? Phrase::trans(296,0) : Phrase::trans(297,0) ?></td>
		</tr>
		<tr>
			<th><?php echo Phrase::trans(251,0);?></th>
			<th><?php echo Phrase::trans(252,0);?></th>
			<th><?php echo Phrase::trans(253,0);?></th>
		</tr>
		<tr>
			<td><?php echo Phrase::trans(257,0);?></td>
			<td>0</td>
			<td>0</td>
		</tr>
		<tr>
			<td><?php echo Phrase::trans(258,0);?></td>
			<td>0</td>
			<td>0</td>
		</tr>
		<tr>
			<td><?php echo Phrase::trans(259,0);?></td>
			<td>0</td>
			<td>0</td>
		</tr>
		<tr>
			<td><?php echo Phrase::trans(260,0);?></td>
			<td>0</td>
			<td>0</td>
		</tr>
		<tr>
			<td><?php echo Phrase::trans(263,0);?></td>
			<td>0</td>
			<td>0</td>
		</tr>
		<tr>
			<td><?php echo Phrase::trans(261,0);?></td>
			<td>0</td>
			<td>0</td>
		</tr>
		<tr>
			<td><?php echo Phrase::trans(262,0);?></td>
			<td>0</td>
			<td>0</td>
		</tr>
			<tr>
			<td><?php echo Phrase::trans(265,0);?></td>
			<td>0</td>
			<td>0</td>
		</tr>
		<tr>
			<td colspan="2"><?php echo Phrase::trans(264,0);?></td>
			<td>0</td>
		</tr>
	</table>
</div>
<?php //end.Statistic ?>

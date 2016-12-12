<?php
	$place = $model->office_place;
	$village = $model->office_village != '' ? ', '.$model->office_village : '';
	$district = $model->office_district != '' ? ', '.$model->office_district : '';
	$city = $model->office_city != 0 ? ', '.$model->city->city : '';
	$province = $model->office_province != 0 ? ', '.$model->province->province : '';
	$zipcode = $model->office_zipcode != '' ? ' '.$model->office_zipcode : '';
	$country = $model->office_country != 0 ? '<span class="highlight">'.$model->country->country.'</span>' : '';
?>
<p><i class="fa fa-map-marker"></i><?php echo $place.$village.$district.$city.$province.$zipcode;?> <?php echo $country;?></p>
<p><i class="fa fa-envelope"></i> <a off_address="" href="mailto:<?php echo $model->office_email?>" title="<?php echo $model->office_email?>"><?php echo $model->office_email?></a></p>
<p><i class="fa fa-phone"></i> <?php echo $model->office_phone;?></p>

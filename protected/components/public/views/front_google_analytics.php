<?php
	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	//ga('create', '$model->analytic_id', '$model->site_url');
	ga('create', '$model->analytic_id', 'auto');
	ga('send', 'pageview');
EOP;
	$model->analytic == '1' ? $cs->registerScript('analytics', $js, CClientScript::POS_END) : '';
?>
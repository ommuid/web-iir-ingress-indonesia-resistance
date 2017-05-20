<?php
	$analytic = $model->analytic;
	$analytic_id = $model->analytic_id;
	$ga_profile_id = $model->analytic_profile_id;

	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile(Yii::app()->theme->baseUrl.'/css/chartjs-visualizations.css');
	$cs->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js', CClientScript::POS_END);
	$cs->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js', CClientScript::POS_END);
	$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/plugin/view-selector2.js', CClientScript::POS_END);
	$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/plugin/date-range-selector.js', CClientScript::POS_END);
$js=<<<EOP
(function(w,d,s,g,js,fjs){
	g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
	js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
	js.src='https://apis.google.com/js/platform.js';
	fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
}(window,document,'script'));

gapi.analytics.ready(function() {
	/**
	 * Authorize the user with an access token obtained server side.
	 */
	gapi.analytics.auth.authorize({
		'serverAuth': {
			'access_token': '$token'
		}
	});

	/**
	 * Creates a new DataChart instance showing sessions over the past 30 days.
	 * It will be rendered inside an element with the id "chart-1-container".
	 */
	var dataChart = new gapi.analytics.googleCharts.DataChart({
		query: {
			'ids': 'ga:$ga_profile_id', // <-- Replace with the ids value for your view.
			'start-date': '30daysAgo',
			'end-date': 'yesterday',
			'metrics': 'ga:pageviews,ga:sessions,ga:users',
			'dimensions': 'ga:date'
		},
		chart: {
			'container': 'chart-line-container',
			'type': 'LINE',
			'options': {
				'width': '100%'
			}
		}
	});
	dataChart.execute();
	
	// Render all the of charts for this view.
	renderWeekOverWeekChart();
	
	/**
	 * Draw the a chart.js line chart with data from the specified view that
	 * overlays session data for the current week over session data for the
	 * previous week.
	 */
	function renderWeekOverWeekChart() {
		// Adjust `now` to experiment with different days, for testing only...
		var now = moment(); // .subtract(3, 'day');

		var thisWeek = query({
			'ids': 'ga:$ga_profile_id',
			'dimensions': 'ga:date,ga:nthDay',
			'metrics': 'ga:sessions',
			'start-date': moment(now).subtract(1, 'day').day(0).format('YYYY-MM-DD'),
			'end-date': moment(now).format('YYYY-MM-DD')
		});

		var lastWeek = query({
			'ids': 'ga:$ga_profile_id',
			'dimensions': 'ga:date,ga:nthDay',
			'metrics': 'ga:sessions',
			'start-date': moment(now).subtract(1, 'day').day(0).subtract(1, 'week')
					.format('YYYY-MM-DD'),
			'end-date': moment(now).subtract(1, 'day').day(6).subtract(1, 'week')
					.format('YYYY-MM-DD')
		});

		Promise.all([thisWeek, lastWeek]).then(function(results) {
			var data1 = results[0].rows.map(function(row) { return +row[2]; });
			var data2 = results[1].rows.map(function(row) { return +row[2]; });
			var labels = results[1].rows.map(function(row) { return +row[0]; });

			labels = labels.map(function(label) {
				return moment(label, 'YYYYMMDD').format('ddd');
			});

			var data = {
				labels : labels,
				datasets : [
					{
						label: 'Last Week',
						fillColor : 'rgba(220,220,220,0.5)',
						strokeColor : 'rgba(220,220,220,1)',
						pointColor : 'rgba(220,220,220,1)',
						pointStrokeColor : '#fff',
						data : data2
					},
					{
						label: 'This Week',
						fillColor : 'rgba(151,187,205,0.5)',
						strokeColor : 'rgba(151,187,205,1)',
						pointColor : 'rgba(151,187,205,1)',
						pointStrokeColor : '#fff',
						data : data1
					}
				]
			};

			new Chart(makeCanvas('chart-1-container')).Line(data);
			generateLegend('legend-1-container', data.datasets);
		});
	}
	
	/**
	 * Extend the Embed APIs `gapi.analytics.report.Data` component to
	 * return a promise the is fulfilled with the value returned by the API.
	 * @param {Object} params The request parameters.
	 * @return {Promise} A promise.
	 */
	function query(params) {
		return new Promise(function(resolve, reject) {
			var data = new gapi.analytics.report.Data({query: params});
			data.once('success', function(response) { resolve(response); })
					.once('error', function(response) { reject(response); })
					.execute();
		});
	}

	/**
	 * Create a new canvas inside the specified element. Set it to be the width
	 * and height of its container.
	 * @param {string} id The id attribute of the element to host the canvas.
	 * @return {RenderingContext} The 2D canvas context.
	 */
	function makeCanvas(id) {
		var container = document.getElementById(id);
		var canvas = document.createElement('canvas');
		var ctx = canvas.getContext('2d');

		container.innerHTML = '';
		canvas.width = container.offsetWidth;
		canvas.height = container.offsetHeight;
		container.appendChild(canvas);

		return ctx;
	}

	/**
	 * Create a visual legend inside the specified element based off of a
	 * Chart.js dataset.
	 * @param {string} id The id attribute of the element to host the legend.
	 * @param {Array.<Object>} items A list of labels and colors for the legend.
	 */
	function generateLegend(id, items) {
		var legend = document.getElementById(id);
		legend.innerHTML = items.map(function(item) {
			var color = item.color || item.fillColor;
			var label = item.label;
			return '<li><i style="background:' + color + '"></i>' +
					escapeHtml(label) + '</li>';
		}).join('');
	}

	// Set some global Chart.js defaults.
	Chart.defaults.global.animationSteps = 60;
	Chart.defaults.global.animationEasing = 'easeInOutQuart';
	Chart.defaults.global.responsive = true;
	Chart.defaults.global.maintainAspectRatio = false;

	/**
	 * Escapes a potentially unsafe HTML string.
	 * @param {string} str An string that may contain HTML entities.
	 * @return {string} The HTML-escaped string.
	 */
	function escapeHtml(str) {
		var div = document.createElement('div');
		div.appendChild(document.createTextNode(str));
		return div.innerHTML;
	}	
});
EOP;
	$cs->registerScript('frontend-analytics', $js);
?>


<div class="box">
	<div class="title clearfix">
		<h2><?php echo Yii::t('phrase', 'Pageview, Session dan Users')?></h2>
	</div>
	<div id="chart-line-container"></div>
</div>

<div class="box">
	<div class="title clearfix">
		<h2><?php echo Yii::t('phrase', 'This Week vs Last Week (by sessions)')?></h2>
	</div>
	<div class="Chartjs">
		<figure class="Chartjs-figure" id="chart-1-container"></figure>
		<ol class="Chartjs-legend" id="legend-1-container"></ol>
	</div>
</div>
var calculateTimeDifference = function(startDate) {
    var second = 1000;
    var minute = second * 60;
    var hour = minute * 60;
    var day = hour * 24;

    var seconds = 0;
    var minutes = 0;
    var hours = 0;
    var days = 0;

    var currentDate = new Date();
    startDate = new Date(startDate);
    
    var timeCounter = startDate - currentDate;
    if (isNaN(timeCounter))
    {
        return NaN;
    }
    else
    {
        days = Math.floor(timeCounter / day);
        timeCounter = timeCounter % day;

        hours = Math.floor(timeCounter / hour);
        timeCounter = timeCounter % hour;

        minutes = Math.floor(timeCounter / minute);
        timeCounter = timeCounter % minute;
        
        seconds = Math.floor(timeCounter / second);
    }

    var tDiffObj = {
        "Days" : days,
        "Hours" : hours,
        "Minutes" : minutes,
        "Seconds" : seconds
    };

    return tDiffObj;
};

$(document).ready(function() {

	if(startDate) {
		setInterval(function(){
			var countDownObj = calculateTimeDifference(startDate);
			if(countDownObj){
				$('#days').text(countDownObj.Days);
				$('#hours').text(countDownObj.Hours);
				$('#minutes').text(countDownObj.Minutes);
				$('#seconds').text(countDownObj.Seconds);
			}
		}, 1000);
	}

});
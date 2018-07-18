$(document).ready(function() {
    (function() {
        if( window.Timer ) {
             function startTimer(duration) {
                var timer = duration, minutes, seconds;
                var ticker = setInterval(function () {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);
            
                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;
                    
                    $(window).trigger('timer:tick', {
                        "display": minutes + ":" + seconds,
                        "timer": timer
                    });
                    
                    if (--timer < 0) {
                        clearInterval(ticker);
                        $(window).trigger('timer:done');
                    }
                }, 1000);
            }
            
            startTimer(Timer.end - Timer.current);
        }
        
        $(window).on('timer:tick', function(event, data) {
			if(data.timer > 0) {
				$('.timer').html(data.display);
			}
        });
        $(window).on('timer:done', function(event, data) {
            $('#ls-button-submit').val('movesubmit').click();
        });
     })();
});
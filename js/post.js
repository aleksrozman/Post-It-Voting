/* Functions for the round */

function disableRound(en) {
	$("#round").attr("disabled", en);
	$("#round").removeClass();
	$("#round").addClass("button");
	$("#round").addClass((en) ? "gray" : "orange");
}

function createMatrix() {
	var max = 0;
	var spanPad = 20; /* fudge for the span's height */
	for(var j = 0; j < results.length; j++) {
		if(results[j].length > max) {
			max = results[j].length;
		}
	}

	var postitSize = ($(window).height() - $("#round").height()) / options.length - options.length*spanPad;
	
	for(var x = 0; x <= options.length; x++) {
		$(".choice" + x).each(function() {
			$(this).css({height: postitSize, width: postitSize});
		});
	}
	
	max = max * postLap + postitSize;
	$(".voter").each(function() {
		$(this).css({height: max, width: max});
	});
	
	for ( var i = 0; i < options.length; i++) {
		$('body').append(
				"<div id='choice" + options[i][1]
						+ "Container' class='choices' style='height:" + ($(".voter").first().height() + spanPad) + "px'><span class='choiceName'>"
						+ options[i][0] + "</span></div>");
	}
	$('body')
			.append(
					"<div id=fifty style='left:" + ((results.length-1) * max/2)
							+ "px'>50%</div>");
	populateBubble();
}

function populateBubble() {
	var tally = [];
	var hw = [ [] ];
	var tots = 0;
	$('div.voter').each(
			function(index) {
				hw[index] = [
						$(this).position().top
								+ $(this).parent().position().top,
						$(this).position().left
								+ $(this).parent().position().left ];
			});
	$('div.voter')
			.each(
					function(index) {
						var paren = "#"
								+ $(this).children("div:first").attr("class")
								+ "Container";
						if (("#" + $(this).parent().attr("id")) != paren) {
							tally[tots++] = paren;
							var numOccurences = $.grep(tally, function(elem) {
								return elem === paren;
							}).length;
							var toTop = 0;
							var toLeft = 0;
							toTop = ($(paren).position().top);
							toLeft = ($(paren).position().left)
									+ $(this).width() * (numOccurences - 1);
							if ($(paren).children('div').size() != 0) {
								toTop += ($(paren).children('div').last()
										.position().top);
								toLeft += ($(paren).children('div').last()
										.position().left)
										+ $(this).width();
							}
							$(this).css({
								position : 'absolute',
								top : hw[index][0],
								left : hw[index][1]
							});
							$(this).appendTo($('body'));
							$(this).animate({
								"top" : toTop,
								"left" : toLeft
							}, 1000, function() {
								$(this).css({
									position : 'relative',
									top : 0,
									left : 0
								});
								$(this).appendTo(paren);
							});
						}
					});
	setTimeout("disableRound(false)", 1000);
}

function runRound() {
	var min = 10000;
	var capturedIndex = [];
	var tots = 0;
	var ran = 0;
	disableRound(true);
	$('div.choices').each(
			function(index) {
				if ($(this).children('div').size() <= min
						&& $(this).children('div').size() > 0) {
					min = $(this).children('div').size();
				}
			});
	$('div.choices').each(function(index) {
		if ($(this).children('div').size() == min) {
			capturedIndex[tots++] = index;
		}
	});
	ran = capturedIndex[Math.floor((Math.random() * capturedIndex.length))];
	$('div.choices').eq(ran).children('div').each(function(index) {
		$(this).children("div:first").fadeOut('slow', function() {
			var paren = $(this).parent();
			$(this).remove();
			if (paren.children('div').size() == 0) {
				paren.remove();
			} else {
				paren.children('div').each(function() {
					$(this).animate({
						top : '-=10',
						left : '-=10'
					}, "slow");
				});
			}
		});
	});
	setTimeout("populateBubble()", 2000);
}


/* Functions for smart phones */

function touchHandler(event) {
	var touches = event.changedTouches, first = touches[0], type = "";

	switch (event.type) {
	case "touchstart":
		type = "mousedown";
		break;
	case "touchmove":
		type = "mousemove";
		break;
	case "touchend":
		type = "mouseup";
		break;
	default:
		return;
	}
	var simulatedEvent = document.createEvent("MouseEvent");
	simulatedEvent.initMouseEvent(type, true, true, window, 1, first.screenX,
			first.screenY, first.clientX, first.clientY, false, false, false,
			false, 0/* left */, null);

	first.target.dispatchEvent(simulatedEvent);
	var $target = $(event.target);
	if ($target.hasClass('postit')) {
		event.preventDefault();
	}
}

function attachTouchListener() {
	document.addEventListener("touchstart", touchHandler, true);
	document.addEventListener("touchmove", touchHandler, true);
	document.addEventListener("touchend", touchHandler, true);
	document.addEventListener("touchcancel", touchHandler, true);
}
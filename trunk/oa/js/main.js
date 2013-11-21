$(document).ready(function(){

	//Scrool
    $('a.tab-switch').bind('click', function(){
       $('div.tab-content').hide();
       $($(this).attr('href')).show();
       $('div.menu>img').remove();
       $(this).before('<img src="/oa/images/elements/arrow_left.png">');
       return false;
    });
	$(window).scroll(function(){
		if(($('body').height() - $('.mytimes_bg').offset().top) < 124){
			$('.mytimes_bg').css("position", "relative");		
		}else{
			$('.mytimes_bg').css("position", "fixed");	
		}
	});
	//Index Switching
	if($('.index-button-box').size() > 4){
		$('.index-go-arrow').bind('click', function(){
			if($(this).data('type') == 'left'){
				$.when(
					$('.index-botton-container').css("width","1600px")).then(function(){
							$('.index-button-box:eq(0)').animate({
							"margin-left":"1px"
							},1000);
							$('.index-button-box:eq(3)').animate({"margin-right":"0px"},1000);
							$('.index-botton-container').css("width","1100px");
				});
				

			}else{
				$.when(
					$('.index-botton-container').css("width","1600px")).then(function(){
						$('.index-button-box:eq(0)').animate({"margin-left":"-284px"},1000);
						$('.index-button-box:eq(4)').animate({"margin-right":"0px"},1000);
						$('.index-button-box:eq(3)').animate({"margin-right":"34px"},1000);
						$('.index-botton-container').css("width","1100px");
				});
			}
			return false;

		});
	}
	//var time = parseInt($('div.time_text').data('time'));
	var time = parseInt($('#index-click-manhour').data('time'));
	var overtime = parseInt($('#index-click-manhour').data('overtime'));
	//var started = parseInt($('div.time_text').data('start'));
	preTime = new Object();
	preOverTime = new Object();
	var timeLoop = setInterval();
    if($('#index-click-manhour').data("type") == 'end'){
        timeLoop = setInterval(function(){manhourTimer()},1000);
    }
	$('#index-click-manhour').bind('click', function(){
		if($(this).data("type") == 'start' || $(this).data('type') == 'end'){
			$.ajax({
				type:"POST",
				url:"index.php?r=manhour/counting",
				data:"ajax=1&type="+$(this).data("type"),
				success:function(msg){
					if($('#index-click-manhour').data('type') == 'start'){
						$('#index-click-manhour').css("background-color","red");
						$('#index-click-manhour').text("下班签到");
						$('#index-click-manhour').data('type', 'end');
						timeLoop = setInterval(function(){manhourTimer()},1000);
					}else{
						clearInterval(timeLoop);
						$('#index-click-manhour').css("background-color","green");
						$('#index-click-manhour').text("签到完毕");
						$('#index-click-manhour').data('type', 'done');
					}
					console.log(msg);
				}
			});
		}else{
			clearInterval(timeLoop);
			alert('您已经签到，请勿重复签到！');
		}
		
	});
	function manhourTimer(){
		if(time<28800){
			time++;
			timeFormat(time, preTime);
			console.log(preTime);
			$('div.time_text>span.manhour').text('已工作时间：'+preTime.hour+'小时'+preTime.minute+'分钟'+preTime.second+'秒');
		}else{
			overtime++;
			timeFormat(overtime, preOverTime);
			console.log(preOverTime);
			$('div.time_text>span.overtime').text('加班时间：'+preOverTime.hour+'小时'+preOverTime.minute+'分钟'+preOverTime.second+'秒');
		}
		var totalTime = time+overtime;
        var progressWidth = (totalTime/86400)*100;
        console.log(progressWidth);
        $('div.progress-bar').css('width', progressWidth+"%");
		
	}
	function timeFormat(timeString, Obj){
		Obj.hour = parseInt(timeString/3600);
		Obj.minute = parseInt((timeString%3600)/60);
		Obj.second = parseInt((timeString%3600)%60);
	}
    setTimeout("$('div.flash-message').hide('slow');", 3000);
});
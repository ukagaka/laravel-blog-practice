/**
 *	Xenon API Functions
 *
 *	Theme by: www.laborator.co
 **/

$("#checked-all").click(function(){
	if($(this).parent().parent().hasClass("cbr-checked")){
		$(".cbr-replaced").each(function(){
			$(this).removeClass("cbr-checked");
		});
	}else{
		$(".cbr-replaced").each(function(){
			$(this).addClass("cbr-checked");
		});
	}
});
$(".checked-val").click(function(){
	if($(this).hasClass("cbr-checked")){
		$(this).removeClass("cbr-checked");
	}else{
		$(this).addClass("cbr-checked");
	}
});

$("#search").click(function(){
	searinput = $('#search-input');
	dainput = searinput.val();
	searurl = searinput.attr('data-searurl');
	datype = $("#search-type option:selected").val();
	window.location.href = '/'+searurl+'?'+datype+'='+ dainput;
});

$(".rev-tab-td").dblclick(function(){
	$(this).find(".rev-tab-input").css("display", "block");
	$(this).find(".rev-tab-div").css("display", "none");
	$(this).find(".rev-tab-input").focus();
});

$(".rev-tab-input").blur(function(){
	_this = $(this);
	postId = _this.attr('data-id');
	posOperation = _this.attr('data-operation');
	posUrl = _this.attr('data-opeurl');
	posData = _this.val();
	_this.css("display","none");
	_this.prev(".rev-tab-div").css("display", "block");
	$.getJSON('/'+posUrl+'/modify', {'id':postId , 'type':posOperation, 'value':posData}, function(data){
		if(data.code == 'success'){
			_this.prev(".rev-tab-div").text(posData);
		}
	});
});

$("#rem-all").click(function(){
	var width = ($(window).width() - 700)/2 + $(document).scrollLeft();
	var height = ($(window).height() - 350)/2 + $(document).scrollTop();
	$(".pop-up-window").css({'display': 'block', 'top':height, 'left':width});
});
$("#pop-close").click(function(){
	$(".pop-up-window").css('display', 'none');
});

$("#pop-submit").click(function(){
	ids = '';
	group_id = $("#pop-select").val();
	popUrl = $(this).attr('data-popurl');
	$(".cbr-checked").each(function(){
		if ($(this).attr("data-id")) {
			ids += $(this).attr("data-id")+'|';
		}
	});
	if(ids){
		ids = ids.substring(0, ids.length - 1);
		var r=confirm("您确定要推送到推荐位吗？")
		if (r==true){
			window.location.href = '/'+popUrl+'/recommend?ids='+ ids + '&group_id=' + group_id;
		}
	}
});

function json_encode (data)
{
	json = '{';
	for (var v in data){
		json += '"'+v+'":"'+data[v]+'",';
	}
	json = json.substring(0, json.length - 1);
	json += '}';
	return json;
}

function rtl() // checks whether the content is in RTL mode
{
	if(typeof window.isRTL == 'boolean')
		return window.isRTL;
		
	window.isRTL = jQuery("html").get(0).dir == 'rtl' ? true : false;
	
	return window.isRTL;
}



// Page Loader
function show_loading_bar(options)
{
	var defaults = {
		pct: 0, 
		delay: 1.3, 
		wait: 0,
		before: function(){},
		finish: function(){},
		resetOnEnd: true
	};
	
	if(typeof options == 'object')
		defaults = jQuery.extend(defaults, options);
	else
	if(typeof options == 'number')
		defaults.pct = options;
		
	
	if(defaults.pct > 100)
		defaults.pct = 100;
	else
	if(defaults.pct < 0)
		defaults.pct = 0;
	
	var $ = jQuery,
		$loading_bar = $(".xenon-loading-bar");
	
	if($loading_bar.length == 0)
	{
		$loading_bar = $('<div class="xenon-loading-bar progress-is-hidden"><span data-pct="0"></span></div>');
		public_vars.$body.append( $loading_bar );
	}
	
	var $pct = $loading_bar.find('span'),
		current_pct = $pct.data('pct'),
		is_regress = current_pct > defaults.pct;
	
	
	defaults.before(current_pct);
	
	TweenMax.to($pct, defaults.delay, {css: {width: defaults.pct + '%'}, delay: defaults.wait, ease: is_regress ? Expo.easeOut : Expo.easeIn,
	onStart: function()
	{
		$loading_bar.removeClass('progress-is-hidden');
	},
	onComplete: function()
	{
		var pct = $pct.data('pct');
		
		if(pct == 100 && defaults.resetOnEnd)
		{
			hide_loading_bar();
		}
		
		defaults.finish(pct);
	}, 
	onUpdate: function()
	{
		$pct.data('pct', parseInt($pct.get(0).style.width, 10));
	}});
}

function hide_loading_bar()
{
	var $ = jQuery,
		$loading_bar = $(".xenon-loading-bar"),
		$pct = $loading_bar.find('span');
	
	$loading_bar.addClass('progress-is-hidden');
	$pct.width(0).data('pct', 0);
}

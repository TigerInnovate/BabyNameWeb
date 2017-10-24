$(function(){
	var $Hour = $('#hour');
	var $Minutes = $('#minutes');
	var def_day = '--';
	var	def_value = 0;
	var str = '<option value="'+def_value+'" selected>'+def_day+'</option>';
	$Hour.append(str);
	$Minutes.append(str);

    for(var i=1; i<24; i++){
		var hStr = '<option value="'+i+'">'+i+'</option>';
		$Hour.append(hStr);
    }
    //分
    for(var i=1; i<60; i++){
		var minStr = '<option value="'+i+'">'+i+'</option>';
		$Minutes.append(minStr);
    }
    if($('.sm_form').length){
	 	var formTop = $('.sm_form').eq(0);
	 	var  ft = formTop.offset().top;
			formTop.css({'position':'relative'});
		var hrefs = '<div style="width: 100%; height: 1px; overflow: hidden;position: absolute; left: 0; top: -0.75rem;" id="ceForm"></div>';
			formTop.prepend(hrefs);
		var hTop = $('#ceForm').offset().top;
		var fiex = ''+
					'<div style=" width: 100%;  padding: 0.2778rem 0; position: fixed; left: 0; right: 0; bottom: 0; z-index: 99; background-color: #fff; border-top: 1px solid #f2f2f2; display:none;" class="fix">'+
						'<a href="javascript:;" style=" display: block; width: 95%; height: 1.4444rem; margin:0 auto; max-width: 684px; text-align: center; line-height: 1.4444rem; font-size: 0.5rem; color: #fff; background-color: #966a3b;"><i class="qmIocn">立即获取吉祥美名</i></a>'+
					'</div>';
		var fixDiv = '<div style="width:100%; height:2rem;" class="fixDiv"></div>';
		$('body').append(fiex).append(fixDiv);
		$(window).scroll(function(){
			var docTop = $(this).scrollTop()-20;
			if(docTop>=hTop){
				$('.fixDiv').show();
				$('.fix').show();
			}else{
				$('.fixDiv').hide();
				$('.fix').hide();
			}
		});
		$('.fix').click(function(){
			var t = $('#ceForm').offset().top;
			//console.log(t)
			$(window).scrollTop(t);
			$('.fixDiv').hide();
			$('.fix').hide();
		});     	
    }

	//常见问题
	if($('.comProItem').length){
		$('.comProItem').each(function(){
			$(this).click(function(){
				$('.comProItem dd').hide();
				$(this).find('dd').slideToggle();
			});
		});
	}

	/**************************************************/
	//订单标识
    //最新订单
	function getRnd(n){
		var num_str = "";
		for(var i=0;i<n;i++){
			var num = Math.floor(Math.random()*10);	
			num_str = num_str+num ;
		}	
		return num_str;
	} 
    var myDate = new Date();
    var month = myDate.getMonth()+1;
    var date = myDate.getDate();
    var datestr = myDate.getFullYear()+ '-' + (month<10 ?'0'+month:month) + '-' + (date<10?'0'+date:date) +"  "+gb_price+"元  ";
	var html = "";
	for(var i=0;i<20 ;i++){
		var order_no = getRnd(5);
		var myDateStr = myDate.getFullYear().toString();
		html = html+'<li>易经起名网 '+order_type_flag+'***'+order_no+'<i>'+gb_price+'元</i><span>'+datestr+'</span></li>' ;
	}
	if($('#latersMovelist').length){
		$('#latersMovelist').html(html);
	}
	//客户评论订单信息	
	$(".commList h5").each(function(index, element) {
		var v = ($(this).text()).toLowerCase(); 
		$(this).html(v.replace("cs17", order_type_flag+"0"));
	}); 

	
	if($('.bd_t_rl').length){
		$('.bd_t_rl').each(function(){
			var rl = '<span class="st_left"></span><span class="st_right"></span>';
			$(this).prepend(rl);
		});
	}

});
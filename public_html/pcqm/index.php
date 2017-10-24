<?php
function getHost() {
    $possibleHostSources = array('HTTP_X_FORWARDED_HOST', 'HTTP_HOST', 'SERVER_NAME', 'SERVER_ADDR');
    $sourceTransformations = array(
        "HTTP_X_FORWARDED_HOST" => function($value) {
            $elements = explode(',', $value);
            return trim(end($elements));
        }
    );
    $host = '';
    foreach ($possibleHostSources as $source)
    {
        if (!empty($host)) break;
        if (empty($_SERVER[$source])) continue;
        $host = $_SERVER[$source];
        if (array_key_exists($source, $sourceTransformations))
        {
            $host = $sourceTransformations[$source]($host);
        } 
    }

    // Remove port number from host
    $host = preg_replace('/:\d+$/', '', $host);

    return trim($host);
}
$companyname = "";
switch(getHost() ){
	case "quming.zirebao.cn":
		$companyname = "重庆道乐堂网络信息服务中心";
		break;
	case "qiming.tysxtx.top":
		$companyname = "南京天禹互动网络科技有限公司";
		break;
	case "qiming.kijijidns.com":
		$companyname = "百姓网股份有限公司 版权所有 沪ICP备06019413号";
		break;
	case "suan.w897.cn":
		$companyname = "洛阳尚禾电子商务有限公司";
		break;
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="pstyle/paystyle10/css/style.css?ver=2"/>
		<script src="pstyle/paystyle10/js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<title>八字起名网-最正宗的在线八字起名系统-大师在线为您起名</title>		
	</head>
	<body>
		<div class="header">
			<div class="container">
				<?php
				switch(getHost()){
					case "qiming.kijijidns.com":
						echo '<a href="http://www.baixing.com/" target="_blank" ><img src="pstyle/paystyle10/images/logo_baixing.png"/></a>';
						break;
					default:
						echo '<img src="pstyle/paystyle10/images/logo.png"/>';

				}
				?>
				<img src="pstyle/paystyle10/images/m.png" class="m"/>
			</div>
		</div>
		<div class="nav">
			<div class="container">
				<a href="/pcqm" class="active">首页</a>
				<a href="/pcqm#main">马上起名</a>
				<a href="/pcqm#img">起名优势</a>
				<a href="/pcqm#explain">客户评价</a>
				<a href="/pcqm#cjwn">常见问答</a>
				<a href="/order/pchistory">历史订单</a>
			</div>
		</div>
		<script src='pstyle/paystyle10/js/main.js'></script>
		<script src="paystyle/cookie.js"></script>
	<div class="banner"></div>
	<div class="banner2"></div>
	<div class="main" id="main">
		<div class="container" >
			<div class="bt">
				<div class="bt_left">
					<img src="pstyle/paystyle10/images/m2.png" />
				</div>
				<div class="bt_right" name="top" id="top">
					<h4>简单3步马上取得好名字<br /><span>为您节省 学习起名知识所需的大量时间</span></h4>
					<p class="name"><label for="">姓氏</label><span>：</span>
					<input type="text" id="xs_input" class='animated' />
					<span style="color: #c01212;">&nbsp;&nbsp;*</span></p>

					<!--选择名字start-->
					<div class="display_win" id='diswin'>
						<p class='closew'>请选择：<a class="close">关闭</a>
						<a class="qk">清空</a></p>
						<p id="lj">
							<span id='abc'>
								<a href="">常用</a>
								<a href="">A</a>
								<a href="">B</a>
								<a href="">C</a>
								<a href="">D</a>
								<a href="">E</a>
								<a href="">F</a>
								<a href="">G</a>
								<a href="">H</a>
								<a href="">J</a>
								<a href="">K</a>
								<a href="">L</a>
								<a href="">M</a>
								<a href="">N</a>
								<a href="">O</a>
								<a href="">P</a>
								<a href="">Q</a>
								<a href="">R</a>
								<a href="">S</a>
								<a href="">T</a>
								<a href="">W</a>
								<a href="">X</a>
								<a href="">Y</a>
								<a href="">Z</a>
							</span>
							<div class="bjx" id="bjx">
							
							</div>
					</div>
					<!--选择名字end-->


					<p> <label for="" style='margin-top:1px'>出生日期</label><span>：</span>
						<select name="" id='dtype'>
									<option value="公历">公历</option>
									<option value="农历">农历</option>
								</select>
						<select name="" class="year" id='year'></select> 年
						<select name="" class="month" id="month">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
								</select> 月
						
						<select name="" class="day" id="day">      </select> 日
						<select name="" class="time" id="time">    </select> 时
						<select name="" class="minute" id="minute"></select> 分
					</p>
					<div class="xb"><label for="" class="fl">性别</label><span style='margin-top: -15px;line-height: 25px;vertical-align: top;'>：</span>
						<div class="right J_sex" style="display: inline-block;position: inherit;">
							<span class="cur" data-value="1"><i></i><font>男</font></span>
							<span class="" data-value="0"><i></i><font>女</font></span>
							<input type="hidden" name="gender" id='gender' value="1">
							<input type="hidden" name="ver" id='ver' value="">
						</div>
					</div>
					<div class="qm_btn">
						<button id='cs'></button>
						<p>已有<span id="tjs">854821</span>人选择智能起名，<span>98.3%</span>好评！</p>
					</div>
					<h3>独家五行喜用神精确分析，全面提升人生运程 !</h3>
					<h3 id="addWeixin">加老师微信： 免费咨询起名知识</h3>
					<img src="pstyle/paystyle10/images/wx.png" style="padding:15px 0 0 0;">
				</div>
			</div>
			<div class="img" id="img" >
				<img src="pstyle/paystyle10/images/m3.png"  />
				<img src="pstyle/paystyle10/images/m4.png" />
				<img src="pstyle/paystyle10/images/m5.png" class="img_5" />
			</div>
		</div>
	</div>
	<div class="explain" id="explain">
		<div class="container">
			<div class="explain_left fl">
				<p><span><img src="pstyle/paystyle10/images/”.png"/></span>我参加工作是销售，业绩一直不是很好，选择了首席大师改名后，业绩第二个月就突飞猛进了，想不到名字有那么大的功效！</p>
				<div class="head_img fl">
					<img src="pstyle/paystyle10/images/head.png" />
					<div class="ddh fl">
						<h4>黄先生（广东）</h4>
						<p>订单号：CS170***4356</p>
					</div>
				</div>
			</div>
			<div class="explain_left fr">
				<p><span><img src="pstyle/paystyle10/images/”.png"/></span>
				我给小孩起了一个名字，非常不错，后来选择大师亲算，给我自己改了个名，从头到尾大师的专业能力都让我信服！</p>
				<div class="head_img fl">
					<img src="pstyle/paystyle10/images/head2.png" />
					<div class="ddh fl">
						<h4>李小姐（浙江）</h4>
						<p>订单号：CS170***7486</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="cjwn" id="cjwn">
		<div class="container">
			<div class="cjwt_content">
				<img src="pstyle/paystyle10/images/m8.png" />
				<ul>
					<li>
						<dt>付款后多久可以得到起名结果？</dt>
						<dd>我们是专业人工选名，下单后最快5分钟得到结果，有时候比较忙，请及时联系工作人员沟通。</dd>
					</li>
					<li>
						<dt>宝宝八字的五行，是缺什么就补什么吗？</dt>
						<dd>不是。需要区别对待，精确分析，真正做到“需要什么，则补什么”。否则就是简单加减，补救容易失误。</dd>
					</li>
					<li>
						<dt>名字的笔画五格评分越高越好吗？</dt>
						<dd>不对。好名字首要考虑八字五行是否助运、音形义好不好，然后再参考笔画五格评分。</dd>
					</li>
					<li>
						<dt>备选名考虑生肖部首宜忌吗？</dt>
						<dd>生肖起名就是小学生水平，我们知道生肖是年份的代表，但是月、日、时，都没考虑，怎么可能准呢？稍微聪明点的人，想一下就知道了。</dd>
					</li>
					<li>
						<dt>女性可以使用带有“孤寡运”数理暗示的名字吗？</dt>
						<dd>如果八字里面带有孤寡信息，应避免使用带有“孤寡运”数理暗示的名字。如果八字没有孤寡信息，则可以放心使用。</dd>
					</li>
					<li>
						<dt>名字不满意怎么办？</dt>
						<dd>在我们这里起名不满意率只有千分之二，原因大多是因为操作不熟练、需求不明确、追求满分造成的。 如果您有疑问请及时联系宝宝起名网客服，我们一定能完美解决您所提出的问题，争取满意百分之百。</dd>
					</li>
				</ul>
			</div>
		</div>
	</div>
<!--右边定位-->
	<div class="fix_right" style="top:37%">
		<a href="/pcqm#main">老师微信</a>
		<a href="/pcqm#main" id="weixin"></a>
		<a href="/pcqm#main">马上起名</a>
		<a href="/pcqm#img">起名优势</a>
		<a href="/pcqm#explain">客户评价</a>
		<a href="/pcqm#cjwn">常见问答</a>
		<a href="/order/pchistory">历史订单</a> 
	</div>
    <div class="footer">
        <p>
			<?php echo $companyname; ?>			</p>
	</div>
	
<script src="pstyle/paystyle6/js/ntog.js"></script>
<script type="text/javascript">
	var sexCheckbox = $('.J_sex');
	if (sexCheckbox.length) {
		sexCheckbox.children('span').on('click', function () {
			$(this).addClass('cur');
			$(this).siblings('span').removeClass('cur');
			var value = $(this).data('value');
			$(this).parent().find('input').val(value);
		});
	}
	$('#bjx a').live('click',function () {
		var val = $(this).html();
		$('#xs_input').val(val);
		$('.display_win').hide();
	});
	$('.close').click(function () {
		$('.display_win').hide();
	});
	$('#xs_input').click(function () {
		$('.display_win').show();
	});
	$('.qk').click(function () {
		$('#xs_input').val('');
	});

	//年
	var year = '<option value="{year}">{year}</option>';
	var _y_lsp = [];
	for (var i = 1940; i < 2050; i++) {
		_y_lsp.push(i);

	}
	for (var j = 0; j < _y_lsp.length; j++) {
		var _temp = year;
		_temp = _temp.replace(/{year}/g, _y_lsp[j]);
		if(_temp.indexOf('2017')!=-1){
			_temp=_temp.replace('option','option selected="selected" ');
		}
		$('.year').append(_temp);
	}
	//日
	var day = '<option value="{day}">{day}</option>';
	var _m_lsp = [];
	for (var k = 1; k < 32; k++) {
		_m_lsp.push(k);
	}
	for (var d = 0; d < _m_lsp.length; d++) {
		var m_temp = day;
		
		m_temp = m_temp.replace(/{day}/g, _m_lsp[d]);

		if(_m_lsp[d]==(new Date()).getDate()){
			m_temp=m_temp.replace('option','option selected="selected" ');
		}

		$('.day').append(m_temp);
	}
	//分
	var min = '<option value="{min}">{min}</option>';
	var _min_lsp = [];
	for (var m = 0; m < 60; m++) {
		_min_lsp.push(m);
	}
	for (var m1 = 0; m1 < _min_lsp.length; m1++) {
		var min_temp = min;
		min_temp = min_temp.replace(/{min}/g, _min_lsp[m1]);
		$('.minute').append(min_temp);
	}
	$('#diswin').mouseleave(function(){
		$(this).hide();
	})
</script>
<script>
    var master="dong";
    $(function(){
		$("#cs").click(function(){
			cs();
		})
		var id=0;
		$(".banner,.banner2,#img,#explain,#cjwn").css('cursor','pointer').click(function(){
			location.href='#top';
		})
    })

	function getRandomInt(min, max) {
		min = Math.ceil(min);
		max = Math.floor(max);
		return Math.floor(Math.random() * (max - min)) + min;
	}

	function cs(){
		//if($('#agree').prop('checked')===false){
		//	$("#agreebox").addClass('shake');next=false;clearshake();return;
		//}

		$("#xs_input").val($("#xs_input").val().replace(/[^\u4E00-\u9FA5]/g,''));
		 
		if($("#xs_input").val()=='' || $("#xs_input").val().length>2){
			 $("#xs_input").addClass('shake');next=false;clearshake();return;
		}
		if($("#b_input").val()==''    )	{
			 $("#xs_input").addClass('shake');next=false;clearshake();return;
		}
		var xm=$("#xs_input").val();


	 
		var _newdata=$("#year").val()+"-"+$("#month").val()+'-'+$("#day").val();
		if( $("#dtype").val()=='农历' ){
			_newdata=_newdata.split('-');
			var _s = calendar.lunar2solar(parseInt(_newdata[0]),parseInt(_newdata[1]),parseInt(_newdata[2]) );
			_newdata=(_s.cYear+"-"+_s.cMonth+'-'+_s.cDay)   ;
		}


		var o={};
			o.name=xm;
			o.gender=$("#gender").val();
			o.birthday=_newdata;
			o.xing=xm;
			o.ming='';
			o.birthtime=$("#time").val();
			o.birthmin=$("#minute").val(); 
			o.phone=(+new Date())+""+getRandomInt(1000,9999);
			o.ver=$("#ver").val();
		var next=true;
		 
		if(!next){
			clearshake();return;
		}

		location.href='order10/order?'+$.param(o);

	}
	function clearshake(){
		setTimeout(function(){$(".shake").removeClass('shake');},2000)
	}

/**********************设置微信cookie*******************************/
	var randNum = Math.round(Math.random()*2);
	var weixinArr = ['qiming8886','qiming88666','quming8866'];
	//如果没有获取到cookie  则生成cookie
	if(getCookie('weixin')){
		$('#addWeixin').html('加老师微信：'+getCookie('weixin')+' 免费咨询起名知识');
		$('#weixin').html(getCookie('weixin'));
	}else{
		setCookie("weixin",weixinArr[randNum],"d365");
		$('#addWeixin').html('加老师微信：'+getCookie('weixin')+' 免费咨询起名知识');
		$('#weixin').html(getCookie('weixin'));
	}
/*****************************************************/
	var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "https://hm.baidu.com/hm.js?d6171fc44735066530ba341c3c20049e";
	  var s = document.getElementsByTagName("script")[0]; 
	  s.parentNode.insertBefore(hm, s);
	})();

	console.log('referer result is '+getCookie('referer'));
</script>
	</body>

</html>
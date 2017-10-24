// JavaScript Document
//构造函数
jQuery.fn.extend({
	selectbox: function(options) {
		return this.each(function() {
			new jQuery.SelectBox(this, options);
		});
	}
});


/* 浏览器调试框日志消息 */
if (!window.console) {
	var console = {
		log: function(msg) { 
		alert(msg);
	 }
	}
}
/* */

jQuery.SelectBox = function(selectobj, options) {
	
	var opt = options || {};
	opt.inputClass = opt.inputClass || "selectbox";
	opt.containerClass = opt.containerClass || "selectbox-wrapper";
	opt.hoverClass = opt.hoverClass || "current";
	opt.currentClass = opt.selectedClass || "selected"
	opt.debug = opt.debug || false;
	opt.select_options = opt.select_options || [] ;//下拉列表的子项参数,是一个数组
	opt.defaults= opt.defaults || ''; //初始化时手动设置默认选中的值 
	opt.allowLoad = (new RegExp(/\d+/g)).test(opt.allowLoad)?opt.allowLoad: 1;//初始化时标识是否需要加载下拉框中的原始选项。0/1
	
	var elm_id = selectobj.id;  //原始下拉框的id
	var active = 0;
	var inFocus = false;
	var hasfocus = 0;
	var $container = null ; //初始下拉框为null对象
	//jquery object for select element
	var $select = $(selectobj); //下拉框对象
	opt.select_width = $select.attr("width") || 0; //初始获取下拉框是否设定了宽度 
	 
	//当手动设置默认选中值不为空时初始化原始下拉列表中的默认选中项。
	if(opt.select_options.length==0&&opt.defaults!= ''){
		$select.children('option').each(function() {
			if(opt.defaults==$(this).text()){
				$(this).attr("selected","selected");	
			}
		});
	}
	//jquery input object 
	var $input = setupInput(opt);  //模拟显示下拉框的对象
	//如果数据是手动设置的初始化下拉框中的数据 
	if(opt.select_options.length>0){
		//直接手动给参数设置下拉列表的子项
		var html = "";	
		for(var i=0;i<opt.select_options.length;i++){
			var seled = opt.select_options[i]==opt.defaults ?" selected='selected' ":"";
			html += "<option value='"+opt.select_options[i]+"' "+seled+">"+opt.select_options[i]+"</option>"; 
			
		}
		$select.append(html);
	}
	// hide select and append newly created elements
	$select.hide();
	$($select.parent()).append($input); //初始下拉框
	$input.click(function(){ 
		if($(".selectbox-wrapper")){
			$(".selectbox-wrapper").remove();
		}
		$container = setupContainer(opt); //创建下拉框的子项option容器
		$select.before($container); 
		//初始化下拉框的选项，并且显示出来；
		
		$container.append(getSelectOptions($input.attr('id')));
		//设置默认选项的首选位置
		var selected_option = $container.find(".selected"); 
		var selected_option_top = $(selected_option).index() * $(selected_option).innerHeight();
		//console.log("当前选中的："+$(selected_option).innerHeight()+" "+$(selected_option).index());
		$($container).scrollTop(selected_option_top);
		 
		if(!$.browser.msie){
			$container.focus();//设置下拉子项获得了焦点。
		}
		$container.blur(function(){
			hideMe(); //下拉展示失去焦点时就删除
		});
		return false;
	})
	.keydown(function(event) {	   
		switch(event.keyCode) {
			case 38: // up
				event.preventDefault();
				moveSelect(-1);
				break;
			case 40: // down
				event.preventDefault();
				moveSelect(1);
				break;
			//case 9:  // tab 
			case 13: // return
				event.preventDefault(); // seems not working in mac !
				$('li.'+opt.hoverClass).trigger('click');
				break;
			case 27: //escape
			  hideMe();
			  break;
		}
	}).blur(function() {
		if($.browser.msie){
			var $id =document.activeElement.getAttribute('id');
			$id = $id!="undefined"&&$id!=""&&$id!=null?$id:"0";
			if($id.indexOf('_container')==-1){
				hideMe();
			} 
		}
	}); 
	
	function hideMe() { 
		hasfocus = 0;
		$container.remove(); 
	}
	function setupInput(options) {
		if($("#"+elm_id+"_input").attr("id")==elm_id+"_input"){
			$("#"+elm_id+"_input").remove()
		}
		var input = document.createElement("input");
		var $input = $(input);
		$input.attr("id", elm_id+"_input");
		$input.attr("type", "text");
		$input.addClass(options.inputClass);
		//$input.attr("autocomplete", "off");
		$input.attr("readonly", "readonly");
		//设置初始显示 
		var init_val = "";
		//当手动设置参数不为空和标识是否允许加载下拉列表原始选项
		if(opt.select_options.length>0 && parseInt(opt.allowLoad) ==1){
			//手动给参数时，先检查下拉列表中是否还有子项，如果有的话自动把该子项排在前排
			$select.children('option').each(function() {
				var $options_str = opt.select_options.join(";"); 
				var $curr_options = $(this).text();
				if($options_str.indexOf($curr_options)<0){
					opt.select_options.unshift($curr_options);//追加到数组第一位
				}
			});
		 
			//手动设置了默认显示，则首先显示手动设置的
			init_val = opt.defaults!='' ? opt.defaults : opt.select_options[0] ;
			//下拉列表子项手动设置参数--默认显示参数的第一项
			$input.val(init_val);
		}else{
			//手动设置了默认显示，则首先显示手动设置的
			init_val = opt.defaults!='' ? opt.defaults : $select.find("option:selected").text() ;
			//下拉列表子项自动读取列表
			$input.val(init_val);
		}
		$input.attr("tabIndex", $select.attr("tabindex")); // "I" capital is important for ie
		//宽度允许设置百分比，
		if(opt.select_width.replace("%","") >0){ 
			$input.css({'width': opt.select_width,"margin":"0px"} );
		}
		return $input;	
		
	}
	function setupContainer(options) {
		if($("#"+elm_id+"_container").attr("id")==elm_id+"_container"){
			$("#"+elm_id+"_container").remove()
		}
		var container = document.createElement("div");
		$container = $(container);
		$container.attr('id', elm_id+'_container');
		$container.addClass(options.containerClass);  
		$container.css('width', $("#"+elm_id+"_input").width()+2);
		var pd_h = parseInt($("#"+elm_id+"_input").css("padding-top").replace("px",""))+parseInt($("#"+elm_id+"_input").css("padding-bottom").replace("px","")); 
		$container.css('margin-top', $("#"+elm_id+"_input").height()+2+pd_h); 
		//防止点击下拉框时获得焦点导致页面滚动
		$container.attr("tabIndex",0 ); // "I" capital is important for ie $select.attr("tabindex")
		return $container;
	}
	
	function moveSelect(step) {
		var lis = $("li", $container);
		if (!lis || lis.length == 0) return false;
		active += step;
    	//loop through list
		if (active < 0) {
			active = lis.size();
		} else if (active > lis.size()) {
			active = 0;
		}
    	scroll(lis, active);
		lis.removeClass(opt.hoverClass);

		$(lis[active]).addClass(opt.hoverClass);
	}
	
	function scroll(list, active) {
      var el = $(list[active]).get(0);
      var list = $container.get(0);
      
      if (el.offsetTop + el.offsetHeight > list.scrollTop + list.clientHeight) {
        list.scrollTop = el.offsetTop + el.offsetHeight - list.clientHeight;      
      } else if(el.offsetTop < list.scrollTop) {
        list.scrollTop = el.offsetTop;
      }
	}
	
	function setCurrent() {	
		var li = $("li."+opt.currentClass, $container).get(0);
		var ar = (''+li.id).split('_');
		var el = ar[ar.length-1];
		$select.val(el);
		$input.val($(li).html());
		return true;
	}
	
	// select value
	function getCurrentSelected() {
		return $select.val();
	}
	
	// input value
	function getCurrentValue() {
		return $input.val();
	}
	
	function getSelectOptions(parentid) {
		var select_options = new Array();
		var ul = document.createElement('ul'); 
		if(opt.select_options.length>0){
			//直接手动给参数设置下拉列表的子项	
			for(var i=0;i<opt.select_options.length;i++){
				var li = document.createElement('li'); 
				li.setAttribute('id', parentid + '_' + opt.select_options[i]);
				li.innerHTML = opt.select_options[i];
				var df_select_options = $input.val();
				//高亮显示默认选中的
				if (df_select_options==opt.select_options[i]) {
					$input.val(opt.select_options[i]);
					$(li).addClass(opt.currentClass).focus();
				}
				ul.appendChild(li);
				$(li).bind({
					mouseover : function(event){
						hasfocus = 1;
						if (opt.debug) console.log('over on : '+this.id);
						jQuery(event.target, $container).addClass(opt.hoverClass);
					}	,
					mouseout : function(event){
						hasfocus = -1;
						if (opt.debug) console.log('out on : '+this.id);
						jQuery(event.target, $container).removeClass(opt.hoverClass);
					},
					click : function(event){ 
						var fl = $('li.'+opt.hoverClass, $container).get(0);
						if (opt.debug) console.log('click on :'+this.id);
						$('#' + elm_id + '_container' + ' li.'+opt.currentClass).removeClass(opt.currentClass); 
						$(this).addClass(opt.currentClass);
						setCurrent();
						$select.change();
						$select.get(0).blur();
						hideMe();
					}
				}); 
			} 
		}else{
			//读取源下拉列表的options选项
			//alert(opt.select_options.length)	 
			$select.children('option').each(function() {
				var li = document.createElement('li'); 
				li.setAttribute('id', parentid + '_' + $(this).val());
				li.innerHTML = $(this).html(); 
				/*if(opt.defaults==$(this).html()){
					$input.val($(this).html());
					$(li).addClass(opt.currentClass);
				}else{
				
				}*/ 
				//高亮显示默认选中的
				if ($(this).is(':selected')) {
					$input.val($(this).html());
					$(li).addClass(opt.currentClass);
				}
				ul.appendChild(li);
				$(li).bind({
					mouseover : function(event){
						
						hasfocus = 1;
						if (opt.debug) console.log('over on : '+this.id);
						jQuery(event.target, $container).addClass(opt.hoverClass);
					}	,
					mouseout : function(event){
						hasfocus = -1;
						if (opt.debug) console.log('out on : '+this.id);
						jQuery(event.target, $container).removeClass(opt.hoverClass);
					},
					click : function(event){ 
						var fl = $('li.'+opt.hoverClass, $container).get(0);
						if (opt.debug) console.log('click on :'+this.id);
						$('#' + elm_id + '_container' + ' li.'+opt.currentClass).removeClass(opt.currentClass); 
						$(this).addClass(opt.currentClass);
						setCurrent();
						$select.change();
						$select.get(0).blur();
						hideMe();
					}
				});
				 
			});
		}
		
		
		return ul;
	}
	
	
	
};

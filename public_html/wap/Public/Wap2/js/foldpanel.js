
(function($) {
    $.fn.foldpanel = function(options) {
        var _init = options.init || true,
            _time = options.time || 100,
            _dbclose = options.dbclose || true,
            _flag = false;
        return this.each(function() {
            var $dts = $(this).children('dt');
            $dts.click(onClick);
            $dts.each(reset);
            if ( _init ) {
                $dts.eq(0).next().hide( _time );
                $dts.eq(0).data('flag', true);
            };
        });
        function onClick() {
            _this = $(this);
            _this.show();
            _this.siblings('dt').each(hide);
            if ( _dbclose ) {
                if ( _this.data('flag') ) {
                    _this.next().show( _time );
                    _this.data('flag', false);
                }else{
                    _this.next().show( _time );
                    _this.data('flag', true);
                }
                return false;
            }else{
                _this.next().show( _time );
            }
        }
        function hide() {
            $(this).next().hide( _time );
        }
        function reset() {
            _this = $(this);
            _this.next().hide();
            _this.data('flag', _flag);
        }
    }
})(jQuery);


// JavaScript Document
(function($){
	$.fn.myScroll = function(options){
	//默认配置
	var defaults = {
		speed:40,  //滚动速度,值越大速度越慢
		rowHeight:24 //每行的高度
	};
	
	var opts = $.extend({}, defaults, options),intId = [];
	
	function marquee(obj, step){
	
		obj.find("ul").animate({
			marginTop: '-=1'
		},0,function(){
				var s = Math.abs(parseInt($(this).css("margin-top")));
				if(s >= step){
					$(this).find("li").slice(0, 1).appendTo($(this));
					$(this).css("margin-top", 0);
				}
			});
		}
		
		this.each(function(i){
			var sh = opts["rowHeight"],speed = opts["speed"],_this = $(this);
			intId[i] = setInterval(function(){
				if(_this.find("ul").height()<=_this.height()){
					clearInterval(intId[i]);
				}else{
					marquee(_this, sh);
				}
			}, speed);

//			_this.hover(function(){
//				clearInterval(intId[i]);
//			},function(){
//				intId[i] = setInterval(function(){
//					if(_this.find("ul").height()<=_this.height()){
//						clearInterval(intId[i]);
//					}else{
//						marquee(_this, sh);
//					}
//				}, speed);
//			});
		
		});

	}

})(jQuery);
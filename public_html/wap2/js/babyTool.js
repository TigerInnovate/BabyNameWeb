NavigatorTooLow = (function() {
    return (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE6.0" ||
        navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE7.0" ||
        navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE8.0" ||
        navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE9.0");
})(window);
babyTool = (function() {
    "use strict";
    return {
        isOnline:(function(){
        	return navigator.onLine;
        })(),
        isPhone: function(str) {
            return RegExp(/^1[34578]\d{9}$/).test(str);
        },
        storage: (function() {
            var $obj = '';
            if (NavigatorTooLow || (!window.localStorage)) {
                $obj = {
                    get: function(key) {
                        if (Cookies.set(key))
                            return JSON.parse(Cookies.set(key));
                    },
                    set: function(key, value) {
                        Cookies.set(key, JSON.stringify(value), { expires: 9999 });
                    },
                    remove: function(key) {
                        Cookies.remove(key);
                    }
                };
            } else {
                $obj = {
                    get: function(key) {
                        return JSON.parse(window.localStorage.getItem(key));
                    },
                    set: function(key, value) {
                        window.localStorage.setItem(key, JSON.stringify(value));
                    },
                    remove: function(key) {
                        window.localStorage.removeItem(key);
                    }
                };
            }
            return $obj;
        })(),
        showTips:function(tipsContent){
        	var tipObj = $('.form-error');
        	if(!tipObj || !tipsContent ){
        		return false;
        	}
        	tipObj.text(tipsContent);
        	tipObj.fadeIn();
        	var errorMsgHide = setInterval(function() {
        	    tipObj.fadeOut();
        	}, 5000);
        	setInterval(function() {
        	    clearInterval(errorMsgHide);
        	}, 5010);
        }
    };
})(window);
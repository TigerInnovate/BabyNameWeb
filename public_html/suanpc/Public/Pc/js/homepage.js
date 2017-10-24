// JavaScript Document
var HomepageFavorite = {
    //设为首页
    Homepage: function () {
        if(document.all){
			try {
            document.body.style.behavior = 'url(#default#homepage)';
            document.body.setHomePage(window.location.href);
            }catch (e) {alert("抱歉，您所使用的浏览器无法完成此操作。\n\n您需要手动将【"+window.location.href+"】设置为首页。");}

        }else if (window.sidebar) {
            if (window.netscape) {
                try {
                    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                }catch (e) {
                    alert("该操作被浏览器拒绝，如果想启用该功能，请在地址栏内输入 about:config,然后将项 signed.applets.codebase_principal_support 值该为true");
                    //history.go(-1);
                }
            }
            var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
            prefs.setCharPref('browser.startup.homepage', window.location.href);
        }else{alert("抱歉，您所使用的浏览器无法完成此操作。\n\n您需要手动将【"+window.location.href+"】设置为首页。");}
    }, //加入收藏
    Favorite: function (sURL, sTitle) {
        try {
            window.external.addFavorite(sURL, sTitle);
        }catch (e) {
            try {
                window.sidebar.addPanel(sTitle, sURL, "");
            }catch (e) {
                alert("加入收藏失败,请手动添加。请使用Ctrl+D进行添加!");
            }
        }
    }
}
//验证是否是手机访问
function isMobileToWap(wap_url) {
	var regex_match = /(nokia|iphone|android|motorola|^mot-|softbank|foma|docomo|kddi|up.browser|up.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte-|longcos|pantech|gionee|^sie-|portalmmm|jigs browser|hiptop|^benq|haier|^lct|operas*mobi|opera*mini|320x320|240x320|176x220)/i;
	var $nUagent = navigator.userAgent;
	if ($nUagent == null) {
		document.location.href=wap_url;
	}
	var result = regex_match.exec($nUagent); 
	if (result == null ) {
		return false
	}else {
	 document.location.href = wap_url;
	}
 }


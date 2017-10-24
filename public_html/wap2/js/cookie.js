(function(){
   var createCookie= function(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

   var readCookie= function(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

   var eraseCookie= function(name) {
        createCookie(name,"",-1);
    }


   var setVer=function(){
       var url=location.href;
       if(url.indexOf('ver')!=-1){
          var url= url.split('ver=');
          var ver=url[1];
          createCookie('ver',ver,30);
       }
   }

   setVer();
})();
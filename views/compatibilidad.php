<script type="text/javascript"> 
<!--
    // Cookie handling 
    var Cookie =
    {
        read: function (name)
        {
            var arrCookies = document.cookie.split ('; ');
            for (var i=0; i<arrCookies.length; i++)
            {
                var arrCookie = arrCookies[i].split ('=');
                
                if (arrCookie[0] == name)
                {
                    return decodeURIComponent (arrCookie[1]);
                }
            }
            return false;
        },
    
        write: function (name, value, expires, path)
        {
            if (expires)
            {
                var date = new Date ();
                date.setTime (date.getTime () + (((((expires * 24) * 60) * 60) * 1000)));
                expires = '; expires=' + date.toGMTString ();
            }
            else expires = '';
    
            if (!path) path = '/';
    
            document.cookie = name+'='+encodeURIComponent (value)+expires+'; path='+path;
        },
    
        remove: function (name)
        {
            this.write (name, '', -1);
        }
    }
    
    // Detects if can set a cookie in the browser
    function browserSupportsCookies()
    {
        Cookie.write('cookiesEnabled', 1);
        var boolCookiesEnabled = Cookie.read('cookiesEnabled');
        Cookie.remove('cookiesEnabled');
        if (boolCookiesEnabled != 1)
        {
            return false;
        }
        return true;
    }
    
    // Detects if the browser supports Ajax 
    function browserSupportsAjax()
    {
        if (typeof XMLHttpRequest == "undefined" && typeof ActiveXObject == "undefined" && window.createRequest == "undefined")
        {
            return false;
        }
        return true
    }
    
    // Detects if the browser can use ActiveX if necessary
    function ActiveXEnabledOrUnnecessary ()
    {
        if (typeof ActiveXObject != "undefined")
        {
            var xhr = null;
            try{
                xhr=new ActiveXObject("Msxml2.XMLHTTP");
            }catch (e){
                try{
                    xhr=new ActiveXObject("Microsoft.XMLHTTP");
                }catch (e2){
                    try{
                        xhr=new ActiveXObject("Msxml2.XMLHTTP.4.0");
                    }catch (e3){
                        xhr=null;
                    }
                }
            }
            if (xhr == null)
            {
                return false
            }
        }
        
        return true;
    }
-->
</script> 
 
<!-- Detect support for cookies and Ajax and display message if not -->        
<div id="supportError"> 
    <noscript> 
        <div>Su navegador de internet tiene deshabilitado JavaScript o no lo soporta.<br /><br />
	Esta aplicacion web requiere JavaScript para que funcione correctamente.<br /><br />
	Por favor habilite JavaScript en las configuraciones de su navegador,
	o actualice a un navegador con soporte de JavaScript e intentelo de nuevo.</div>
    </noscript> 
    
    <script type="text/javascript"> 
    <!--
    
    if (!browserSupportsCookies())
    {
        var msg = '<div>Su navegador de internet tiene deshabilitado Cookies o no lo soporta.<br><br>Esta aplicacion web requiere Cookies para que funcione correctamente.<br><br> Por favor habilite Cookies en las configuraciones de su navegador, o actualice a un navegador con soporte de JavaScript e intentelo de nuevo.</div>';
        
        document.write(msg);
    }else{
		//document.write("<br>Tu navegador soporta cookies");
	}
    
    if (!browserSupportsAjax())
    {
        var msg = '<div>Parece que su navegador no soporta la tecnologia Ajax.<br><br>'
        msg += 'Esta aplicacion web requiere Ajax para que funcione correctamente.<br><br>';
        msg += 'Por favor actualice a un navegador con soporte de Ajax e intentelo de nuevo.</div>';
        
        document.write(msg);
    }else{
		//document.write("<br>Tu navegador soporta Ajax");
	}
        
    if (!ActiveXEnabledOrUnnecessary())
    {
        var msg = '<div>Parece que ActiveX está deshabilitado en su navegador.<br><br>';
        msg += 'Esta aplicacion web requiere Ajax para que funcione correctamente.<br><br>';
        msg += 'En las versiones anteriores del internet explorer 7.0, Ajax es implementado usando ActiveX.<br><br>';
        msg += 'Por favor habilite ActiveX en las configuraciones de seguridad de su navegador ';
        msg += 'o actualice a un navegador con soporte de Ajax e intentelo de nuevo.</div>';
        
        document.write(msg);
    }else{
		//document.write("<br>Tu navegador soporta Activex");
	}
	
	if(browserSupportsCookies() && browserSupportsAjax() && ActiveXEnabledOrUnnecessary())
		document.getElementById("index_container").style.visibility='visible';
    -->
    </script> 
</div> 
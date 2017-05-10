
function Solo_Numerico(variable){
        Numer=variable;
        if (isNaN(Numer)){
            return "";
        }
        return Numer;
    }
    function ValNumero(Control){
        Control.value=Solo_Numerico(Control.value);
    }
    
    function is_mobile() {
	    var agents = ['android', 'webos', 'iphone', 'ipad', 'blackberry'];
	    for(i in agents) {
	        if(navigator.userAgent.match('/'+agents[i]+'/i')) {
	            return true;
	        }
	    }
	    return false;
	}
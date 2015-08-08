
/**
*
* Plugin CMS
*
* @versão 4.2.7
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
function ajax() {
   try {
      xmlhttp = new XMLHttpRequest();
   }
   catch(ee) {
      try {
         xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
      }
      catch(e) {
         try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
         }
         catch(E) {
            xmlhttp = false;
         }
      }
   }
   return xmlhttp;
}


///////////////////////////////////////////////////////////////////// PHP FUNCTIONS
function empty( mixed_var ) {
    var key;
    
    if (mixed_var === "" ||
        mixed_var === 0 ||
        mixed_var === "0" ||
        mixed_var === null ||
        mixed_var === false ||
        mixed_var === undefined
    ){
        return true;
    }

    if (typeof mixed_var == 'object') {
        for (key in mixed_var) {
            return false;
        }
        return true;
    }

    return false;
}

function isset () {
    var a=arguments, l=a.length, i=0;
    
    if (l===0) {
        throw new Error('Empty isset'); 
    }
    
    while (i!==l) {
        if (typeof(a[i])=='undefined' || a[i]===null) { 
            return false; 
        } else { 
            i++; 
        }
    }
    return true;
}

function substr(f_string, f_start, f_length) {
    f_string += '';

    if (f_start < 0) {
        f_start += f_string.length;
    }

    if (f_length == undefined) {
        f_length = f_string.length;
    } else if (f_length < 0){
        f_length += f_string.length;
    } else {
        f_length += f_start;
    }

    if (f_length < f_start) {
        f_length = f_start;
    }

    return f_string.substring(f_start, f_length);
}

/////////////////////////////////////////////////////////////////////
function ajustaForm(){	
	$('form select').width(function(){
		$(this).width($(this).width()+10);
	});
}


function confirmAlgo(texto){ // TEXTO DE CONFIRMAÇÃO (TEXTO)
	if(texto.indexOf('?') > 0){
		var agree=confirm(texto);
	} else {
		var agree=confirm("Tem certeza que deseja excluir "+texto+"?");
	}
	if (agree){
		return true ;
	} else {
		return false ;
	}
} 



/*************************************************************/

function plg_load(url){
	if(url == 'load')
		$('#tudo').prepend('<div id="plg_load"></div>');
	else
		$('#plg_load').load(url);
}

function plg_sessionFix(){
	$('body').append('<div id="atlSession"></div>');
	setInterval(function(){
		$("#atlSession").load("includes/session_start.php");
	}, 1000*60*10);
}


function selecionartodos(ret){
	if (ret == false) {
		for (i=1;i<document.form1.length;i++){
			if (document.form1.elements[i].checked==true){
				document.form1.elements[i].checked=false;
			} 
		}
	} else {
		for (i=1;i<document.form1.length;i++){
			if (document.form1.elements[i].checked==false){
				document.form1.elements[i].checked=true;
			} 
		}
	}
}

function plg_addDesk(){
	var	nome = prompt("Qual será a identificação dessa página em seu desktop?");
	
	if (nome!=null && nome!="")
		plg_load('includes/desktop.php?nome='+nome);
	
}
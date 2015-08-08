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

function mLvisible(divId){// MOSTRA ITEM POR visibility (ID_DO_ITEM)
	document.getElementById(divId).style.visibility = 'visible';
}

function mLHidden(divId){ // ESCONDE ITEM POR visibility (ID_DO_ITEM)
	document.getElementById(divId).style.visibility = 'hidden';
}

function show_hide(id) { // OCULTA E MOSTRA ITENS (ID_DO_ITEM)
	if (document.getElementById(id).style.display=='none') {
		document.getElementById(id).style.display='block';
	} else {
		document.getElementById(id).style.display='none';
	}
}

function sForm(form, url){ // SUBMIT EM FORMULARIO (ID_DO_FORM, URL_ACTION)
	document.getElementById(form).action=url;
	document.getElementById(form).submit();
}

function loadPage(url, tempo){ // CARREGA UMA PÁGINA POR JS (URL_DA_PAGINA, TEMPO_DE_ESPERA)
	if(isset(tempo)){
		setTimeout("loadPage('"+url+"')", tempo*1000); 
	} else {
		document.location = url;
	}
}

document.write('<div id="exectAjax"></div>');
document.write('<img src="imagens/layout/loading.gif" style="display: none;" id="loadImg" />');

ajaxBox = new ajax();
function mLExectAjax(pagina){
	document.getElementById('loadImg').style.display = "block";
	
	ajaxBox.open("get",pagina,true);
	ajaxBox.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	ajaxBox.onreadystatechange=function() {
		if(ajaxBox.readyState==4) {
			document.getElementById('loadImg').style.display = "none";
			document.getElementById('exectAjax').innerHTML = ajaxBox.responseText; 
		}
	}
	ajaxBox.send(null);
}

document.write('<div id="mLAviso" style="display: none;"><div id="mLAvisoInter"></div><a href=\'javascript: void(0)\' onclick=\"fechaAviso()\" class=\'close\'>X</a></div>');
function mLaviso(texto, tempo){
	var tempo = (tempo > 0?parseInt(tempo):2);
	
	$(document).jfaviso(texto, tempo);
	/*
	

	$('#mLAvisoInter').html(texto);
	$("#mLAviso").slideDown(200);

	setTimeout("fechaAviso()", tempo*1000); 
	*/
}

function fechaAviso(){
	$('#mLAviso').slideUp(300);
}


/*************************************************************/

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

function nomeDaPagina(){
	var	nome = prompt("Qual será a identificação dessa página em seu desktop?");
	
	if (nome!=null && nome!=""){
		mLExectAjax('includes/desktop.php?nome='+nome);
	}
}
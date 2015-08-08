function limpAllEvent(portaid){
	tabela = document.getElementById('namTable').value;
	
	if(empty(portaid) == false){
		tiraSelect(portaid, tabela);
	} else {
		portaid = document.getElementById('idPag').value;
		tiraSelect(portaid, tabela);
	}
}

function editName(divId, nAlt){
	portaid = document.getElementById('idPag').value;
	
	if(empty(portaid) == false){
		limpAllEvent(portaid);
	}
	
	document.getElementById(divId).innerHTML = "<input type='text' class='edna' id='in"+divId+"'  maxlength='256' value='"+nAlt+"'/>";
	document.getElementById('idPag').value = divId;
	document.getElementById("in"+divId).focus();
}


function disparaPorTec(e){
	var k = e.keyCode||e.charCode;
	if(isset(document.getElementById('namTable'))){
		if (k == 13){		
			portaid = document.getElementById('idPag').value;
			tabela = document.getElementById('namTable').value;
			
			alteraNome(portaid, tabela);
			
		return false;
		} 
		
		if (k == 113){		
			portaid = document.getElementById('idPag').value;
			texto = document.getElementById(portaid).title;
		
			editName(portaid, texto);			
		} 
		
		if(k == 46){
			portaid = document.getElementById('idPag').value;
			tabela = document.getElementById('namTable').value;
			
			deletaArquivo(portaid, tabela);
		}
	}
}

function selectPag(divId, linked){
	portaid = document.getElementById('idPag').value;
		
	if(empty(portaid) == false){
		document.getElementById("div"+portaid).style.borderColor = "#ffffff";
		document.getElementById("div"+portaid).style.background = "transparent";
	}
	
	document.getElementById('idPag').value = divId;
	document.getElementById('linked').value = linked;
	
	document.getElementById("div"+divId).style.background = "#f9f9f9";
	document.getElementById("div"+divId).style.borderColor = "#bbbbbb";
}


function tiraSelect(portaid, tabela){
		if(portaid != ''){
			document.getElementById("div"+portaid).style.borderColor = "#ffffff";
			document.getElementById("div"+portaid).style.background = "transparent";
				
			alteraNome(portaid, tabela);
			
			document.getElementById('idPag').value = "";
			document.getElementById('linked').value = "";
		}
} 

function deletaArquivo(portaid, tabela, confirmed){
	if(empty(portaid) == false){
		var linked = document.getElementById('linked').value
		
		if((linked == '0') || (confirmed == true)){
			if((confirmed == true) || (confirmAlgo('esse item') == true)){
				mLExectAjax('includes/jnav/delfile.php?id='+portaid+'&tabela='+tabela);
			
				document.getElementById("div"+portaid).style.display= "none";
		
				document.getElementById('idPag').value = "";
				document.getElementById('linked').value = "";
			}
		} else if(linked == ''){
		
		} else {
			if(linked != 'off'){
				if(confirmAlgo('Esse item possui ligações com outras fontes de dados, deseja continuar o processo de exclusão?') == true){
					mLOpenBox(document.getElementById('linked').value);
				}
			} else {
				alert('Esse item possui ligações com outras fontes de dados.\n Para continuar o processo de exclusão todos as ligações pertencentes a esse item.');
			}
		}
	}
}


function alteraNome(portaid, tabela){
	if(isset(document.getElementById("in"+portaid)) == true){
			
		namPag = document.getElementById("in"+portaid).value;
		if(empty(namPag) == false){
			mLExectAjax('includes/jnav/rename.php?id='+portaid+'&nome='+namPag+'&tabela='+tabela);
			
			if(namPag.length > 12){
				namPagLink = substr(namPag, 0, 9)+"...";
			} else {
				namPagLink = namPag;
			}
			
			document.getElementById(portaid).innerHTML = "<a href=\"javascript: void(0);\" ondblclick=\"editName('"+portaid+"', '"+namPag+"')\">"+namPagLink+"</a>";
		}
	}
}

function carregaConteudo(enter, div){
	document.getElementById(div).innerHTML += ""+enter+"";
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

document.write('<div id="ajaxBoxGeral" style="display: none;"><div id="ajaxBoxAling"><a href="javascript: void(0)" onclick="mLCloseBox()" class="ajaxBoxClose"><img src="imagens/layout/close_box.png"></a><div id="ajaxBox"></div></div></div>');
document.write('<div id="ajaxBoxfundo" style="display: none;"></div>');

ajaxBox = new ajax();
function mLOpenBox(pagina){
	document.getElementById('loadImg').style.display = "block";
	document.getElementById('ajaxBoxGeral').style.display = "block";
	document.getElementById('ajaxBoxfundo').style.display = "block";
	
	ajaxBox.open("get",pagina,true);
	ajaxBox.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	ajaxBox.onreadystatechange=function() {
		if(ajaxBox.readyState==4) {
			document.getElementById('loadImg').style.display = "none";
			document.getElementById('ajaxBox').innerHTML = ajaxBox.responseText; 
		}
	}
	ajaxBox.send(null);
}

function mLCloseBox(){	
	document.getElementById('ajaxBoxGeral').style.display = "none";
	document.getElementById('ajaxBoxfundo').style.display = "none";
}


document.write('<div id="mLAviso" style="display: none;"><div id="mLAvisoInter"></div><a href=\'javascript: void(0)\' onclick=\"show_hide(\'mLAviso\')\" class=\'close\'>X</a></div>');
function mLaviso(texto, tempo){
	tempo = (tempo > 0?tempo:5);
	document.getElementById('mLAviso').style.display = "block";
	document.getElementById('mLAvisoInter').innerHTML = texto;
	
	setTimeout("document.getElementById('mLAviso').style.display = 'none'", tempo*1000); 
}


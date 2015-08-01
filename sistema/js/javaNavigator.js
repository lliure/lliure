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
	
	document.getElementById(divId).innerHTML = "<input type='text' class='edna' id='in"+divId+"'  maxlength='40' value='"+nAlt+"'/>";
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
		if(k == 46){
			portaid = document.getElementById('idPag').value;
			tabela = document.getElementById('namTable').value;
			
			deletaArquivo(portaid, tabela);
		} 
	}
}

function selectPag(divId){
	portaid = document.getElementById('idPag').value;
		
	if(empty(portaid) == false){
		document.getElementById("div"+portaid).style.borderColor = "#ffffff";
		document.getElementById("div"+portaid).style.background = "transparent";
	}
	
	document.getElementById('idPag').value = divId;
	
	document.getElementById("div"+divId).style.background = "#f9f9f9";
	document.getElementById("div"+divId).style.borderColor = "#bbbbbb";
}


function tiraSelect(portaid, tabela){
		document.getElementById("div"+portaid).style.borderColor = "#ffffff";
		document.getElementById("div"+portaid).style.background = "transparent";
			
		alteraNome(portaid, tabela);
		
		document.getElementById('idPag').value = "";
} 

function deletaArquivo(portaid, tabela){
	if(empty(portaid) == false){
		if(isset(document.getElementById("in"+portaid)) == false){
			if(confirmAlgo('esse item') == true){
				mLExectAjax('includes/jnav/delfile.php?id='+portaid+'&tabela='+tabela);
			
				document.getElementById("div"+portaid).style.display= "none";
		
				document.getElementById('idPag').value = "";
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


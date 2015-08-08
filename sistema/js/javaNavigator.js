 jQuery.fn.extend({
	jfnav: function (){		
		($(this).find('.listp .inter span')).dblclick(function(event){
			var id = $(this).attr('rel');
			editName(id, $(this).attr('title'));
			event.stopPropagation();
		});
		($(this).find('.listp')).bind({
			dblclick: function(){
				var id = $(this).attr('rel');
				location = $(this).attr('dclick');
			},
			click: function(event){
				var id = $(this).attr('rel');
				selectPag(id, $(this).attr('click'));
				event.stopPropagation();
			}
		});
		$('body').click(function(){
			if($('#idPag').val() != '')
				limpAllEvent();
		});
	}	
});


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
	var portaid = document.getElementById('idPag').value;
	
	if(empty(portaid) == false){
		limpAllEvent(portaid);
	}
	
	document.getElementById(divId).innerHTML = "<input type='text' class='edna' id='in"+divId+"'  maxlength='50' value='"+nAlt+"'/>";
	document.getElementById('idPag').value = divId;
	document.getElementById("in"+divId).focus();
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
		
/*
		if((linked == '0') || (confirmed == true)){
		*/
			if((confirmed == true) || (confirmAlgo('esse item') == true)){
				mLExectAjax('includes/jnav/delfile.php?id='+portaid+'&tabela='+tabela);
			
				document.getElementById("div"+portaid).style.display= "none";
		
				document.getElementById('idPag').value = "";
				document.getElementById('linked').value = "";
			}	

/*

		} else if(linked == ''){
		
		} else {
			if(linked != 'off'){
				if(confirmAlgo('Esse item possui ligações com outras fontes de dados, deseja continuar o processo de exclusão?') == true){
					//mLOpenBox(document.getElementById('linked').value);
				}
			} else {
				alert('Esse item possui ligações com outras fontes de dados.\n Para continuar o processo de exclusão todos as ligações pertencentes a esse item.');
			}
		}
*/
	}
}


function alteraNome(portaid, tabela){
	if(isset(document.getElementById("in"+portaid)) == true){
			
		namPag = document.getElementById("in"+portaid).value;
		if(empty(namPag) == false){
			mLExectAjax('includes/jnav/rename.php?id='+portaid+'&nome='+namPag+'&tabela='+tabela);
			
			$('#'+portaid).attr('title', namPag);
			
			if(namPag.length > 33){
				namPagLink = substr(namPag, 0, 30)+"...";
			} else {
				namPagLink = namPag;
			}
			
			document.getElementById(portaid).innerHTML = namPagLink;
		}
	}
}

function carregaConteudo(enter, div){
	$('#'+div).append(enter);
}

function alteraConteudo(enter, div){
	document.getElementById(div).innerHTML = ""+enter+"";
}

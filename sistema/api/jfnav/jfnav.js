
/**
*
* Plugin CMS
*
* @versão 4.1.8
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

$().ready( function(){
	$('body').append('<div id="jnavActions"></div>');
});
 
 jQuery.fn.extend({
	jfnav: function (){	
		nav_selecionado = null;
		
		($(this).find('.listp .inter span')).dblclick(function(event){
			editName();
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
		
		
		return this;
	}	
});

function jfnav_start(){
	$('#jfnav').load('api/jfnav/jfnav.php', {query: jfnav_objetos.query, config: jfnav_objetos.config, pasta: jfnav_objetos.pasta},
		function(){
		$('#jfnav').jfnav();
		}
	);
}

function jfnav_objetos(){
}


$('body').click(function(){
	if(nav_selecionado != null && isset(document.getElementById("in"+nav_selecionado)) == false)
		limpAllEvent();
	else if(isset(document.getElementById("in"+nav_selecionado)) == true)
		alteraNome();
});


$(document).jfkey('delete', function(tecla, opcao){
	if(nav_selecionado != null && $("#in"+nav_selecionado).length == 0){
		tabela = document.getElementById('namTable').value;
		deletaArquivo(tabela);

	} else {
		return true;
	}
});

$(document).jfkey('f2', function(){
	if(nav_selecionado != null){
		editName();
	}
});

$(document).jfkey('enter', function(){
	if(isset(document.getElementById("in"+nav_selecionado)) == true)
		alteraNome();
	else if(nav_selecionado != null)
		$('#div'+nav_selecionado).dblclick();
});

function limpAllEvent(){
	if(nav_selecionado != null){
		$('.listp').css({'background': 'transparent'});
		
		document.getElementById('idPag').value = "";
		document.getElementById('linked').value = "";
		nav_selecionado = null
	}
}

function editName(){
	var texto = $('#'+nav_selecionado).attr('title');
	
	$('.listp').css({'background': 'transparent'});
	$('#'+nav_selecionado).html('<form id="in'+nav_selecionado+'"><input type="text" class="edna" name="nome" value="'+texto+'"/></form>');
	$('#in'+nav_selecionado+' input').focus();
}

function selectPag(divId, linked){
	$('.listp').css({'background': 'transparent'});
	
	document.getElementById('idPag').value = divId;
	document.getElementById('linked').value = linked;
	
	nav_selecionado = divId;

	$('#div'+divId).css({'background': '#e7e7e7'});
}

function alteraNome(){
	namPag = $('#in'+nav_selecionado+' input').val();
	
	if(empty(namPag) == false){
		var tabela = document.getElementById('namTable').value;
		
		$('#in'+nav_selecionado).submit(function(){
			var campos =  $(this).serializeArray();
			$('#jnavActions').load('api/jfnav/rename.php?id='+nav_selecionado+'&tabela='+tabela, campos);
			
			return false;
		});
		
		
		$('#in'+nav_selecionado).submit();
		$('#'+nav_selecionado).attr('title', namPag);
		
		if(namPag.length > 33){
			namPagLink = substr(namPag, 0, 30)+"...";
		} else {
			namPagLink = namPag;
		}
		
		document.getElementById(nav_selecionado).innerHTML = namPagLink;
	}
	
	$('#div'+nav_selecionado).click();
}


function deletaArquivo(tabela, confirmed){
	if(empty(nav_selecionado) == false){
		var linked = $('#div'+nav_selecionado).attr('lig');
		/*
		if((linked == '0') || (confirmed == true)){
			if((confirmed == true) || (confirmAlgo('esse item') == true)){
				mLExectAjax('api/jfnav/delfile.php?id='+nav_selecionado+'&tabela='+tabela);
			
				$('#div'+nav_selecionado).remove();
		
				document.getElementById('idPag').value = "";
				document.getElementById('linked').value = "";
			}
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
		
		if((confirmed == true) || (confirmAlgo('esse item') == true)){
			mLExectAjax('api/jfnav/delfile.php?id='+nav_selecionado+'&tabela='+tabela);
		
			$('#div'+nav_selecionado).remove();
	
			document.getElementById('idPag').value = "";
			document.getElementById('linked').value = "";
		}
		
	}
}

function carregaConteudo(enter, div){
	$('#'+div).append(enter);
}

function alteraConteudo(enter, div){
	document.getElementById(div).innerHTML = ""+enter+"";
}

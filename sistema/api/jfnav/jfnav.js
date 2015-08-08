/**
*
* API jfnav - Plugin CMS
*
* @Versão 4.5.2
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

$().ready(function(){
	$('body').append('<div id="jnavActions"></div>');
});

nav_selecionado = null;
jQuery.fn.extend({
	jfnav: function (){			
		$(this).find('.listp .inter span').dblclick(function(event){
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
	$('#jfnav').html('<span class="load"><img src="api/jfnav/imagens/loading.gif" alt=""/></span>');

	$('#jfnav').load('api/jfnav/jfnav.php', {query: jfnav_objetos.query, config: jfnav_objetos.config, pasta: jfnav_objetos.pasta, exibicao: jfnav_objetos.exibicao},
		function(){
			$('#jfnav').jfnav();
		}
	);
}

//função necessaria para trablhar com os objetos
function jfnav_objetos(){
}


$(document).click(function(){
	if(nav_selecionado != null && $("#in"+nav_selecionado).length == 0)
		limpAllEvent();
	else if($("#in"+nav_selecionado).length != 0)
		alteraNome();
});


$(document).jfkey('delete', function(tecla, opcao){
	if(nav_selecionado != null && $("#in"+nav_selecionado).length == 0){
		deletaArquivo(jfnav_tabela);
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
		$('.listp').removeClass('jfn_selected');
		nav_selecionado = null
	}
}

function selectPag(divId){
	$('.listp').removeClass('jfn_selected');
	nav_selecionado = divId;

	$('#div'+divId).addClass('jfn_selected');
}

function editName(){
	var texto = $('#'+nav_selecionado).attr('title');

	var coluna = $('#div'+nav_selecionado).attr('coluna');
	coluna = (coluna == undefined ?  'nome' : coluna);
		
	$('#'+nav_selecionado).html('<form id="in'+nav_selecionado+'"><input type="text" class="edna" name="'+coluna+'" value="'+texto+'"/></form>');
	$('#in'+nav_selecionado+' input').select();
}

function alteraNome(){
	namPag = $('#in'+nav_selecionado+' input').val();
	
	if(empty(namPag) == false){
		$('#in'+nav_selecionado).submit(function(){
			var campos =  $(this).serializeArray();
			
			var tabela = $('#div'+nav_selecionado).attr('tabela');
			tabela = (tabela == undefined ?  jfnav_tabela : tabela);

			var id = $('#div'+nav_selecionado).attr('c_id');
			id = (id == undefined ?  nav_selecionado : 'name'+id );
			
			$('#jnavActions').load('api/jfnav/rename.php?id='+id+'&tabela='+tabela, campos);
			
			return false;
		});
				
		$('#in'+nav_selecionado).submit();
		$('#'+nav_selecionado).attr('title', namPag);
		
		if(namPag.length > 33){
			namPagLink = substr(namPag, 0, 30)+"...";
		} else {
			namPagLink = namPag;
		}
		
		$('#'+nav_selecionado).html(namPagLink);
	}
	
	$('#div'+nav_selecionado).click();
}

function jfnav_clickDelReg(selecionado){
	nav_selecionado = selecionado;
	deletaArquivo(jfnav_tabela);
}

function deletaArquivo(tabela, confirmed){
	if(empty(nav_selecionado) == false){		
		if((confirmed == true) || (confirmAlgo('este registro') == true)){
			plg_load('api/jfnav/delfile.php?id='+nav_selecionado+'&tabela='+tabela);
		
			$('#div'+nav_selecionado).remove();
		}
		
	}
}

/*
function carregaConteudo(enter, div){
	$('#'+div).append(enter);
}

function alteraConteudo(enter, div){
	document.getElementById(div).innerHTML = ""+enter+"";
}
*/

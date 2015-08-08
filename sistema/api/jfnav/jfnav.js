/**
*
* API jfnav - Plugin CMS
*
* @Versão 4.9.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

$().ready(function(){
	$('body').append('<div id="jnavActions"></div>');
});

nav_selecionado = null;
jfnav_vcc = null;
jQuery.fn.extend({
	jfnav: function (){			
		($(this).find('.listp')).bind({
			click: function(event){
				var id = $(this).attr('rel');
				
				if(jfnav_clickCount() >= 4) {
					var id = $(this).attr('rel');
					location = $(this).attr('dclick');
				} else if($("#in"+nav_selecionado).length != 0 && nav_selecionado != id){
					alteraNome();
				} else if(nav_selecionado != null && nav_selecionado == id && jfnav_clickCount() > 0 && jfnav_clickCount() < 4) {
					editName();
					return false;
				} else {
					jfnav_clickCount('novo');
				}
				
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
	if(nav_selecionado != null && $("#in"+nav_selecionado).length == 0) {
		limpAllEvent();
	} else if(nav_selecionado != null && $("#in"+nav_selecionado).length != 0) {
		alteraNome();
		limpAllEvent();
	}
});

$(document).jfkey('delete', function(tecla, opcao){
	if(nav_selecionado != null && $("#in"+nav_selecionado).length == 0){
		deletaArquivo(jfnav_tabela);
	} else {
		return true;
	}
});

$(document).jfkey('f2', function(){
	if(nav_selecionado != null)
		editName();
	else 
		return true;
});

$(document).jfkey('enter', function(){	
	if($("#in"+nav_selecionado).length == 1)
		alteraNome();
	else if(nav_selecionado != null)
		location = $('#div'+nav_selecionado).attr('dclick');
	else 
		return true;
});

$(document).jfkey('esc', function(){
	if($("#in"+nav_selecionado).length != 0)
		$("#"+nav_selecionado).html($("#"+nav_selecionado).attr('title'));
	else
		return true;
});

function limpAllEvent(){
	if(nav_selecionado != null){
		$('.listp').removeClass('jfn_selected');
		nav_selecionado = null
	}
	
	jfnav_clickCount('zera');
}

function selectPag(divId){
	$('.listp').removeClass('jfn_selected');
	nav_selecionado = divId;

	$('#div'+divId).addClass('jfn_selected');
}

function editName(){
	if($('#div'+nav_selecionado).attr('permicao') != 'false'){
		var texto = $('#'+nav_selecionado).attr('title');

		var coluna = $('#div'+nav_selecionado).attr('coluna');
		coluna = (coluna == undefined ?  'nome' : coluna);
			
		$('#'+nav_selecionado).html('<form id="in'+nav_selecionado+'"><input type="text" class="edna" name="'+coluna+'" value="'+texto+'"/></form>');
		$('#in'+nav_selecionado+' input').select();
	}
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
	
	//$('#div'+nav_selecionado).click();
}

function jfnav_clickCount(acao){
	if(acao == 'novo'){
		jfnav_vcc = 5;
		jfnav_clickCount('start');
	} else if(acao == 'start'){
		jfnav_vcc--;
		
		if(jfnav_vcc > 0)
			setTimeout(function(){
				jfnav_clickCount('start');
			}, 500);
	} else if(acao == 'zera'){
		jfnav_vcc = 0;
	} else {
		return jfnav_vcc;
	}
	
	return false;
}

function jfnav_clickDelReg(selecionado){
	nav_selecionado = selecionado;
	deletaArquivo(jfnav_tabela);
}

function deletaArquivo(tabela, confirmed){
	if($('#div'+nav_selecionado).attr('permicao') != 'false'){
		if(empty(nav_selecionado) == false){		
			if((confirmed == true) || (confirmAlgo('este registro') == true)){
				plg_load('api/jfnav/delfile.php?id='+nav_selecionado+'&tabela='+tabela);
			
				$('#div'+nav_selecionado).remove();
			}
			
		}
	}
}

<?php
/**
*
* API jfnav - Plugin CMS
*
* @vers�o 4.2.7
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

function jNavigator($query, $pluginTable, $pasta, $mensagemVazio = null, $link, $liglink = null){
	jfnav($query, $pluginTable, $pasta, $link);
}


function jfnav($query, $plgTable, $pasta, $link,  $objetos = null){
	/*
	Documenta��o da fun��o

	$query
		Exemplo de utiliza��o
		$consulta = "select * from tabela";
		$query = mysql_query($consulta);
		
	$plgTable
		Exemplo de utiliza��o
		$plgTable = 'tabela'; // B�sicamente � a tabela que est� sendo utilizada o motivo de ter que mostra-lo � que ser� utilizado pelo JS
		
	$pasta
		Exemplo de utiliza��o
		$pastas = 'sistema/pasta'; // B�sicamente � a pasta em que est� o plugin, � utilizado para selecionar icones
		
	$mensagemVazio
		Exemplo de utiliza��o
		$mensagemVazio = 'nada foi encontrado'; 	//� a mensagem exibida caso n�o seja encontrado nenhum resultado na busca		

	$link
		Exemplo de utiliza��o
		$link['campo'] = 'tipo';		// � o diferencial entre os dois tipos de itens no caso ter� � o campo que os diferencia na base de dados

		$link['t1']['link'] = "?acoes=editar&amp;id="; 	//$link['Y']['link'] onde Y � o mesmo que o anterior
		$link['t1']['ico'] = "/img/album.png";			//$link['Y']['ico'] onde Y � o mesmo que o anterior

		$link['t2']['link'] = "?gal=";					//$link['t2']['link'] = ao link que o usuario ser� direcionado em caso click	
		$link['t2']['ico'] = "/img/book.png";			//$link['t2']['ico'] = � a imagem 
	*/
	//global $jnav_registros;
	
	?>
	
	<input id="namTable" type="hidden" value="<?php echo $plgTable?>"/>
	<input type="hidden" id="idPag" value="" />
	<input type="hidden" id="linked" value="" />

	<div class="bodyhome" id="jfnav"></div>
	
	<script type="text/javascript">
		var config_objeto;
		jfnav_objetos.query = '<?php echo addslashes($query); ?>'; 		
		jfnav_objetos.pasta = '<?php echo $pasta; ?>';
		<?php
		echo 'jfnav_objetos.exibicao = \''.(isset($objetos['exibicao']) ? $objetos['exibicao'] : 'icones').'\';';
		
		$jnav_config = json_encode($link);
		echo 'jfnav_objetos.config = '.$jnav_config.';';
		?>
		
		$(function() {
			jfnav_start();
		});
	</script>
	
	<?php
}

function jNavigatorInner(){
	echo 'fun��o <strong>jNavigatorInner</stong> depreciada, por favor leia a documenta��o e nova forma de se usar essa fun��o';
}

?>

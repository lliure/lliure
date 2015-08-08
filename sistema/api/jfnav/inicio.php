<?php
/**
*
* API jfnav - Plugin CMS
*
* @versão 4.2.7
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

function jNavigator($query, $pluginTable, $pasta, $mensagemVazio = null, $link, $liglink = null){
	jfnav($query, $pluginTable, $pasta, $link);
}


function jfnav($query, $plgTable, $pasta, $link,  $objetos = null){
	/*
	Documentação da função

	$query
		Exemplo de utilização
		$consulta = "select * from tabela";
		$query = mysql_query($consulta);
		
	$plgTable
		Exemplo de utilização
		$plgTable = 'tabela'; // Básicamente é a tabela que está sendo utilizada o motivo de ter que mostra-lo é que será utilizado pelo JS
		
	$pasta
		Exemplo de utilização
		$pastas = 'sistema/pasta'; // Básicamente é a pasta em que está o plugin, é utilizado para selecionar icones
		
	$mensagemVazio
		Exemplo de utilização
		$mensagemVazio = 'nada foi encontrado'; 	//É a mensagem exibida caso não seja encontrado nenhum resultado na busca		

	$link
		Exemplo de utilização
		$link['campo'] = 'tipo';		// É o diferencial entre os dois tipos de itens no caso terá é o campo que os diferencia na base de dados

		$link['t1']['link'] = "?acoes=editar&amp;id="; 	//$link['Y']['link'] onde Y é o mesmo que o anterior
		$link['t1']['ico'] = "/img/album.png";			//$link['Y']['ico'] onde Y é o mesmo que o anterior

		$link['t2']['link'] = "?gal=";					//$link['t2']['link'] = ao link que o usuario será direcionado em caso click	
		$link['t2']['ico'] = "/img/book.png";			//$link['t2']['ico'] = é a imagem 
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
	echo 'função <strong>jNavigatorInner</stong> depreciada, por favor leia a documentação e nova forma de se usar essa função';
}

?>

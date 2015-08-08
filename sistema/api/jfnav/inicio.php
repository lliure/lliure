<?php
/**
*
* Jfnav
*
* @vers�o 2.0.0
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
function jNavigator($query, $pluginTable, $pastas, $mensagemVazio, $link, $ligs = null){
	/*
	Documenta��o da fun��o

	$query
		Exemplo de utiliza��o
		$consulta = "select * from tabela";
		$query = mysql_query($consulta);
		
	$pluginTable
		Exemplo de utiliza��o
		$pluginTable = 'tabela'; // B�sicamente � a tabela que est� sendo utilizada o motivo de ter que mostra-lo � que ser� utilizado pelo JS
		
	$Pastas
		Exemplo de utiliza��o
		$pastas = 'sistema/pasta'; // B�sicamente � a pasta em que est� o plugin, � utilizado para selecionar icones
		
		ou 
		
		$pastas['pp'] = Pasta do Plugin // igual o acima;
		$pastas['plp'] = Pasta que o plugin faz intera��o, essa caso n�o exista o sistema retorna uma mensagem dizendo que a pasta n�o existe
		
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
	
	global $jnav_registros;
	
	$pluginPasta = (is_array($pastas)?$pastas['pp']:$pastas);
	?>
	
	<input id="namTable" type="hidden" value="<?php echo $pluginTable?>"/>
	<input type="hidden" id="idPag" value="" />
	<input type="hidden" id="linked" value="" />

	<div class="bodyhome" id="jfnav">
		
	</div>
	
	<script type="text/javascript">
		var config_objeto;
		jfnav_objetos.query = '<?php echo addslashes($query); ?>'; 		
		jfnav_objetos.pasta = '<?php echo $pluginPasta; ?>'; 		
		
		<?php
		$jnav_config = json_encode($link);
		echo 'jfnav_objetos.config = '.$jnav_config.';';
		?>			

		
		$(function() {
			jfnav_start();
		});
	</script>
	
	<?php
}

function jNavigatorInner($ultimo_id, $ondblclick, $icone, $nome){
	$nomelink = (strlen($nome) > 33? substr($nome, 0, 30)."...":$nome);
	
	return '<div class="listp" id="divname'.$ultimo_id.'" rel="name'.$ultimo_id.'" lig="0" click="0" dclick="'.$ondblclick.$ultimo_id.'">'
				.'<div class="inter">'
					.'<img src="'.$icone.'" alt="'.$nome.'" />'
					.'<span id="name'.$ultimo_id.'" rel="name'.$ultimo_id.'"  title="'.$nome.'">'.$nomelink.'</span>'
				.'</div>'
			.'</div>';
}

?>
<?php
/**
*
* API jfnav - Plugin CMS
*
* @vers�o 4.4.4
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*
Documenta��o da fun��o

$query
	Exemplo de utiliza��o
	$consulta = "select * from tabela";
			
$tabela
	Exemplo de utiliza��o
	$tabela = 'tabela'; // B�sicamente � a tabela que est� sendo utilizada o motivo de ter que mostra-lo � que ser� utilizado pelo JS
	
$pasta
	Exemplo de utiliza��o
	$pastas = 'sistema/plugin/pasta'; // B�sicamente � a pasta em que est� o plugin, � utilizado para selecionar icones

$link
	Exemplo de utiliza��o
	$link['campo'] = 'tipo';		// � o diferencial entre os dois tipos de itens no caso ter� � o campo que os diferencia na base de dados

	$link['1']['link'] = "?acoes=editar&amp;id="; 	//$link['Y']['link'] onde Y � o mesmo que o anterior
	$link['1']['ico'] = "/img/album.png";			//$link['Y']['ico'] onde Y � o mesmo que o anterior

	$link['2']['link'] = "?gal=";					//$link['t2']['link'] = ao link que o usuario ser� direcionado em caso click	
	$link['2']['ico'] = "/img/book.png";			//$link['t2']['ico'] = � a imagem
	
	exemplo do config com bot�es extras, s� funciona como a exibi��o em lista
	$navegador->config = array(
				'link' => $pluginHome.'&amp;p=usuarios&amp;ac=edit&amp;id=',
				'ico' => 'sys/ico.png',
				'botoes' => array(
						array('link' => $pluginHome.'&amp;p=usuarios&amp;ac=edit&amp;id=', 'nome' => 'editar', 'ico' => $plgIcones.'pencil.png')
						)
				);
*/
	
function jNavigator($query, $pluginTable, $pasta, $mensagemVazio = null, $link, $liglink = null){
	jfnav($query, $pluginTable, $pasta, $link);
}


function jfnav($query, $tabela, $pasta, $link,  $objetos = null){
	$navegador = new jfnav();
	$navegador->tabela = $tabela;
	$navegador->query = $query;
	$navegador->pasta = (is_array($pasta)?$pasta['pp']:$pasta);
	$navegador->exibicao = isset($objetos['exibicao']) ? $objetos['exibicao'] : 'icones';
	$navegador->config = $link;
	$navegador->monta();
}

function jNavigatorInner(){
	echo 'fun��o <strong>jNavigatorInner</stong> depreciada, por favor leia a documenta��o e nova forma de se usar essa fun��o';
}

class jfnav{
	var $query;
	var $pasta;
	var $tabela;
	var $objetos;
	var $config;
	var $exibicao = 'icone';

	function monta(){
		?>
		<input id="namTable" type="hidden" value="<?php echo $this->tabela?>"/>
		<input type="hidden" id="idPag" value="" />
		<input type="hidden" id="linked" value="" />

		<div class="bodyhome" id="jfnav"></div>
		
		<script type="text/javascript">
			var config_objeto;
			jfnav_objetos.query = '<?php echo addslashes($this->query); ?>'; 		
			jfnav_objetos.pasta = '<?php echo $this->pasta; ?>';
			<?php
			echo 'jfnav_objetos.exibicao = \''.$this->exibicao.'\';';
			
			$jnav_config = json_encode($this->config);
			echo 'jfnav_objetos.config = '.$jnav_config.';';
			?>
			
			$(function() {
				jfnav_start();
			});
		</script>
		
		<?php
	}
}
?>

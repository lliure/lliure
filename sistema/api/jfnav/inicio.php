<?php
/**
*
* API jfnav - Plugin CMS
*
* @Vers�o 4.5.2
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*	***	Documenta��o da fun��o ***
	
	Para iniciar a classe
	$navegador = new jfnav();
	
	Define a tabela da consulta
	$navegador->tabela = PREFIXO.'tabela ';

	Definendo a query para consulta
	$navegador->query = 'select * from '.$navegador->tabela;

	Define a pasta onde est� o aplicativo
	$navegador->pasta = 'plugins/meuapp';

	Define como ser� a exibi��o. por ser "lista" ou "icone"
	$navegador->exibicao = 'icone';

	Define as cofigura��es da navega��o
	$navegador->config = (array) $config;

	Para rodar a classe
	$navegador->monta();

	###
	Op��o "config", essa � a mais complicada pois � nela que difinimos como vai ser o icone o clique duplo e a divercidade da busca

	Assim ficaria uma configura��o mais simples, no caso apenas vamos direcionar o duplo clique  para uma p�gina (visualizar) que tenha o id "X" (por padr�o o jfnav pesquisa o campo "id" e adiciona no final da url)
	$navegador->config = array(
				'link' => '?app=meuapp&pagina=visualizar&id='
				);

	Para alterar o icone padr�o adicione 'ico' => 'img/meuico.png' onde o endere�o come�a a contar apartir da raiz do aplicativo
	exemplo da utiliza��o
	$navegador->config = array(
				'link' => '?app=meuapp&pagina=visualizar&id=',
				'ico' => 'img/meuico.png'
				);
	

	Exemplo do config com bot�es extras, !! s� funciona como a exibi��o em lista !!
	$navegador->config = array(
				'link' => '?app=meuapp&pagina=visualizar&id=',
				'ico' => 'img/meuico.png',
				'botoes' => array(
						array('link' => '?app=meuapp&pagina=editar&id=', 'nome' => 'editar', 'ico' => 'img/pencil.png'),
						array('link' => '?app=meuapp&pagina=ativar&id=', 'nome' => 'ativar', 'ico' => 'img/check.png')
						)
				);

	exemplo de montagem do config com tabelas anexadas
	$navegador->config = array(
			'link' => '?app=meuapp&pagina=visualizar&id=',
			'ico' => 'img/meuico.png',

			'tabela' => PREFIXO.'meuapp_dados'
			'id' => 'campo_id'
			);
	

	-- Obsoleto --
	Exemplo de utiliza��o
	$link['campo'] = 'tipo';		// � o diferencial entre os dois tipos de itens no caso ter� � o campo que os diferencia na base de dados

	$link['1']['link'] = "?acoes=editar&amp;id="; 	//$link['Y']['link'] onde Y � o mesmo que o anterior
	$link['1']['ico'] = "/img/album.png";			//$link['Y']['ico'] onde Y � o mesmo que o anterior

	$link['2']['link'] = "?gal=";					//$link['t2']['link'] = ao link que o usuario ser� direcionado em caso click	
	$link['2']['ico'] = "/img/book.png";			//$link['t2']['ico'] = � a imagem
*/

//Primeio modo de aplica��o, hoje � apenas um apelido para fun��o
function jNavigator($query, $pluginTable, $pasta, $mensagemVazio = null, $link, $liglink = null){
	jfnav($query, $pluginTable, $pasta, $link);
}

//Segundo modo de aplica��o, hoje � apenas um apelido para fun��o
function jfnav($query, $tabela, $pasta, $link,  $objetos = null){
	$navegador = new jfnav();
	$navegador->tabela = $tabela;
	$navegador->query = $query;
	$navegador->pasta = (is_array($pasta)?$pasta['pp']:$pasta);
	$navegador->exibicao = isset($objetos['exibicao']) ? $objetos['exibicao'] : 'icone';
	$navegador->config = $link;
	$navegador->monta();
}

//fun��o depreciada que era utilizada na primeira forma do jfnav
function jNavigatorInner(){
	echo 'fun��o <strong>jNavigatorInner</stong> depreciada, por favor leia a documenta��o e nova forma de se usar essa fun��o';
}


class jfnav{
	var $query;
	var $pasta = '';
	var $tabela;
	var $objetos;
	var $config;
	var $exibicao = 'icone';

	function monta(){
		?>
		<?php //<input type="hidden" id="idPag" value="" /> <link rel="stylesheet" type="text/css" href="api/jfnav/estilo.css" /> ?>

		<div class="bodyhome" id="jfnav"></div>
		
		
		<script type="text/javascript" src="api/jfnav/jfnav.js"></script>
		<script type="text/javascript">
			var config_objeto;
			jfnav_tabela = '<?php echo $this->tabela?>';
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

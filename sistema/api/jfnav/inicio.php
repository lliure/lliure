<?php
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

/*	***	Documentação da função ***
	
	Para iniciar a classe
	$navegador = new jfnav();
	
	Define a tabela da consulta
	$navegador->tabela = PREFIXO.'tabela ';

	Definendo a query para consulta
	$navegador->query = 'select * from '.$navegador->tabela;

	Define a pasta onde está o aplicativo
	$navegador->pasta = 'plugins/meuapp';

	Define como será a exibição. por ser "lista" ou "icone"
	$navegador->exibicao = 'icone';

	Define as cofigurações da navegação
	$navegador->config = (array) $config;

	Para rodar a classe
	$navegador->monta();

	###
	Opção "config", essa é a mais complicada pois é nela que difinimos como vai ser o icone o clique duplo e a divercidade da busca

	Assim ficaria uma configuração mais simples, no caso apenas vamos direcionar o duplo clique  para uma página (visualizar) que tenha o id "X" (por padrão o jfnav pesquisa o campo "id" e adiciona no final da url)
	$navegador->config = array(
				'link' => '?app=meuapp&pagina=visualizar&id='
				);

	Para alterar o icone padrão adicione 'ico' => 'img/meuico.png' onde o endereço começa a contar apartir da raiz do aplicativo
	exemplo da utilização
	$navegador->config = array(
				'link' => '?app=meuapp&pagina=visualizar&id=',
				'ico' => 'img/meuico.png'
				);
	

	Exemplo do config com botões extras, !! só funciona como a exibição em lista !!
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
	Exemplo de utilização
	$link['campo'] = 'tipo';		// É o diferencial entre os dois tipos de itens no caso terá é o campo que os diferencia na base de dados

	$link['1']['link'] = "?acoes=editar&amp;id="; 	//$link['Y']['link'] onde Y é o mesmo que o anterior
	$link['1']['ico'] = "/img/album.png";			//$link['Y']['ico'] onde Y é o mesmo que o anterior

	$link['2']['link'] = "?gal=";					//$link['t2']['link'] = ao link que o usuario será direcionado em caso click	
	$link['2']['ico'] = "/img/book.png";			//$link['t2']['ico'] = é a imagem
*/

//Primeio modo de aplicação, hoje é apenas um apelido para função
function jNavigator($query, $pluginTable, $pasta, $mensagemVazio = null, $link, $liglink = null){
	jfnav($query, $pluginTable, $pasta, $link);
}

//Segundo modo de aplicação, hoje é apenas um apelido para função
function jfnav($query, $tabela, $pasta, $link,  $objetos = null){
	$navegador = new jfnav();
	$navegador->tabela = $tabela;
	$navegador->query = $query;
	$navegador->pasta = (is_array($pasta)?$pasta['pp']:$pasta);
	$navegador->exibicao = isset($objetos['exibicao']) ? $objetos['exibicao'] : 'icone';
	$navegador->config = $link;
	$navegador->monta();
}

//função depreciada que era utilizada na primeira forma do jfnav
function jNavigatorInner(){
	echo 'função <strong>jNavigatorInner</stong> depreciada, por favor leia a documentação e nova forma de se usar essa função';
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

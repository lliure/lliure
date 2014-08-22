<?php
/**
*
* API navigi - lliure
*
* @Vers�o 5.0
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@glliure.com.br> http://www.lliure.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/


/*	***	Documenta��o da fun��o ***
	
	Para iniciar a classe
	$navegador = new navigi();
	
	Define a tabela da consulta
	$navegador->tabela = PREFIXO.'tabela ';

	Definendo a query para consulta
	$navegador->query = 'select * from '.$navegador->tabela;

	Define como ser� a exibi��o. por ser "lista" ou "icone"
	$navegador->exibicao = 'icone';

	Define as cofigura��es da navega��o
	$navegador->config = (array) $config;

	Para rodar a classe
	$navegador->monta();

	###
	Op��o "config", essa � a mais complicada pois � nela que difinimos como vai ser o icone o clique duplo e a divercidade da busca...

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

	Alterando a coluna de exibi��o (por padr�o se chama nome), desta forma vamos definir que a coluna que vamos consultar ser� "cor" ao inv�s de "nome"
		$navegador->config = array(
				'link' => '?app=meuapp&pagina=visualizar&id=',
				'coluna' => 'cor'
				);

	Exemplo de montagem do config com tabelas anexadas, isso � usado para quando a coluna principal estiver em outra tabela (um exemplo � quando utilizamos multidiomas), o "as_id" nada mais � que o id da FK para quando for fazer o rename realizar na tabela correta e com o id correto
	$navegador->config = array(
			'link' => '?app=meuapp&pagina=visualizar&id=',
			'ico' => 'img/meuico.png',

			'tabela' => PREFIXO.'meuapp_dados'
			'as_id' => 'campo_id'
			);
	
	Consultando mais de um tipo de registro
	para este fim voc� tera que usar da mesma forma que a de cima porem dentro de arrays, e usar o parametro 'configSel' para definir o campo que diferencia um do outro, e os indices dos array de configura��o ser� a diferen�a

	$navegador->configSel = 'tipo';
	$navegador->config['produto'] =  array (
	 			'link' => '?app=meuapp&pagina=visualizar&id=',
				'ico' => 'img/meuico.png'
				);
	
	$navegador->config['categoria'] =  array (
				'link' => '?app=meuapp&p=categoria&id=',
				'ico' => 'img/outroico.png'
				);
	
	Para habilitar a fun��o "apagar" passe como "true" o paramentro 'delete'
	$navegador->delete = true;
	
	Para habilitar a fun��o "renomear" passe como "true" o paramentro 'rename'
	$navigi->rename = true;
	
	
	Exemplo de utiliza��o *************
	
	$navigi = new navigi();
	$navigi->tabela = PREFIXO.'app';
	$navigi->query = 'select * from '.$navigi->tabela.' order by nome asc' ;
	$navigi->delete = true;
	$navigi->rename = true;
	$navigi->config = array(
		'ico' => 'imagens/sys/app.png',
		'link' => '?app=meuapp&ac=editar&id='           
		);								
	$navigi->monta();
	
*/

class navigi{
	var $query;
	var $pasta;
	var $tabela;
	var $objetos;
	var $config;
	var $debug;
	var $exibicao = 'icone';
	var $delete = false;
	var $rename = false;
	var $configSel = false;

	function monta(){
		global $_ll;
		
		if(isset($this->config['campo'])){
			$this->configSel = $this->config['campo'];
			unset($this->config['campo']);
		}
		
		$navigi = array(
						'tabela' => $this->tabela,
						'query' => $this->query,
						'debug' => $this->debug,
						'delete' => ($this->delete ? true : false ),
						'rename' => ($this->rename ? true : false ),
						'configSel' => $this->configSel,
						'exibicao' => $this->exibicao
						);						

		if(isset($_ll['app']['pasta']))
			$this->pasta = $_ll['app']['pasta'];

		if($this->configSel === false)
			$this->config = array($this->config);
		
					
		foreach($this->config as $chave => $valor){
			$this->config[$chave]['coluna'] = (isset($this->config[$chave]['coluna']) ? $this->config[$chave]['coluna'] : 'nome');
			$this->config[$chave]['as_id'] = (isset($this->config[$chave]['as_id']) ? $this->config[$chave]['as_id'] : 'id');
			$this->config[$chave]['tabela'] = (isset($this->config[$chave]['tabela']) ? $this->config[$chave]['tabela'] : $this->tabela);
		}
		
		$navigi['config'] = $this->config;
		
		$navigi = serialize($navigi);
		
		$encriptado = jf_encode($_ll['user']['token'], $navigi);
		
		if($this->debug == true)
			echo '<pre>'.print_r($this->config ,true).'</pre>';
		
		echo '<div id="navigi" token="'.$encriptado.'"></div>';
	}
}

?>

<?php
/**
*
* lliure WAP
*
* @Versão 4.8.1
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

echo '<div class="bodyhome">';
	$navegador = new jfnav();
	$navegador->tabela = PREFIXO."desktop";
	$navegador->query = 'select * from '.$navegador->tabela.' order by nome asc';
	$navegador->config = array('s_link' 	=> 'link', 'ico' => array('i' => 'imagem') );
	$navegador->monta();
echo '</div>';
?>



<?php
/**
*
* lliure WAP
*
* @Vers�o 6.0
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

echo '<div class="bodyhome">';
	$navegador = new navigi();
	$navegador->tabela = PREFIXO."lliure_desktop";
	$navegador->query = 'select * from '.$navegador->tabela.' order by nome asc';
	$navegador->config = array('link_col' => 'link', 'ico_col' =>  'imagem');
	
	if(ll_tsecuryt('user')) {
		$navegador->rename = true;
		$navegador->delete = true;
	}
	
	$navegador->monta();
echo '</div>';
?>



<?php
/**
*
* lliure WAP
*
* @Vers�o 4.9.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

header("Content-Type: text/html; charset=ISO-8859-1",true);
$versao = str_replace('* @Vers�o ', '', '* @Vers�o 4.9.1'); //Apenas para poupar trabalho nas trocas de vers�o
?>

<div id="llSobre">
	<h1><img src="imagens/layout/logo.png" alt="lliure" /></h1>
	<span class="sigla">Web Application Platform</span>
	<span class="versao">Vers�o <?php echo $versao?></span>
	
	<h2>Obrigado por escolher o lliure</h2>	
	
	<span class="desenvolvido">Desenvolvido por Jeison Frasson</span>
	
	<div class="rodape">
		<div class="container">
			<span class="terco"><a href="http://sourceforge.net/projects/plugincms/files">Reposit�rio</a></span>
			<span class="terco"><a href="http://newsmade.grapestudio.com.br/lliure">Tutoriais</a></span>
			<span class="terco"><a href="http://www.lliure.com.br/hospedagem">Hosted by lliureHost</a></span>
		</div>
	</div>
</div>

<?php
/**
*
* Plugin CMS
*
* @vers�o 4.0.1
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*
por padrao a tabela listada pela galeria � formada se seguinte forma ['id', '$galeriaAPI['ligacaoCampo']', 'foto', 'descricao'];

$galeriaAPI['tabela'] � a tabela pai
$galeriaAPI['ligacaoCampo'] � o campo em que fica o id de referencia a tabela pai
$galeriaAPI['ligacaoId'] � o id que faz referencia a tabela pai

$galeriaAPI['capaCampo'] � o campo que est� na tabela pai que faz referencia a foto principal

$galeriaAPI['dir'] � o diret�rio onde v�o ser armazenadas as imagens
*/

?>
<style>
	@import "api/fotos/estilo.css";
</style>

<script type="text/javascript" src="api/fotos/swfobject.js"></script>
<script type="text/javascript" src="api/fotos/jquery.uploadify.js"></script>

<div class="api-fotos">

	<div class="seletor" id="file_upload"></div>

	<div id="api_fotos_galeria"></div>
	<div class="both"></div>
</div>

<script>
function carregaFotos(){
	$('#api_fotos_galeria').load('<?php echo 'api/fotos/fotos.php?tabela='.$galeriaAPI['tabela'].'&campo='.$galeriaAPI['ligacaoCampo'].'&id='.$galeriaAPI['ligacaoId'].'&dir='.$galeriaAPI['dir'].(isset($galeriaAPI['capaCampo']) ? '&capa_campo='.$galeriaAPI['capaCampo'].'&capa_foto='.$galeriaAPI['capaFoto'] :'')?>');
}

$(document).ready(function(){
	carregaFotos();		
	
	$('#file_upload').uploadify({
		'uploader'  : 'api/fotos/uploadify.swf',
		'script'    : 'api/fotos/uploadify.php?array=<?php echo $galeriaAPI['tabela']?>*<?php echo $galeriaAPI['ligacaoCampo']?>*<?php echo $galeriaAPI['ligacaoId']?>',
		'cancelImg' : 'api/fotos/cancel.png',
		'folder'    : '<?php echo $galeriaAPI['dir']?>',
		'auto'      : true,
		'fileExt'     : '*.jpg;*.png',
		'fileDesc'    : 'Arquivos de imagem (.jpg e .png)',
		'buttonText'  : 'Selecionar fotos',
		'multi'     : true,
		'onAllComplete'  : function(event,data) {
			carregaFotos();
		}
	});
});
</script>
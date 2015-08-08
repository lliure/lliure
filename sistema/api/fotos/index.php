<?php
/*
$pluginTable = 'tabela';
$PREFIXO = "aa";
$retorno = "get=valor*get2=valor2";

por padrao a tebela listada pela galeria é formada se seguinte forma ['id', '$idLig', 'foto', 'descricao'];

*/
if(isset($galeriaAPI)){
	$campoLig = $galeriaAPI['ligacaoCampo'];
	$idLig = $galeriaAPI['ligacaoId'];
	
	$campo = $galeriaAPI['capaCampo'];
	$firtPhoto = $galeriaAPI['capaFoto'];
} 

$dir = (isset($galeriaAPI['dir'])?$galeriaAPI['dir']:"../uploads/fotos");
$tabela = $galeriaAPI['tabela'];

$campoLig = (!empty($campoLig)?$campoLig:"galeria");

$campo = (isset($campo)?$campo:"capa");

$monta = "../".$dir."*".$tabela;
$idFoto = $idLig."*".$campoLig;

$caminho = "api/fotos/upload_mult.swf?id=".$idFoto."&amp;dir=".$monta."&amp;up=upload.php";
?>
<script>
function alteraFirst(arquivo){
	document.getElementById("div"+arquivo).style.background = "#FFAA00";
	
	if(!empty(document.getElementById('imgPrim').value)){
		portaid = document.getElementById('imgPrim').value;
		document.getElementById("div"+portaid).style.background = "#ffffff";
	}
	
	document.getElementById('imgPrim').value = arquivo;
}
</script>
<div class="api-fotos">
	<h2>Upload de fotos</h2>
	<div class="seletor">
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
			codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" 
			width="500">
			<param value="transparent" name="wmode"/>
			<param name="movie" value="<?php echo $caminho?>"/>
			<param name="quality" value="high" />
			<embed src="<?php echo $caminho?>" type="application/x-shockwave-flash" width="500"  wmode="transparent"></embed>
		</object>	
		<span class="ex">Envie imagens com até 900 de largura e 500 altura. <strong>Tamanhão máximo para o envio: 2Mb</strong></span>			
	</div>


	<h2>Fotos</h2>
	<input type="hidden" value="<?php echo $firtPhoto?>" id="imgPrim" />
	
	<?php
	$sql = "SELECT * FROM ".PREFIXO.$tabela."_fotos WHERE ".$campoLig."='".$idLig."'";
	
	$query = mysql_query($sql);
	if(mysql_num_rows($query) < 1){
		?>
		<span class="mensagem"><span>Nenhuma foto encontrada</span></span>
		<?php
	} else {
		while($dados = mysql_fetch_array($query)){
			$idFoto = $dados['id'];
			$idTrash = "trash".$idFoto;
			$foto = $dados['foto'];
			$file = "../../".$dir."/".$foto;
			$imgPrim = (isset($firtPhoto)? ($firtPhoto == $idFoto?"style='background: #fa0;' ":""): "");
		?>
		<div class="galdiv" <?php echo $imgPrim?> id="div<?php echo $idFoto?>">
			<div class="divblock">
				<a href="javascript: void(0)" onclick="mLExectAjax('api/fotos/deletimg.php?tabela=<?php echo $tabela?>&id=<?php echo $idFoto?>&arquivo=<?php echo $file?>');" class="trash" title="Apagar Imagem"><img src="api/fotos/delete.png" alt="apagar" /></a>
			
			<?php if(isset($firtPhoto)){ ?>
				<a href="javascript: void(0)" onclick="mLExectAjax('api/fotos/firstimg.php?tabela=<?php echo $tabela?>&amp;nomecam=<?php echo $campo?>&id=<?php echo $idLig?>&arquivo=<?php echo $idFoto?>');" class="favorite" title="Marcar como capa"><img src="api/fotos/star_fav.png" alt="Marcar capa" /></a>	
			<?php } ?>
			</div>
			
			<a href="api/fotos/refotos.php?tabela=<?php echo $tabela?>&amp;dir=<?php echo $dir?>&amp;foto=<?php echo $idFoto?>" class="renomeiaFoto" title="editar">			
				<img src="includes/thumb.php?i=../<?php echo $dir?>/<?php echo $foto?>:70:60:c" class="img" />
			</a>
		</div>
		<?php
		}
	}?>	
	<div class="both"></div>
</div>

<script>
$(document).ready(function(){
	$('.galdiv').corner('3px');
	$(".renomeiaFoto").jfbox({width: 326, height: 270}); 
	
	$('.galdiv').bind({
		mouseenter :function(){
			($(this).children('.divblock')).fadeIn(150);
		},
		
		mouseleave :function(){
			($(this).children('.divblock')).fadeOut(150);
		}
	});
});
</script>
<?php

/*
$pluginTable = 'tabela';
$prefixo = "aa";
$retorno = "get=valor*get2=valor2";

se em seu sistema tiver uma foto principal, utilize o campo 'firtPhoto' em seu bd
*/

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

	<span class="h2">Upload de fotos</span>

	<div class="label" style="text-align: center;">
					<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
						codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" 
						width="500"
						>
							<?php
							$dir = (isset($dir)?$dir:"../uploads/fotos");
							$monta = "../".$dir."*pictures";
							$idf = $prefixo.$id.'*idPag';
							
							$caminho = "includes/upload_mult.swf?id=".$idf."&amp;dir=".$monta."&amp;up=upload.php";
							?>
						<param value="transparent" name="wmode"/>
						<param name="movie" value="<?=$caminho?>"/>
						<param name="quality" value="high" />
						<embed src="<?=$caminho?>" type="application/x-shockwave-flash" width="500"  wmode="transparent"></embed>
					</object>	
					<span class="ex">Envie imagens com até 640 de largura ou altura. <strong>Tamanhão máximo para o envio: 1Mb</strong></span>			
				</div>
				
				<div class="label">
					<span class="h2">Fotos</span>
					<input type="hidden" value="<?=$firtPhoto?>" id="imgPrim" />
					
					<?php
					$sql = "SELECT * FROM ".SUFIXO."pictures WHERE idPag='".$prefixo.$id."'";
					$query = mysql_query($sql);
					if(mysql_num_rows($query) === 0){
						?>
						<span class="mensagem"><span>Nenhuma foto encontrada</span></span>
						<?php
					} else {
						while($dados = mysql_fetch_array($query)){
							$idf = $dados['id'];
							$idTrash = "trash".$idf;
							$foto = $dados['foto'];
							$file = "../".$dir."/".$foto;
							$imgPrim = (isset($firtPhoto)? ($firtPhoto == $idf?"style='background: #fa0;' ":""): "");
						?>
						<div class="galdiv" <?=$imgPrim?> id="div<?=$idf?>" onmouseover="mLvisible('<?=$idTrash?>')" onmouseout="mLHidden('<?=$idTrash?>')">
							<div  id="<?=$idTrash?>" class="divblock">
								<a href="javascript: void(0)" onclick="mLExectAjax('includes/deletimg.php?tabela=pictures&id=<?=$idf?>&arquivo=<?=$file?>');" class="trash" title="Apagar Imagem"><img src="imagens/icones/no.png" alt="apagar" /></a>
							
							<?php if(isset($firtPhoto)){ ?>
								<a href="javascript: void(0)" onclick="mLExectAjax('plugins/galeria/api/firstimg.php?tabela=<?=$pluginTable?>&id=<?=$id?>&arquivo=<?=$idf?>');" class="favorite" title="Capa do album?"><img src="imagens/icones/favorite.png" alt="apagar" /></a>	
							<?php } ?>
							</div>
							
							<a href="?plugin=galeria&amp;acoes=rfotos&amp;foto=<?=$idf?>&amp;retorno=<?=$retorno?>&amp;dir=<?=$dir?>" title="editar">			
								<img src="includes/thumbs.php?imagem=60-../<?=$dir?>/<?=$foto?>-60" />
							</a>
						</div>
						<?php
						}
					}?>	
					<span class="ex">Galeria de fotos para sua página.</span>
				</div>
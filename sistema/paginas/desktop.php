<?php
	$pluginTable = SUFIXO."desktop";
	$consulta = "select * from ".$pluginTable." order by nome asc";
	$query = mysql_query($consulta);
	
		?>
	<input id="namTable" type="hidden" value="<?=$pluginTable?>"/>
	<input type="hidden" id="idPag" value="" />
	<div class="allhome" onclick="limpAllEvent()"></div>

	<div class="bodyhome">

	<?php
	if(mysql_num_rows($query) > 0){
		while($dados = mysql_fetch_array($query)){
		extract($dados, "dd_");
		
		$pagInp = "name".$id;
	
		$ico = (isset($link['ico'])?$link['ico']:"ico.png");
		
		$nomelink = (strlen($nome) > 12? substr($nome, 0, 9)."...":$nome);
		?>
		<div class="listp" id="div<?=$pagInp?>">
			<div class="inter">

				<a href="javascript: void(0);" onclick="selectPag('<?=$pagInp?>')" ondblclick="location='?<?=$link?>'"><img src="<?=$imagem?>" alt="<?=$nome?>" /></a>
				<span id="<?=$pagInp?>"><a href="javascript: void(0);" ondblclick="editName('<?=$pagInp?>', '<?=$nome?>')" title="<?=$nome?>"><?=substr($nomelink, 0 , 12)?></a></span>
			</div>
			
		</div>
		<?php
		}
	} else { 
		echo mensagemAviso('Não foi encontrado nenhum item em sua área de trabalho');
	}
	?>
	</div>
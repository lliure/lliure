<?php
$pluginTable = SUFIXO."desktop";
$consulta = "select * from ".$pluginTable." order by nome asc";
$query = mysql_query($consulta);
?>
	
	<input id="namTable" type="hidden" value="<?php echo $pluginTable?>"/>
	<input type="hidden" id="idPag" value="" />
	<div class="allhome" onclick="limpAllEvent()"></div>
	<input type="hidden" id="linked" value="" />
	<div class="bodyhome">

	<?php
	if(mysql_num_rows($query) > 0){
		while($dados = mysql_fetch_array($query)){
		extract($dados, "dd_");
		
		$pagInp = "name".$id;
	
		$ico = (isset($link['ico'])?$link['ico']:"ico.png");
		
		$nomelink = (strlen($nome) > 12? substr($nome, 0, 9)."...":$nome);
		?>
		<div class="listp" id="div<?php echo $pagInp?>">
			<div class="inter">

				<a href="javascript: void(0);" onclick="selectPag('<?php echo $pagInp?>', '0')" ondblclick="location='<?php echo $link?>'"><img src="<?php echo $imagem?>" alt="<?php echo $nome?>" /></a>
				<span id="<?php echo $pagInp?>"><a href="javascript: void(0);" ondblclick="editName('<?php echo $pagInp?>', '<?php echo $nome?>')" title="<?php echo $nome?>"><?php echo substr($nomelink, 0 , 12)?></a></span>
			</div>
			
		</div>
		<?php
		}
	} else { 
		?>
		<img src="error.jpg" onerror="mLaviso('Não foi encontrado nenhum item em sua área de trabalho')" class="imge" alt="" /> 
		<?php
	}
	?>
	</div>
<?php
function jNavigator($query, $pluginTable, $pluginPasta, $mensagemVazio, $link){
	?>
	<input id="namTable" type="hidden" value="<?=$pluginTable?>"/>
	<input type="hidden" id="idPag" value="" />
	<div class="allhome" onclick="limpAllEvent()"></div>

	<div class="bodyhome">

	<?php
	if(isset($link['ver'])){
		$verifica = $link['ver'];
		unset($link['ver']);
	}
	
	if(mysql_num_rows($query) > 0){
		while($dados = mysql_fetch_array($query)){
		$id = $dados['id'];
		$nome = $dados['nome'];
		
		$pagInp = "name".$id;
		
		if(isset($verifica)){	
			foreach($link['condicao'] as $chave => $valor){
				$entrada = $dados[$verifica];				
				
				if(($chave == 'NULL'?empty($entrada):
									($chave == 'NOT NULL'? 
										!empty($entrada): 
											$entrada == $chave))){
					$key = $valor;
				}
			}
			
			
			$click = $link[$key]['link'].$id;
			$ico = (isset($link[$key]['ico'])?$link[$key]['ico']:"ico.png");

		} else {		
			$click = $link['link'].$id;
			$ico = (isset($link['ico'])?$link['ico']:"ico.png");
		}
		
		$nomelink = (strlen($nome) > 12? substr($nome, 0, 9)."...":$nome);
		?>
		<div class="listp" id="div<?=$pagInp?>">
			<div class="inter">

				<a href="javascript: void(0);" onclick="selectPag('<?=$pagInp?>')" ondblclick="location='<?=$click?>'"><img src="<?=$pluginPasta.$ico?>" alt="<?=$nome?>" /></a>
				<span id="<?=$pagInp?>"><a href="javascript: void(0);" ondblclick="editName('<?=$pagInp?>', '<?=$nome?>')" title="<?=$nome?>"><?=$nomelink?></a></span>
			</div>
			
		</div>
		<?php
		}
	} else { 
		echo mensagemAviso($mensagemVazio);
	}
	?>
	</div>
	
	<?php
}
?>
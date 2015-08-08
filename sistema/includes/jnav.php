<?php
function jNavigator($query, $pluginTable, $pastas, $mensagemVazio, $link, $ligs = 0){
/*
	Documenta��o da fun��o
	
	$query
		Exemplo de utiliza��o
		$consulta = "select * from tabela";
		$query = mysql_query($consulta);
		
	$pluginTable
		Exemplo de utiliza��o
		$pluginTable = 'tabela'; // B�sicamente � a tabela que est� sendo utilizada o motivo de ter que mostra-lo � que ser� utilizado pelo JS
		
	$Pastas
		Exemplo de utiliza��o
		$pastas = 'sistema/pasta'; // B�sicamente � a pasta em que est� o plugin, � utilizado para selecionar icones
		
		ou 
		
		$pastas['pp'] = Pasta do Plugin // igual o acima;
		$pastas['plp'] = Pasta que o plugin faz intera��o, essa caso n�o exista o sistema retorna uma mensagem dizendo que a pasta n�o existe
		
	$mensagemVazio
		Exemplo de utiliza��o
		$mensagemVazio = 'nada foi encontrado'; 	//� a mensagem exibida caso n�o seja encontrado nenhum resultado na busca		
	
	$link
		Exemplo de utiliza��o
		$link['ver'] = 'tipo';		// � o diferencial entre os dois tipos de itens no caso ter� � o campo que os diferencia na base de dados

		$link['condicao']['0'] = 't1';  //$link['condicao']['X'] = 't1'; onde X � o fato que diferencia na base, pode ser INT ou VAR
		$link['condicao']['1'] = 't2';	//$link['condicao']['1'] = 'Y'; onde Y � a chave que far� a diferencia��o na montagem da exibi��o 

		$link['t1']['link'] = "?acoes=editar&amp;id="; 	//$link['Y']['link'] onde Y � o mesmo que o anterior
		$link['t1']['ico'] = "/img/album.png";			//$link['Y']['ico'] onde Y � o mesmo que o anterior

		$link['t2']['link'] = "?gal=";					//$link['t2']['link'] = ao link que o usuario ser� direcionado em caso click	
		$link['t2']['ico'] = "/img/book.png";			//$link['t2']['ico'] = � a imagem 
*/

	$pluginPasta = (is_array($pastas)?$pastas['pp']:$pastas);

	?>
	<input id="namTable" type="hidden" value="<?php echo $pluginTable?>"/>
	<input type="hidden" id="idPag" value="" />
	<input type="hidden" id="linked" value="" />
	<div class="allhome" onclick="limpAllEvent()"></div>

	<div class="bodyhome" id="bodyhome">

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
				
				if(($chave == 'NULL'?empty($entrada): (
						$chave == 'NOT NULL' ? !empty($entrada): $entrada == $chave)
					)){
					$key = $valor;
				}
			}						
			
			$click = $link[$key]['link'].$id;
			$ico = (isset($link[$key]['ico'])?$link[$key]['ico']:"sys/ico.png");

			$ligCampo = $ligs['campo'][$key];
			$ligTabela = $ligs['tabela'][$key];
			$ligUrl = $ligs['ligUrl'][$key];
			$ligModId = $ligs['modId'][$key];
			
		} else {		
			$click = $link['link'].$id;
			$ico = (isset($link['ico'])?$link['ico']:"sys/ico.png");
			
			$ligCampo = $ligs['campo'];
			$ligTabela = $ligs['tabela'];
			$ligUrl = $ligs['ligUrl'];
			$ligModId = $ligs['modId'];
		}	
		
		
		if($ligs != 0){
			$ligModIdint = ($ligModId == "notnull"?" != '' and id = '".$id."'":"= '".$ligModId.$id."'");
			$consulta = mysql_query("select ".$ligCampo." from ".$ligTabela." where ".$ligCampo." ".$ligModIdint." limit 1");
			if(mysql_num_rows($consulta) > 0){
				$liglink = ($ligUrl == 'off'?'off':$ligUrl.(strpos($ligUrl, "?") != false?"&amp;":"?")."tabela=".$ligTabela."&amp;campo=".$ligCampo."&amp;modid=".$ligModId."&amp;id=".$id);
			} else {
				$liglink = '0';
			}
		} else {
			$liglink = '0';
		}
		
		$nomelink = (strlen($nome) > 12? substr($nome, 0, 9)."...":$nome);
		?>
		<div class="listp" id="div<?php echo $pagInp?>">
			<div class="inter">
				<a href="javascript: void(0);" onclick="selectPag('<?php echo $pagInp?>', '<?php echo $liglink?>')" ondblclick="location='<?php echo $click?>'"><img src="<?php echo $pluginPasta.$ico?>" alt="<?php echo $nome?>" /></a>
				<span id="<?php echo $pagInp?>" title="<?php echo $nome?>"><a href="javascript: void(0);" onclick="selectPag('<?php echo $pagInp?>', '<?php echo $liglink?>')" ondblclick="editName('<?php echo $pagInp?>', '<?php echo $nome?>')"><?php echo $nomelink?></a></span>
			</div>
			
		</div>
		<?php
		}
	} else { 
		if(is_array($pastas) and isset($pastas['plp'])) {
			if(file_exists($pastas['plp']) != true){
				if(mkdir($pastas['plp'], 0777 ) == true){
					$mensagemVazio = "O sistema criou automaticamente a pasta".$pastas['plp'];
				} else{
					$mensagemVazio = "O sistema n�o conseguiu criar a pasta".$pastas['plp'].". Crie manualmente em seu sistema para o funcionamento correto do plugin";
				}
			}
		}
	
		?>
		<img src="error.jpg" onerror="mLaviso('<?php echo $mensagemVazio?>')" class="imge" alt="" /> 
		<?php
	}
	?>
	</div>
	
	<?php
}

function jNavigatorInner($ultimo_id, $ondblclick, $icone, $nome, $nomelink){
	return "<div class=\'listp\' id=\'divname".$ultimo_id."\'><div class=\'inter\'><a href=\'javascript: void(0);\' onclick=\'selectPag(&#34;name".$ultimo_id."&#34;, &#34;0&#34;)\' ondblclick=\'location=&#34;".$ondblclick.$ultimo_id."&#34;\'><img src=\'".$icone."\' alt=\'".$nome."\' /></a><span id=\'name".$ultimo_id."\'  title=\'".$nome."\'><a href=\'javascript: void(0);\'  onclick=\'selectPag(&#34;name".$ultimo_id."&#34;, &#34;0&#34;)\' ondblclick=\'editName(&#34;name".$ultimo_id."&#34;, &#34;".$nome."&#34;)\'>".$nomelink."</span></div></div>";
}
?>
<?php
	retornaLink($historico, 'save');
	
	$idLink = $_GET['id'];
			
	$campos = array (
			'nome' => '',
			'categoria' => ''
			);
		
	$consulta = "select * from ".$pluginTable." where id = '$idLink'";
	$dados = mysql_fetch_array(mysql_query($consulta));
	
	foreach($campos as $chave => $valor){
		$$chave = $dados[$chave];
	}
	
	
	$back = $pluginHome."&amp;local=menus&id=".$categoria;
	?>
	<div class="menuSub">
		<a href="<?=$back?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span>Voltar</span></a>
		<div class="both"></div>
	</div>
	
<div class="boxCenter">
	
<?php
	if($dados['tipo'] == 'new' and !isset($_GET['tipo'])){ // SELECIONANDO O TIPO
	?>
		<span class="h2">Novo link: <?=$nome?></span>
		<?=mensagemAviso("Você está editando um novo link, siga os passos para configurar seu link")?>
		
		<div class="boxPassos">
		<span class="h3">1º passo: Selecione o tipo do link</span>
			<?php
				$dir = "plugins";
				$arquivos = opendir($dir);

				while (false !== ($filename = readdir($arquivos))) {
					if(file_exists($dir."/".$filename."/menu.txt")){
						$caminho = $dir."/".$filename;
						?>
							<div class="tMenu">
								<a href="<?=$pluginHome?>&amp;local=link&amp;id=<?=$idLink?>&amp;tipo=<?=$filename?>"><img src="<?=$caminho?>/ico.png" /> <span><?=$filename?></span></a>
							</div>
							
						<?php
					}
				}
				?>
				<div class="tMenu">
					<a href="<?=$pluginHome?>&amp;local=link&amp;id=<?=$idLink?>&amp;tipo=url"><img src="<?=$pluginPasta?>img/turl.png" /> <span>Link externo</span></a>
				</div>
				
			<div class="both"></div>
		</div>
		
		<?php
	} elseif(isset($_GET['tipo']) and $_GET['tipo'] != "url"){ // APOS TER SELECIONADO O TIPO E SE NÃO FOR URL
		?>
		<span class="h2">Novo link: <?=$nome?></span>
		<?php
		$caminho = "plugins/".$_GET['tipo']."/";
		$arquivo = $caminho."menu.txt";
		$lines = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		foreach ($lines as $line_num => $line) {
			$line = explode(':', $line);
			if(isset($line[1])){
				$valor[$line[0]] = trim($line[1]);
			} else {
				$valor[$line[0]] = '';
			}
		}		
				
		if(isset($valor['condicao'])){
			$condicao =  $valor['condicao'];

			$condicoes = explode(', ', $valor['optCondicao']);
			$link = explode(', ', $valor['link']);
			$linkEdit = explode(', ', $valor['linkEdit']);
			$imagem = explode(', ', $valor['imagem']);
			
			
			for($chave = 0;$chave < count($condicoes);$chave++){ // foreach não funfa aqui manuuu
				$valore = explode(' ', $condicoes[$chave]);
				$condicoes[$chave] = $valore['1'];
				
				$links = explode(' ', $link[$chave]);					
				$linkok[$links['0']] =  $links['1'];	
									
				$linksEdit = explode(' ', $linkEdit[$chave]);					
				$linkEditok[$linksEdit['0']] =  $linksEdit['1'];	
				
				$imagems = explode(' ', $imagem[$chave]);					
				$imagemok[$imagems['0']] =  $imagems['1'];
			}
			
			
		}

				
		$consulta = "select * from ".SUFIXO.$valor['tabela'];
		$query = mysql_query($consulta);
		
		if(isset($_GET['idlig']) or isset($_GET['novo']) or isset($valor['container'])){ // FAZ LIGAÇÃO
			if(isset($_GET['novo'])){ // CRIA NOVO
				$tabela =  SUFIXO.$valor['tabela'];
			
				$campos = explode(',', $valor['campo']);
								
				foreach($campos as $chave => $val){
					$value = explode(" ", $val);
					
					$valor1 = $value[1];			
					eval("\$valor1 = \"$valor1\";");
					
					$valores[$value[0]] = str_replace("'", "" ,$valor1);
				}
				
				$idlig = mLinsert($tabela, $valores, 1);
			}
			
			$idlig = (isset($_GET['idlig'])?$_GET['idlig']:(isset($idlig)?$idlig:''));
			
			if(isset($valor['condicao'])){
				if(!isset($_GET['novo'])){
					$condicao = $_GET['condicao'];
					$link = $linkok[$condicao];
					$linkEdit = $linkEditok[$condicao];
				} else {
					$link = $linkok['1'];
					$linkEdit = $linkEditok['1'];
				}
			} else {
				$link = $valor['link'];			
				$linkEdit = $valor['linkEdit'];			
			}
			
				eval("\$link = \"$link\";");
				eval("\$linkEdit = \"$linkEdit\";");

			$alter['id'] = $idLink;
						
			$dados = array(
				'link' => $link,
				'linkEdit' => $linkEdit,
				'tipo' => $valor['tipo'],
				);
				
			
			mLupdate($pluginTable, $dados, $alter);	
			
			echo loadPage($back, 1);
			echo mensagemAviso("Ligação para ".$valor['nome']." efetuada com sucesso");
			
		} else { // SELECIONANDO A LIGAÇÃO
			echo mensagemAviso("Cliqe no botão <strong>criar novo</strong> para criar um novo item do tipo ".$valor['nome'].".");
			?>
		
			<div class="boxPassos">
				<span class="h3">2º passo: Selecione a <?=$valor['nome']?> que deseja fazer a ligação</span>

				<?php
				if(mysql_num_rows($query) > 6){
					?>
					<span class="botao"><a href="<?=$pluginHome?>&amp;local=link&amp;id=<?=$idLink?>">Voltar</a></span>
					<span class="botao"><a href="<?=$pluginHome?>&amp;local=link&amp;id=<?=$idLink?>&amp;tipo=<?=$valor['tipo']?>&amp;novo">Criar novo</a></span>
					<div class="both"></div>
					<?php
				}
				
				while($dados = mysql_fetch_array($query)){
				$nome = $dados['nome'];
				
					if(isset($valor['condicao'])){
						$condicaoatu  = $dados[$condicao];

						if (array_key_exists($condicaoatu, $condicoes)) {
							$condicaoatu = $condicoes[$condicaoatu];

							$imagem = $imagemok[$condicaoatu];
							
							$condicaoLink = "&amp;condicao=".$condicaoatu;

							?>
							<div class="tMenu">
								<a href="<?=$pluginHome?>&amp;local=link&amp;id=<?=$idLink?>&amp;tipo=<?=$valor['tipo']?>&amp;idlig=<?=$dados['id'].$condicaoLink?>"><img src="<?=$caminho.$imagem?>" /> <span><?=$nome?></span></a>
							</div>
							<?php
						} 
					} else {
						$imagem = "ico.png";
						$condicaoLink = '';
						?>
						<div class="tMenu">
							<a href="<?=$pluginHome?>&amp;local=link&amp;id=<?=$idLink?>&amp;tipo=<?=$valor['tipo']?>&amp;idlig=<?=$dados['id'].$condicaoLink?>"><img src="<?=$caminho.$imagem?>" /> <span><?=$nome?></span></a>
						</div>
						<?php
					}
				}
				?>
				
				
				<div class="both"></div>
					<span class="botao"><a href="<?=$pluginHome?>&amp;local=link&amp;id=<?=$idLink?>">Voltar</a></span>
					<span class="botao"><a href="<?=$pluginHome?>&amp;local=link&amp;id=<?=$idLink?>&amp;tipo=<?=$valor['tipo']?>&amp;novo">Criar novo</a></span>
				<div class="both"></div>
			</div>
			<?php
		}
	} elseif(isset($_GET['tipo']) and $_GET['tipo'] == "url") { ?>
		<span class="h2">Novo link: <?=$nome?></span>
	<?php
		if(isset($_POST['url'])){
				$url = $_POST['url'];
				
				$alter['id'] = $idLink;
				
				$dados = array(
					'link' => $url,
					'tipo' => 'url',
					);
				
				mLupdate($pluginTable, $dados, $alter);		
				
				
				echo loadPage($back, 1);
				echo mensagemAviso("Ligação para ".$url." efetuada com sucesso");
		} else {
		?>
			<script type="text/javascript">
				function Save(){
					document.getElementById('form').action="<?=$pluginHome?>&local=link&id=<?=$idLink?>&tipo=url";
					document.getElementById('form').submit();
				}
			</script>
			
			<?=mensagemAviso("digite a baixo a URL desejada com <strong>HTTP://</strong>")?>
		
			<div class="boxPassos">
				<span class="h3">2º passo: Inserindo Url</span>
				<form id="form" method="post">
				<label>
					<input type="text" value="http://" name="url" />
				</label>
							
					<div class="both"></div>
						<span class="botao"><a href="<?=$pluginHome?>&amp;local=link&amp;id=<?=$idLink?>">Voltar</a></span>
						<span class="botao"><a href="javascript: void(0)" onclick="Save()">Concluir</a></span>
					<div class="both"></div>
				</form>
			</div>
			<?php
		}
	} else {
		if(!empty($dados['linkEdit'])){
		$a = array_pop($_SESSION['historicoNav']);
		?>
		<span class="h2">Editar link: <?=$nome?></span>
		<?=mensagemAviso("Você está sendo transferido para página correspondente ao link")?>
		<?=loadPage($dados['linkEdit'], 1)?>

	<?php	
		} else { ?>
		<?=mensagemAviso("Esse é um link externo, é apenas um direcionamento para outra página é não pode ser editado por esse painel.")?>
		<?=loadPage($back, 1)?>
		<?php
		}
	}

?>
</div>
<?php
$case = (isset($_GET['case'])?$_GET['case']: "");
		
$campos = array (
			'nome' => '',
			'imagem' => '',
			'link' => '',
			'titulo' => ''
			);

switch($case){
case "save";
case "saveedit":
	$id = $_GET['id'];
	$tBanner = $_GET['tban'];
	retornaLink($historico, 'save');
	if(!empty($_POST)){	
		if(!empty($_FILES['arquivo']['name'])){
				$arquivo = $_FILES['arquivo'];
				
			if(empty($_POST['imagem'])){
				$imagemNome = substr($arquivo ['name'], -3); // pega a extenção
				$imagemNome = md5(uniqid(time())).'.'.$imagemNome;	
			} else {
				$imagemNome = $_POST['imagem'];
			}
						
			$dir = 	"../uploads/banners/";	
			$path =  $dir.$imagemNome;
			
			if(file_exists($dir) == false){
				mkdir($dir, "0777");
			}
			
			move_uploaded_file($arquivo["tmp_name"], $path);

			$img_origem = ImageCreateFromJPEG($path);
			$origem_x = ImagesX($img_origem);
			$origem_y = ImagesY($img_origem);
					
			$hei =  explode('x', $banners[$tBanner]);
			$wid = $hei['0'];
			$hei = $hei['1'];
			
			if(($origem_x > $wid) or ($origem_y > $hei)){
				unlink($path);
				$imagemNome = '';
				echo mensagemAviso("Seu banner está com um tamanho incorreto!<br/>Envie um arquivo com {$wid}px de largura por {$hei}px de altura");
			}
		}


		foreach($_POST as $chave => $valor){
			$campos[$chave] = $valor;
		}		

		(isset($imagemNome)?$campos['imagem'] = $imagemNome:'');
		
		$alter['id'] = $id;
		
		mLupdate($pluginTable, $campos, $alter);
		echo mensagemAviso("Alteração realizada com sucesso!");
	}
if($case == 'save'){
	echo loadPage($backReal, 1);
	break;
}

default:
	if(!isset($_GET['id'])){
		$tBanner = $_GET['tban'];
		$dados = array(
				'nome' => 'Novo banner',
				'tipo' => $tBanner,
				);
		$id = mLinsert($pluginTable, $dados, 1);
	} else{
		$id = $_GET['id'];
	}
	
	$consulta = "select * from ".$pluginTable." where id like $id";
	$query = mysql_query($consulta);
	$dados = mysql_fetch_array($query);
	?>
	<span class="h2">Banner <?=$banners[$dados['tipo']]?></span>
	<?php
		foreach($campos as $chave => $valor){
			$$chave = $dados[$chave];
		}
		$link = (!empty($link)?$link:'http://');
		$tBanner = $dados['tipo'];
		?>
		<div class="boxCenter">
			<form method="post" class="form" id="formula" enctype="multipart/form-data">
				<div class="label">
					<span>Nome</span>
					<div class="input"><input type="text" value="<?=$nome?>" name="nome" /></div>
					<span class="ex">Nome do seu banner. <strong>Campo obrigatório</strong></span>
				</div>					
				
				<div class="label">
					<span>Titulo</span>
					<div class="input"><input type="text" value="<?=$titulo?>" name="titulo" /></div>
					<span class="ex">Titulo para exibição no site. <strong>Campo opcional</strong></span>
				</div>						
				
				<div class="label">
					<span>Link</span>
					<div class="input"><input type="text" value="<?=$link?>" name="link" /></div>
					<span class="ex">Link do banner. <strong>Campo obrigatório</strong></span>
				</div>						
				
				<div class="label">
					<span>Imagem</span>
					<?php
					if(!empty($imagem)){
						?>
						<input type="hidden" name="imagem" value="<?=$imagem?>" />
						
						<div class="galdiv">
							<img src="includes/thumbs.php?imagem=150-../../uploads/banners/<?=$imagem?>-60" />
						</div>
						<?php
					}
					?>
					
					<input type="file" name="arquivo" />
					<span class="ex">Para trocar sua imagem apenas selecione uma nova. <strong>Campo opcional</strong></span>
				</div>			
				
				<div class="subBar">
					<?php
						$endComun = $pluginHome."&acoes=editar&id=".$id."&tban=".$tBanner;
					?>
					<a class="link" href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/></a>
					
					<button  class="link" onclick="sForm('formula', '<?=$endComun?>&case=save')"><img src="imagens/icones/save.png" alt="salvar"/></button>
					
					<button  class="link" onclick="sForm('formula', '<?=$endComun?>&case=saveedit')">
						<img src="imagens/icones/save_edit.png" alt="salvar e continuar editando"/>
					</button>
				</div>
			</form>
		</div>
	<?php
break;
}
?>
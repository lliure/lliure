<?php
$id = $_GET['id'];

$case = (isset($_GET['case'])?$_GET['case']: "");
		
$campos = array (
			'nome' => '',
			'descricao' => ''
			);

switch($case){
case "save";
case "saveedit":
	retornaLink($historico, 'save');
	if(!empty($_POST)){
		foreach($_POST as $chave => $valor){
			$campos[$chave] = $valor;
		}
			
		$alter['id']	= $id;
		
		mLupdate($pluginTable, $campos, $alter);
		echo mensagemAviso("Alteração realizada com sucesso.");
	}
if($case == 'save'){
	echo loadPage($backReal, 1);
	break;
}

default:
	$consulta = "select * from ".$pluginTable." where id like $id";
	$query = mysql_query($consulta);
	$dados = mysql_fetch_array($query);
		

	foreach($campos as $chave => $valor){
		$$chave = $dados[$chave];
	}

	?>

<div class="boxCenter">
	<form method="post" class="form" id="formula">
		<div class="label">
			<span>Nome</span>
			<div class="input"><input type="text" value="<?=$nome?>" name="nome" /></div>
			<span class="ex">Nome do vídeo. <strong>Campo obrigatorio</strong></span>
		</div>
		
		<div class="label">
			<span>Descrição</span>
			<textarea  name="descricao" class="normal"><?=$descricao?></textarea>
			<span class="ex">Descrição do video. <strong>Campo opcional</strong></span>
		</div>
		
		
		<div class="subBar">
			<?php
				$endComun = $pluginHome."&acoes=edit&id=".$id;
			?>
			<a class="link" href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/></a>
			
			<button  class="link" onclick="sForm('formula', '<?=$endComun?>&case=save')"><img src="imagens/icones/save.png" alt="salvar"/></button>
			
			<button  class="link" onclick="sForm('formula', '<?=$endComun?>&case=saveedit')">
				<img src="imagens/icones/save_edit.png" alt="salvar e continuar editando"/>
			</button>
		</div>
		
		<div class="both"></div>
	</form>
</div>
	<?php
break;
}
?>
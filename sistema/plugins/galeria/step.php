<?php
$id = $_GET['id'];
$case = (isset($_GET['case'])?$_GET['case']: "");
		
$campos = array (
			'nome' => ''
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
		echo mensagemAviso("Altera��o realizada com sucesso!");
	}
if($case == 'save'){
	echo loadPage($backReal, 1);
	break;
}

default:
	$consulta = "select * from ".$pluginTable." where id like $id";
	$query = mysql_query($consulta);
	if(mysql_num_rows($query) > 0){
		$dados = mysql_fetch_array($query);

		foreach($campos as $chave => $valor){
			$$chave = $dados[$chave];
		}		
				
		$back = (!is_null($dados['galeria'])? "&gal=".$dados['galeria'] : '');
		?>
		<div class="boxCenter">
			<form method="post" class="form" id="formula">
				<div class="label">
					<span>Nome</span>
					<div class="input"><input type="text" maxlength="15" value="<?=$nome?>" name="nome" /></div>
					<span class="ex">Este � apenas para identifica��o no painel, m�ximo de 15 caracteres. <strong>Campo obrigatorio</strong></span>
				</div>
				
			<?php
				$firtPhoto = (!empty($dados['firtPhoto'])?$dados['firtPhoto']:"");
				
				$prefixo = "gl";
				$retorno = "plugin=galeria*acoes=editar*id=".$id;
				require_once('plugins/galeria/api/index.php');
			?>
				
				<div class="subBar">
					<?php
						$endComun = $pluginHome."&acoes=editar&id=".$id;
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
	} else {
		echo mensagemAviso("A galeria que est� tentando visualizar n�o existe mais, agora voc� pode cria-lo ou retornar a p�gina principal");
		?>
		<span class="botao"><a href="<?=$pluginHome?>&amp;acoes=nova&amp;id=<?=$_GET['id']?>">Criar galeria</a></span>
		<span class="botao"><a href="<?=$backReal?>">Voltar a p�gina anterior</a></span>
		<?php
	}
break;
}
?>
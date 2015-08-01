<?php
$id = $_GET['id'];
$case = (isset($_GET['case'])?$_GET['case']: "");
$tabela = SUFIXO."catalogo_categorias";
		
$campos = array (
			'nome' => '',
			'idLig' => ''
			);

switch($case){
	case "save";
	case "saveedit":
		retornaLink($historico, 'save');
		foreach($_POST as $chave => $valor){
			$campos[$chave] = $valor;
		}
			
		$alter['id']	= $id;
		
		mLupdate($tabela, $campos, $alter);
		echo mensagemAviso("Alteração realizada com sucesso.");
		if($case == 'save'){
			echo loadPage($backReal, 1);
			break;
		}
	
	default:
		$consulta = "select * from ".$tabela." where id like $id";
		$query = mysql_query($consulta);
		$dados = mysql_fetch_array($query);
		foreach($campos as $chave => $valor){
			$$chave = $dados[$chave];
		}
		$id = $dados['id'];
	?>


	<script type="text/javascript">
		function SaveEdit(){
			document.getElementById('form').action="<?=$pluginHome?>&acoes=categorias&id=<?=$id?>&case=saveedit&editar";
			document.getElementById('form').submit();
		}
		
		function Save(){
			document.getElementById('form').action="<?=$pluginHome?>&acoes=categorias&id=<?=$id?>&case=save&editar";
			document.getElementById('form').submit();
		}
	
	</script>
	
<div class="boxCenter">
	<form method="post" class="form" id="form">
		<div class="label">
			<span>Nome</span>
			<div class="input"><input type="text" maxlength="15" value="<?=$nome?>" name="nome" /></div>
			<span class="ex">Este é apenas para identificação no painel, máximo de 15 caracteres. <strong>Campo obrigatorio</strong></span>
		</div>
		
		<div class="label">
			<span>Ligação</span>
			
			<span class="ex">Ligação com alguma categoria, não selecione nenhuma caso não queira ligar a nenhuma. <strong>Campo obrigatorio</strong></span>
		</div>

		
		<a href="javascript: void(0)" onclick="SaveEdit()" title="salvar e continuar editando" class="a"><img src="imagens/icones/save_edit.png" alt="salvar e continuar editando"/></a>
		
		<a href="javascript: void(0)" onclick="Save()" title="salvar" class="a"><img src="imagens/icones/save.png" alt="salvar"	/></a>
		<a href="<?=$pluginHome?>" title="voltar" class="a"><img src="imagens/icones/back.png" alt="voltar"	/></a>

		<div class="both"></div>

	</form>
</div>
	<?php
break;
}
?>
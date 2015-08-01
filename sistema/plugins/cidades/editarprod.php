<?php
$case = (isset($_GET['case']) && isset($_POST['nome'])?$_GET['case']: "");
$pluginTable = SUFIXO."bairros";
$campos = array (
			'nome' 		=> '',
			'idCidade' => ''
			);

switch($case){
case "save";
case "saveedit":
	
	retornaLink($historico, 'save');
	$id = $_GET['id'];
	
	if (isset($_POST['valor'])) {
		$_POST['valor'] = str_replace(',','.',str_replace('.','',$_POST['valor']));
		if ($_POST['valor'] == '') {
			$_POST['valor'] = '0';
		}
	}
	foreach($_POST as $chave => $valor){
		if (!is_array($valor)) {
			$campos[$chave] = $_POST[$chave];
		}
	}		
	
	$alter['id'] = $id;
	
	mLupdate($pluginTable, $campos, $alter);
	
	echo mensagemAviso("Alteração realizada com sucesso!");
	?>
	<?php
if($case == 'save'){
	echo loadPage($backReal, 1);
	break;
}


default:
	if(!isset($_GET['id'])){
		$dados = array(
				'nome' => 'Novo bairro'
				);
		$id = mLinsert($pluginTable, $dados, 1);
		
	} else{
		$id = $_GET['id'];
	}
	
	$consulta = "select * from ".$pluginTable." where id like $id";
	$query = mysql_query($consulta);
	$dados = mysql_fetch_array($query);
		
		foreach($campos as $chave => $valor){
			if (!is_array($valor)) {
				$$chave = $dados[$chave];
			}
		}
		
		?>
	<script type="text/javascript">
		function SaveEdit(){
			document.getElementById('form').action="<?=$pluginHome?>&acoes=produtos&id=<?=$id?>&case=saveedit&editar";
			document.getElementById('form').submit();
		}
		
		function Save(){
			document.getElementById('form').action="<?=$pluginHome?>&acoes=produtos&id=<?=$id?>&case=save&editar";
			document.getElementById('form').submit();
		}
		tinyMCE.init({
			// General options
			mode : "textareas",
			theme : "advanced",
			editor_selector : "editor",
			
			plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,ibrowser",

			// Theme options
			theme_advanced_buttons1 : "code,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,|,preview,|,forecolor,backcolor,ibrowser",
			
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,|,ltr,rtl,|,fullscreen",
			
			//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			//theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	</script>
<div class="menuSub">
	<a href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span>Voltar</span></a>
	

	<a href="<?=$pluginHome?>&amp;acoes=novoprod"><img src="<?=$pluginPasta?>img/newprod.png" alt="Novo produto"/><span>Novo produto</span></a>
	
	<div class="both"></div>
</div>
		<div class="boxCenter">
			<form method="post" class="form" id="form" enctype="multipart/form-data">

				
				<div class="label">
					<span>Nome</span>
					<div class="input"><input type="text" value="<?=$nome?>" name="nome" /></div>
					<span class="ex">Nome do bairro. <strong>Campo obrigatório</strong></span>
				</div>
				<div class="label">
					<span>Cidade</span>
					<div class="input">
						<select name="idCidade" style="width:100%">
								<?php
								$sql = "SELECT * FROM ".SUFIXO."cidades order by nome";
								$qry = mysql_query($sql);
								while ($dados = mysql_fetch_array($qry)) {
									?>
									<option value="<?=$dados['id']?>"><?=$dados['nome']?></option>
									<?php
								}
								?>
						</select>
					</div>
					<span class="ex">Cidade do bairro</span>
				</div>
				
				<a href="javascript: void(0)" onclick="SaveEdit()" title="salvar e continuar editando" class="a"><img src="imagens/icones/save_edit.png" alt="salvar e continuar editando"/></a>
				
				<a href="javascript: void(0)" onclick="Save()" title="salvar" class="a"><img src="imagens/icones/save.png" alt="salvar"	/></a>
				
				<a href="<?=$backReal?>" title="voltar" class="a"><img src="imagens/icones/back.png" alt="voltar"	/></a>

			</form>
		</div>
	<?php
break;
}
?>
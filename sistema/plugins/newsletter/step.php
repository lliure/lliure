<?php
$id = $_GET['id'];
$case = (isset($_GET['case'])?$_GET['case']: "");
$tabela = SUFIXO."paginas";
		
$campos = array (
			'nome' => '',
			'conteudo' => '',
			'titulo' => ''
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
		
		mLupdate($tabela, $campos, $alter);
		echo mensagemAviso("Alteração realizada com sucesso.");
	}
if($case == 'save'){
	echo loadPage($backReal, 1);
	break;
}

default:
	$consulta = "select * from ".SUFIXO."paginas where id like $id";
	$query = mysql_query($consulta);
	$dados = mysql_fetch_array($query);
		

	foreach($campos as $chave => $valor){
		$$chave = $dados[$chave];
	}
	
	$id = $dados['id'];
	?>


	<script type="text/javascript">
		tinyMCE.init({
			// General options
			mode : "textareas",
			theme : "advanced",
			
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
<div class="boxCenter">
	<form method="post" class="form" id="formula">
		<div class="label">
			<span>Nome</span>
			<div class="input"><input type="text" maxlength="15" value="<?=$nome?>" name="nome" /></div>
			<span class="ex">Este é apenas para identificação no painel, máximo de 15 caracteres. <strong>Campo obrigatorio</strong></span>
		</div>

		<div class="label">
			<span>Titulo</span>
			<div class="input"><input name="titulo" type="text" value="<?=$titulo?>"/></div>
			<span class="ex">Caso não queira mostra o titulo no site deixe em branco. <strong>Campo opcional</strong></span>
		</div>
		
		<div class="label">
			<span>Conteúdo</span>
			<textarea class="editor"  name="conteudo"><?=$conteudo?></textarea>
			<span class="ex">Aqui é o conteudo da sua página. <strong>Campo obrigatorio</strong></span>
		</div>
		
		
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
		<div class="both"></div>
		<?php
			$prefixo = "pa";
			$retorno = "plugin=pagina*acoes=editar*id=".$id;
			$dir = "";
			require_once('plugins/galeria/api/index.php');
		?>
	</form>
</div>
	<?php
break;
}
?>
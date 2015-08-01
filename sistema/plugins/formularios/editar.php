<?php
$id = $_GET['id'];
$case = (isset($_GET['case'])?$_GET['case']: "");
$tabela = SUFIXO."formularios";
		
$campos = array (
			'nome' => '',
			'conteudo' => '',
			'titulo' => '',
			'email' => 	'',
			'embed' => 	''
			);

switch($case){
	case "save";
	case "saveedit":
		retornaLink($historico, 'save');
		foreach($_POST as $chave => $valor){
			if (!is_array($valor)) {
				$campos[$chave] = $valor;
			}
		}
		$alter['id']	= $id;
		
		mLupdate($tabela, $campos, $alter);
		
		if (isset($_POST['camposf']) && is_array($_POST['camposf'])) {
			$del = "DELETE FROM ".SUFIXO."formularios_campos where id_form = '".$id."'";
			mysql_query($del);
			$max = count($_POST['camposf']['identificacao']);
			for ($x = 0;$x<=$max;$x++) {
				if (isset($_POST['camposf']['identificacao'][$x]) && $_POST['camposf']['identificacao'][$x] != '') {
					$sql = "INSERT INTO ".SUFIXO."formularios_campos (id_form,identificacao,titulo,valor,tipo,ordem,obrigatorio)
									VALUES (
										'".$id."',
										'".$_POST['camposf']['identificacao'][$x]."',
										'".$_POST['camposf']['titulo'][$x]."',
										'".$_POST['camposf']['valor'][$x]."',
										'".$_POST['camposf']['tipo'][$x]."',
										'".($_POST['camposf']['ordem'][$x]!=''?$_POST['camposf']['ordem'][$x]:'1')."',
										'".(isset($_POST['camposf']['obrigatorio'][$x]) && $_POST['camposf']['obrigatorio'][$x] != ''?$_POST['camposf']['obrigatorio'][$x]:'0')."'
										
									)
					";
					mysql_query($sql);
				}
			}
		}
		
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
			$$chave = (isset($dados[$chave])?$dados[$chave]:'');
		}
		$id = $dados['id'];
	?>


	<script type="text/javascript">
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

<div class="boxCenter">
	<form method="post" class="form" id="formula">
		<div class="label">
			<span>Nome</span>
			<div class="input"><input type="text" maxlength="15" value="<?=$nome?>" name="nome" /></div>
			<span class="ex">Este é apenas para identificação no painel, máximo de 15 caracteres. <strong>Campo obrigatório</strong></span>
		</div>
		<div class="label">
			<span>E-mail</span>
			<div class="input"><input name="email" type="text" value="<?=$email?>"/></div>
			<span class="ex">Esse será o e-mail para qual será enviado o formulário. <strong>Campo obrigatório</strong></span>
		</div>
		<div class="label">
			<span>Titulo</span>
			<div class="input"><input name="titulo" type="text" value="<?=$titulo?>"/></div>
			<span class="ex">Caso não queira mostra o titulo no site deixe em branco. <strong>Campo opcional</strong></span>
		</div>
		
		<div class="label">
			<span>Conteúdo</span>
			<textarea class="editor"  id="editor" name="conteudo"><?=$conteudo?></textarea>
			<span class="ex">Aqui é o conteudo da sua página. <strong>Campo obrigatorio</strong></span>
		</div>
	
		<div class="label">
			<span>Embed</span>
			<textarea class="textBorder" name="embed" style="border:1px solid #CCC"><?=$embed?></textarea>
			<span class="ex">Aqui é o embed de seu mapa ou outro script. <strong>Campo opcional</strong></span>
		</div>
		<div class="label">
			<span>Campos</span>
			<br />
			<?php
				$sql = "SELECT * FROM ".SUFIXO."formularios_campos where id_form = '".$id."' order by ordem";
				$qry = mysql_query($sql);
				while ($dados = mysql_fetch_array($qry)) {
					?>
					<div class="label" id="campos_<?=$dados['id']?>" style="border-bottom:1px solid #CCC; padding-bottom:5px;">
						

						<label>

						<input type="checkbox" name="camposf[obrigatorio][]" value="1" style="width:20px;" <?=($dados['obrigatorio']=='1'?'checked':'')?> />
							Obrigatório.
						</label>
						
						<a href="javascript:void(0)" style="float:right"  onclick="mLExectAjax('plugins/formularios/deletacampo.php?id=<?=$dados['id']?>');">
							<img src="imagens/icones/no.png" alt="Excluir" />
						</a>
						<br />
						Titulo: 
						<input type="text" name="camposf[titulo][]" style="width:80px;" value="<?=$dados['titulo']?>" /> 
						
						Identificação: 
						<input type="text" id="campos_identificacao_<?=$dados['id']?>" name="camposf[identificacao][]" style="width:60px;" value="<?=$dados['identificacao']?>" /> 

						Valor: 
						<input type="text" name="camposf[valor][]" style="width:80px;" value="<?=$dados['valor']?>" /> 
						
						Tipo 
						<select name="camposf[tipo][]" style="width:80px;">
							<option value="text" <?=($dados['tipo']=='text'?'selected':'')?>>Text</option>
							<option value="textarea" <?=($dados['tipo']=='textarea'?'selected':'')?>>Textarea</option>
							<!-- Wait, for now..
							<option value="select" <?=($dados['tipo']=='select'?'selected':'')?>>Select</option>
							<option value="radio" <?=($dados['tipo']=='radio'?'selected':'')?>>Radio</option>
							-->
							<option value="checkbox" <?=($dados['tipo']=='checkbox'?'selected':'')?>>Checkbox</option>
						</select>
						
						Ordem 
						<input type="text" name="camposf[ordem][]" style="width:30px; text-align:center;" value="<?=$dados['ordem']?>" /> 

					</div>
	
					<?
				}
				 // Gambi? A acho que não ? Será? Ou será só imaginação? Será? Gambi!!! sai capeta!
				 $max = 25; 
				 for($x = 1;$x<=$max;$x++) { ?>
					<div class="label" id="campos_A<?=$x?>" style="display:none; border-bottom:1px solid #CCC; padding-bottom:5px;">
						<label>
							<input type="checkbox" name="camposf[obrigatorio][]" value="1" style="width:20px;" />
								Obrigatório.
						</label>
						
						<a href="javascript:void(0)" style="float:right"  onclick="mLExectAjax('plugins/formularios/deletacampo.php?id=A<?=$x?>');">
							<img src="imagens/icones/no.png" alt="Excluir" />
						</a>
						<br />
						
						Titulo: 
						<input type="text" name="camposf[titulo][]" style="width:80px;" /> 
						
						Identificação: 
						<input type="text" id="campos_identificacao_A<?=$x?>" name="camposf[identificacao][]" style="width:60px;" /> 
						
						Valor: 
						<input type="text" name="camposf[valor][]" style="width:80px;"  /> 
						
						Tipo 
						<select name="camposf[tipo][]" style="width:80px;">
							<option value="text">Text</option>
							<option value="textarea">Textarea</option>
							<!-- Just some day i will do that, but not now..
				 					hum.. i wanna pie! 
								<option value="select" >Select</option>
								<option value="radio">Radio</option>
							-->
							<option value="checkbox">Checkbox</option>
							
						</select>
						
						Ordem 
						<input type="text" name="camposf[ordem][]" style="width:30px; text-align:center;" /> 
					</div>
				<? } ?>
			<a href="javascript:void(0)" onclick="javascript:mais_campos('campos_','<?=$max?>');"><img src="imagens/icones/more.png" alt="Mais campos" style="float:left" /> <span style="padding:3px 0 10px 25px">Mais campos</span></a>
			<span class="ex">Aqui serão os campos que seu formulário terá.</span>
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

	</form>
</div>
	<?php
break;
}
?>
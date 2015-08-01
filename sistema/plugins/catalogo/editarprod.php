<?php
function MostraTudo($idLig,$idsCat,$pos=20) {
	
	$sql = "SELECT id,nome FROM ".SUFIXO."catalogo_categorias where idLig = '".$idLig."'";
	$qry = mysql_query($sql);
	?>
	<div id="categorias_<?=$idLig?>" style="display:<?=(isset($idsCat) && is_array($idsCat) && in_array($idLig,$idsCat)?'block':'none')?>;">
	<?
	while ($dados = mysql_fetch_array($qry)) {
		?>
		<span style="padding-left:<?=$pos?>px">
			<label>
				<input type="checkbox" value="<?=$dados['id']?>" name="categorias[]" <?=(isset($idsCat) && is_array($idsCat) && in_array($dados['id'],$idsCat)?'checked':'')?> onclick="javascript:show_hide('categorias_<?=$dados['id']?>');" style="width:20px" /> <?=$dados['nome']?>
			</label>
		</span>
		<?
		MostraTudo($dados['id'],$idsCat,$pos+20);	
	}
	?>
	</div>
	<?
}

$case = (isset($_GET['case']) && isset($_POST['nome'])?$_GET['case']: "");
$pluginTable = SUFIXO."catalogo";
$campos = array (
			'nome' 		=> '',
			'descricao' => '',
			'destaque'  => '',
			'ativo'		=> '',
			'valor'		=> '',
			'tipo'		=> '',
			'nomeVendedor'		=> '',
			'emailVendedor'		=> '',
			'telefoneVendedor'	=> '',
			'enderecoImovel'	=> '',
			'cidade'	=> '',
			'bairro'	=> '',
			'dormitorios'	=> ''
			);

switch($case){
case "save";
case "saveedit":
	retornaLink($historico, 'save');
	$id = $_GET['id'];
	if (!isset($_POST['destaque'])) {
		$_POST['destaque'] = '0';
	}
	if (!isset($_POST['ativo'])) {
		$_POST['ativo'] = '0';
	}

	foreach($_POST as $chave => $valor2){
		if (!is_array($valor2)) {
			$campos[$chave] = $_POST[$chave];
		}
	}		
	
	$alter['id'] = $id;
	
	mLupdate($pluginTable, $campos, $alter);
	
	if (isset($_POST['categorias']) && is_array($_POST['categorias'])) {
		$del = "DELETE FROM ".SUFIXO."catalogo_relacao where idProd = '".$id."'";
		mysql_query($del);
		$val = '';
		$c = 1;
		foreach ($_POST['categorias'] as $k => $v) {
			 $val .= ($c!=1?',':'')."('".$v."','".$id."')";	
			 $c++;
			
		}
		if ($val != '') {
			$sql = "INSERT INTO ".SUFIXO."catalogo_relacao (idCat,idProd) VALUES ".$val; 
			mysql_query($sql);
		}

	}
	
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
				'nome' => 'Novo Imóvel'
				);
		$id = mLinsert($pluginTable, $dados, 1);
	} else{
		$id = $_GET['id'];
	}
	
	$consulta = "select * from ".$pluginTable." where id like $id";
	$query = mysql_query($consulta);
	$dados = mysql_fetch_array($query);
		
		foreach($campos as $chave => $valor2){
			if (!is_array($valor2)) {
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
	

	<a href="<?=$pluginHome?>&amp;acoes=novoprod"><img src="<?=$pluginPasta?>img/newprod.png" alt="Novo Imóvel"/><span>Novo Imóvel</span></a>
	
	<div class="both"></div>
</div>
		<div class="boxCenter">
			<form method="post" class="form" id="form" enctype="multipart/form-data">
				<div class="label">
					<span>Tipo</span>
					<div class="input">
					<select name="tipo" style="width:100%;">
						<option value="l" <?=($tipo=='l'?'selected':'')?>>Locação</option>
						<option value="v" <?=($tipo=='v'?'selected':'')?>>Vendas</option>
					</select></div>
					<span class="ex">Tipo do imóvel. <strong>Campo obrigatório</strong></span>
				</div>
				
				
				<div class="label">
					<span>Cidade</span>
					<div class="input">
					<select name="cidade" style="width:100%;" onchange="javascript:goPag('bairros.php?c='+this.value,'bairro');">
							<?php
							$sql = "SELECT * FROM ".SUFIXO."cidades order by nome";
							$qry = mysql_query($sql);
							while ($dados = mysql_fetch_array($qry)) {
								(!isset($idCity)?$idCity=$dados['id']:(isset($cidade)?$idCity=$cidade:''));
								?>
								<option value="<?=$dados['id']?>" <?=($idCity==$dados['id']?'selected':'')?>><?=$dados['nome']?></option>
								<?php
							}
							?>
					</select></div>
					<span class="ex">Cidade do imóvel. <strong>Campo obrigatório</strong></span>
				</div>
				
				<div class="label" id="bairro">
					<span>Bairro</span>
					<div class="input">
					<select name="bairro" style="width:100%;">
							<?php
							$sql = "SELECT * FROM ".SUFIXO."bairros where idCidade = '".$idCity."' order by nome";
							$qry = mysql_query($sql);
							while ($dados = mysql_fetch_array($qry)) {
								?>
								<option value="<?=$dados['id']?>" <?=($bairro==$dados['id']?'selected':'')?>><?=$dados['nome']?></option>
								<?php
							}
							?>
					</select></div>
					<span class="ex">Bairro do imóvel. <strong>Campo obrigatório</strong></span>
				</div>
				<div class="label">
					<span>Quantidade de dormitórios</span>
					<div class="input"><input type="text" value="<?=$dormitorios?>" name="dormitorios" /></div>
					<span class="ex">Quantidade de dormitórios do imóvel</span>
				</div>
				<div class="label">
					<span>Titulo</span>
					<div class="input"><input type="text" value="<?=$nome?>" name="nome" /></div>
					<span class="ex">Titulo do seu imóvel. <strong>Campo obrigatório</strong></span>
				</div>
				<div class="label">
					<span>Nome do dono</span>
					<div class="input"><input type="text" value="<?=$nomeVendedor?>" name="nomeVendedor" /></div>
					<span class="ex">Nome do dono</span>
				</div>
				<div class="label">
					<span>Email do dono</span>
					<div class="input"><input type="text" value="<?=$emailVendedor?>" name="emailVendedor" /></div>
					<span class="ex">Email do dono</span>
				</div>
				<div class="label">
					<span>Telefone do dono</span>
					<div class="input"><input type="text" value="<?=$telefoneVendedor?>" name="telefoneVendedor" /></div>
					<span class="ex">Telefone do dono</span>
				</div>
				<div class="label">
					<span>Endereço do Imóvel</span>
					<div class="input"><input type="text" value="<?=$enderecoImovel?>" name="enderecoImovel" /></div>
					<span class="ex">Endereço do Imóvel</span>
				</div>
				<div class="label">
					<span>
						<label>
							<input type="checkbox" value="1" name="ativo" <?=($ativo=='1'?'checked':'')?> style="width:20px" /> Ativo
						</label>
					</span>
					<span class="ex">Se o produto estiver marcado como ativo ele aparecerá em seu site, caso contrário não.</span>
				</div>
				<div class="label">
					<span>
						<label>
							<input type="checkbox" value="1" name="destaque" <?=($destaque=='1'?'checked':'')?> style="width:20px" /> Destaque
						</label>
					</span>
					<span class="ex">Se o produto estiver marcado como destaque ele aparecerá na página inicial de seu site.</span>
				</div>
				<div class="label">
					<span>Ligação <a href="javascript:void(0)" onclick="javascript:show_hide('categorias_0');">clique aqui para criar uma ligação, ou ver as ligações já feitas, entre categorias e subcategorias.</a></span>
					<?
						// Vai assim memo e boa * _|_
						$sql = "SELECT idCat FROM ".SUFIXO."catalogo_relacao where idProd = '".$id."'";
						$qry = mysql_query($sql);
						$idsCat = array();
						while ($dados = mysql_fetch_array($qry)) {
							$idsCat[] = $dados['idCat'];
						}
					?>
					<div id="categorias_0" style="display:block;">
						<?
							$sql = "SELECT nome,id FROM ".SUFIXO."catalogo_categorias where idLig = '0' order by nome";
							$qry = mysql_query($sql);
							while ($dados = mysql_fetch_array($qry)) {
								?>
									<span>
										<label>
											<input type="checkbox" value="<?=$dados['id']?>" <?=( (isset($idsCat) && is_array($idsCat) && in_array($dados['id'],$idsCat)) || (mysql_num_rows($qry) == 1) ?'checked':'')?> name="categorias[]" onclick="javascript:show_hide('categorias_<?=$dados['id']?>');" style="width:20px" /> <?=$dados['nome']?>
										</label>
									</span>
								<?
								MostraTudo($dados['id'],$idsCat);
							}
						?>
					</div>
					<span class="ex">Ligação que o produto terá entre categorias e subcategorias.</span>
				</div>	
				<div class="label">
					<span>Valor R$</span>
					<div class="input"><input type="text" value="<?=$valor?>" name="valor" maxlength="15" /></div>
					<span class="ex">Valor do produto, separado centavos por virgulas, exp: 15,50. <strong>Campo Opcional</strong></span>
				</div>	

				<div class="label">
					<span>Descrição</span>
					<textarea class="editor"  id="editor" name="descricao"><?=$descricao?></textarea>
					<span class="ex">Aqui é a descrição do produto. <strong>Campo obrigatorio</strong></span>
				</div>
					<?php
						$sql = "SELECT firtPhoto FROM ".SUFIXO."catalogo where id = '".$id."'";
						$dados = mysql_fetch_array(mysql_query($sql));
						$firtPhoto = (!empty($dados['firtPhoto'])?$dados['firtPhoto']:"");
						
						$dir = "../uploads/produtos";
						$prefixo = "ct";
						$retorno = "plugin=catalogo*acoes=produtos*editar*id=".$id;
						require_once('plugins/galeria/api/index.php');
					?>
				
				<a href="javascript: void(0)" onclick="SaveEdit()" title="salvar e continuar editando" class="a"><img src="imagens/icones/save_edit.png" alt="salvar e continuar editando"/></a>
				
				<a href="javascript: void(0)" onclick="Save()" title="salvar" class="a"><img src="imagens/icones/save.png" alt="salvar"	/></a>
				
				<a href="<?=$backReal?>" title="voltar" class="a"><img src="imagens/icones/back.png" alt="voltar"	/></a>

			</form>
		</div>
	<?php
break;
}
?>
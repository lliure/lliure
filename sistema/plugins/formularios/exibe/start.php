<?php
$pagina = $_GET['formularios'];
$consulta = "select * from ".SUFIXO."formularios where id = '".$pagina."'";
$dados = mysql_fetch_array(mysql_query($consulta));
if (isset($_POST['sub']) && $_POST['sub'] == 'Enviar') {
	$conteudo = "
		<table width='600px'>
			<tr>
				<td style='font-size:14px; font-family:Arial, Verdana;'>
					<strong>Formulário de contato</strong>
				</td>
			</tr>
	";
	$consulta = "select * from ".SUFIXO."formularios_campos where id_form = '".$pagina."' order by ordem ASC";
	$query = mysql_query($consulta);
	while($form = mysql_fetch_array($query)){
		
		if ( ($form['obrigatorio'] == '1' && isset($_POST[$form['identificacao']]) && $_POST[$form['identificacao']] != '' ) || ($form['obrigatorio'] != '1')) {
			$conteudo .= "
				<tr>
					<td style='font-size:12px; font-family:Arial, Verdana;'>
						<strong>".$form['titulo']."</strong>
					</td>
				</tr>
				<tr>
					<td>
						".$_POST[$form['identificacao']]."
					</td>
				</tr>
			";
		} else {
			$msgerro = 'Preencha todos os campos obrigatórios!';
			break;
		}
	}
	if (!isset($msgerro)) {
		$conteudo .= "
			<tr>
				<td style='font-size:12px; font-family:Arial, Verdana;'>
					<br /><br />
					<i>".date('d/m/Y - H:i')."</i>
				</td>
			</tr>
			";
		$conteudo .= "</table>";
		$headers = "Content-Type: text/html; charset=iso-8859-1\n"; 
		$headers.="From: ".(isset($_POST['email']) && $_POST['email'] != ''?$_POST['email']:'contato@seusite.com.br')."\n";
		mail($dados['email'],'Contato de seu site',$conteudo,$headers);
	}

}

if(!empty($dados['titulo'])){
	?>
	<span class="h1"><?=$dados['titulo']?></span>
	<?php
}

if (isset($msgerro)) {
	?>
	<div class="msgerro">
		<?=$msgerro?>
	</div>
	<?
}
?>


<div class="paginaDiv">
	<?=$dados['conteudo']?>
</div>
<span class="espaco"></span>
<?php
if(isset($dados['embed'])){ ?>
	<div id="mapa">
		<?=$dados['embed']?>
	</div>
<?php
}
$consulta = "select * from ".SUFIXO."formularios_campos where id_form = '".$pagina."' order by ordem ASC";

$query = mysql_query($consulta);

if(mysql_num_rows($query) > 0){ ?>
	<div class="formulario">
		<form action="" method="post" class="contato" />
	<?php
	while($dados = mysql_fetch_array($query)){
				if ($dados['tipo'] == 'text') { ?>
					<label class="text">
						<span><?=($dados['obrigatorio']=='1'?"<span class='obrigatorio'>*</span>":'')?> <?=$dados['titulo']?></span> 
						<input type="text" name="<?=$dados['identificacao']?>" value="<?=$dados['valor']?>" />
					</label>
				<? } elseif ($dados['tipo'] == 'textarea') { ?>
					<label class="textarea">
					 	 <span><?=($dados['obrigatorio']=='1'?"<span class='obrigatorio'>*</span>":'')?> <?=$dados['titulo']?></span> 
						 <textarea name="<?=$dados['identificacao']?>"><?=$dados['valor']?></textarea>
					</label>
				<? } elseif ($dados['tipo'] == 'checkbox') { ?>
					<label class="checkbox">
						<?=($dados['obrigatorio']=='1'?"<span class='obrigatorio'>*</span>":'')?> 
						 <input type="checkbox" name="<?=$dados['identificacao']?>" value="<?=$dados['valor']?>" /> 
						 <span><?=$dados['titulo']?></span>
					</label>
				<? } ?>

			

		<?php
	}	 ?>
			<button type="submit">Enviar</button>
			<div class="both"></div>
		</form>
	</div>
	<?php
}
?>
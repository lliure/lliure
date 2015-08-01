<?php
$sql = "SELECT * FROM ".SUFIXO."catalogo where id = '".$_GET['prod']."'";
$dados = mysql_fetch_array(mysql_query($sql));
$nomeProd = $dados['nome'];
?>
<div class="produto_exibe">
	<span class="h1"><?=$dados['nome']?></span>
	<span class="texto">
		<?=$dados['descricao']?>
	</span>

	<div class="both10"></div>
</div>
<?php
$consulta = "select * from ".SUFIXO."pictures where  idPag = 'ct".$dados['id']."'";

$query = mysql_query($consulta);

if(mysql_num_rows($query) > 0){ ?>
	<div class="galfotos">
	<?php
	while($dados = mysql_fetch_array($query)){
		$foto = $dados['foto'];
		$descricao = $dados['descricao'];
		?>
		<span class="foto">
			<a href="uploads/produtos/<?=$foto?>" rel="lightbox[0]" title="<?=$descricao?>">
				<img src="<?=SISTEMA?>/includes/thumbs.php?imagem=100-../../uploads/produtos/<?=$foto?>-90" alt="" />
			</a>
		</span>
		<?php
	}	 ?>
	</div>
	<?php
}
?>
<?
if (isset($_POST['nome'])) {
	$conteudo = "
		<table width='600px'>
			<tr>
				<td style='font-size:14px; font-family:Arial, Verdana;'>
					<strong>Proposta do imóvel ".$dados['nome']."</strong>
				</td>
			</tr>
	";
	$consulta = "select * from ".SUFIXO."formularios_campos where id_form = '".$pagina."' order by ordem ASC";
	$query = mysql_query($consulta);

		
		
		$conteudo .= "
			<tr>
				<td style='font-size:12px; font-family:Arial, Verdana;'>
					<strong>Imóvel:</strong>
				</td>
			</tr>
			<tr>
				<td>
					<a href='http://www.scatolimecasemiroimoveis.com.br/?catalogo&prod=".$_GET['prod']."'>".$nomeProd."</a>
				</td>
			</tr>
			<tr>
				<td>
					<br />
				</td>
			</tr>
			<tr>
				<td style='font-size:12px; font-family:Arial, Verdana;'>
					<strong>Nome:</strong>
				</td>
			</tr>
			<tr>
				<td>
					".$_POST['nome']."
				</td>
			</tr>
			<tr>
				<td style='font-size:12px; font-family:Arial, Verdana;'>
					<strong>E-mail:</strong>
				</td>
			</tr>
			<tr>
				<td>
					".$_POST['email']."
				</td>
			</tr>
			<tr>
				<td style='font-size:12px; font-family:Arial, Verdana;'>
					<strong>Telefone:</strong>
				</td>
			</tr>
			<tr>
				<td>
					".$_POST['telefone']."
				</td>
			</tr>
			<tr>
				<td style='font-size:12px; font-family:Arial, Verdana;'>
					<strong>Proposta:</strong>
				</td>
			</tr>
			<tr>
				<td>
					".$_POST['proposta']."
				</td>
			</tr>
		";


	
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
		
		//mail('deividyz@gmail.com','Proposta para imóvel',$conteudo,$headers);
		
		mail('scatolimimoveis@yahoo.com.br','Proposta para imóvel',$conteudo,$headers);
		mail('luiscasemiro@yahoo.com.br','Proposta para imóvel',$conteudo,$headers);
		echo "<script>alert('E-mail enviado com sucesso!')</script>";

}
?>
<span class="h1" style="display:block; width:100%; float:left;">Gostou? Entre em contato conosco pelo formulário abaixo:</span>
<div class="formulario" style="display:block; width:100%; float:left;">
	<form action="" method="post" class="contato" />
		<label class="text">
			<span>Nome</span> 
			<input type="text" name="nome" />
		</label>
		<label class="text">
			<span>Telefone</span> 
			<input type="text" name="telefone" />
		</label>
		<label class="text">
			<span>E-mail</span> 
			<input type="text" name="email" />
		</label>
		<label class="text">
			<span>Proposta</span> 
			<textarea name="proposta" style="width:100%"></textarea>
		</label>
		<button type="submit">Enviar</button>
		<div class="both"></div>
	</form>
</div>
<?php
if(isset($_GET['fim'])){
	if(isset($_POST['email']) && !empty($_POST['email'])){	
		$telefone = $_POST['tel'];
		$de = $_POST['email'];
		$deNome = $_POST['nome'];
		$para = "jeison@infoextreme.com.br";
		$paraNome = "jeison";
		$assunto = "Solicitação de orçamento";
		
		$total = '';
	
		if(is_array($_SESSION['produtos'])){
			foreach($_SESSION['produtos'] as $chave => $quantidade) {

				$produto = mysql_query("select * from ".SUFIXO."catalogo where id = '".$chave."'");
				$produto =	mysql_fetch_array($produto);
				$total += $produto['valor']*$quantidade;
				$produtosOrc = "<tr><td>".$produto['nome']."</td><td>".$quantidade."</td></tr>";

			}
		}
		 
		
		$message = " O usuário $deNome solicitou um orçamento. <br/>
Dados para contato: $de, $telefone <br/>
<h3>Produtos</h3>
<table>
<tr>
	<th>produto</th>
	<th>quantidade</th>
<tr>
".$produtosOrc."
<tr>
	<td>Valor total:</td>
	<td>R$ ".number_format($total, 2,',','')."</td>
<tr>
</table>		
		";
				
		$headers = "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= 'To: '.$paraNome.' <'.$para.'>'. "\r\n";
		$headers .= 'From: '.$deNome.' <'.$de.'>' . "\r\n";
		
		if(isset($_SESSION['produtos']) && mail($para, $assunto, $message, $headers)){
			unset($_SESSION['produtos']);
			?>
			<span class="mensagem"><span>Orçamento enviado com sucesso</span></span>
			<?php
		} else {
			?>
			<span class="mensagem"><span>Houve um erro no envio do orçamento, tente mais tarde.<br/> <a href="?catalogo&carrinho">Voltar</a></span></span>
			<?php		
		}
		

	} else {
		?>
		<form method="post"  class="contato">
			<span class="h2">Seus dados</span>
			<label>
				<span>Nome</span>
				<input type="text" name="nome" />
			</label>
			
			<label>
				<span>E-mail</span>
				<input type="text" name="email" />
			</label>			
			
			<label>
				<span>Telefone</span>
				<input type="text" name="tel" />
			</label>
			
			<button type="submit">Concluir</button>
		</form>
		<?php
	}
} else {
	if(isset($_GET['id'])){
		if(isset($_SESSION['produtos']) && array_key_exists($_GET['id'], $_SESSION['produtos'])){
			$_SESSION['produtos'][$_GET['id']] += 1;
		} else {
			$_SESSION['produtos'][$_GET['id']] = 1;
		}
		?>
		<span class="mensagem"><span>Produto adicionado a seu orçamento</span></span>
		<?php
	} elseif(isset($_POST['quantidade'])){
		$_SESSION['produtos'] = $_POST['quantidade'];
		foreach ($_SESSION['produtos'] as $key => $quantidade){
			if($quantidade < 1){
				unset($_SESSION['produtos'][$key]);
			}
		}
	}

	if(isset($_SESSION['produtos'])){
	?>
	<form action="?catalogo&carrinho" method="post" class="carrinho">
		<table >
			<tr>
				<th>Produto</th>
				<th width="93px">Quantidade</th>
				<th width="100px">Valor unitario</th>
			</tr>	
			<?php
			$total = '';
			foreach($_SESSION['produtos'] as $chave => $quantidade){
				$produto = mysql_fetch_array(mysql_query("select * from ".SUFIXO."catalogo where id = '".$chave."'"));
				$total += $produto['valor']*$quantidade;
				?>
				<tr>
					<td><?=$produto['nome']?></td>
					<td><input type="text" value="<?=$quantidade?>" name="quantidade[<?=$chave?>]"/></td>
					<td>R$ <?=number_format($produto['valor'], 2,',','')?></td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td colspan="2"><strong>Total</strong></td>
				<td>R$ <?=number_format($total, 2,',','')?></td>
			</tr>
		</table>
		
		<button type="submit">Atualizar orçamento</button>
		<span><a href="index.php">Adicionar mais produtos</a></span>
		<span><a href="?catalogo&carrinho&fim">Finalizar orçamento</a></span>
	</form>
	<?php
	} else {
	?>
	<span class="mensagem"><span>Nenhum orçamento iniciado</span></span>
	<?php
	}
}
?>


<?php
	$tabela = SUFIXO."admin";
	
	$consulta = "select * from ".$tabela.($DadosLogado['tipo'] == 1?'':" where tipo = '0'");
	
	$campos = array (
			'nome' => '',
			'login' => '',
			'senha' => '',
			'tipo' => ''
			);
	
if(empty($_GET['usuarios'])){
	if(isset($_GET['novo'])){

		$dados = array(
					'nome' => 'Novo',
					'login' => 'Novo',
					'senha' => md5(time()),
					'tipo' => '0'
					);
		mLinsert($tabela, $dados);
	}

	$query = mysql_query($consulta." order by nome ASC");
	?>
	<span class="botao"><a href="?usuarios&amp;novo">Novo usuário</span></span>
	<div class="both"></div>
	<?php
	while($dados = mysql_fetch_array($query)){
		$nome = explode(" ", $dados['nome']);
		$nome = $nome['0'];	
		$id = $dados['id'];		?>
	
		<div class="listp">
			<div class="inter">
				<a href="?usuarios=<?=$id?>"><img src="imagens/layout/user.png" alt="<?=$nome?>" /></a>
				<a href="?usuarios=<?=$id?>"><span><?=$nome?></span></a>
			</div>
		</div>
	<?php
	}
} else {
$idUser = $_GET['usuarios'];

	if(isset($_GET['save'])){ 		
		foreach($_POST as $chave => $valor){
			$campos[$chave] = $valor;
		}
			
		$alter['id'] = $idUser;
		if(empty($campos['senha'])){
			unset($campos['senha']);
		} else{
			$campos['senha'] = md5($campos['senha']."0800");
		}
		
		if(!isset($_POST['tipo'])){
			unset($campos['tipo']);
		}
		
		mLupdate($tabela, $campos, $alter);
		?>
		<span class="mensagem"><span>Alteração realizada com sucesso</span></span>

		<meta http-equiv="refresh" content="1; URL=?usuarios">
	<?php		
	} elseif(isset($_GET['del'])){
	
		$user['id'] = $idUser;
		mLdelete($tabela, $user);
		?>
		<span class="mensagem"><span>Usuario apagado com sucesso</span></span>

		<meta http-equiv="refresh" content="3; URL=?usuarios">
	<?php
	} else {
		$consulta = $consulta.($DadosLogado['tipo'] == 1?' where':" and")." id=$idUser";
		$query = mysql_query($consulta);
		$dados = mysql_fetch_array($query);
		
			foreach($campos as $chave => $valor){
				$$chave = $dados[$chave];
			}
	?>
		<script type="text/javascript">
			function Save(){
				document.getElementById('form').action="?usuarios=<?=$idUser?>&save";
				document.getElementById('form').submit();
			}
		</script>
	<div class="boxCenter">
		<form method="post" class="form" id="form">

				<div class="label">
					<span>Nome</span>
					<div class="input"><input type="text" value="<?=$nome?>" name="nome" /></div>
					<span class="ex">Nome do usuario. <strong>Campo obrigatorio</strong></span>
				</div>
				
				<div class="label">
					<span>Login</span>
					<div class="input"><input type="text" value="<?=$login?>" name="login" /></div>
					<span class="ex">Login utilizado para acessar o painel. <strong>Campo obrigatorio</strong></span>
				</div>
				
				<div class="label">
					<span>Senha</span>
					<div class="input"><input type="password" value="" name="senha" /></div>
					<span class="ex">Deixe em branco para manter a senha atual. <strong>Campo opcional</strong></span>
				</div>		
				<?php
				if($DadosLogado['tipo'] == 1){
					?>
					<div class="label">
						<span>Tipo</span>
						<select name="tipo">
							<option value="0">Usuário</option>
							<option value="1" <?=($tipo == 1?'selected':'')?>>Desenvolvedor</option>
						</select>
						<span class="ex">Nivel do usuário. <strong>Campo opcional</strong></span>
					</div>
					<?php
				}
				?>
				<a href="javascript: void(0)" onclick="Save()" title="Salvar alterações" class="a"><img src="imagens/icones/save.png" alt="salvar"	/></a>
				
				<a href="?usuarios=<?=$idUser?>&del" onclick="return confirmAlgo('esse usuário')" title="Excluir usuário" class="a"><img src="imagens/icones/no.png" alt="Apagar Usuario"	/></a>
		</form>
	</div>
		<?php	
	}
}
?>
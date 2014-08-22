<?php
function adduser($args){
	$llpath = LLPATH;
	
	if(empty($args['u']) || empty($args['p']))
		die('Parâmetros inválidos.');
	
	$dados = array(
		'login' => $args['u'],
		'senha' => md5($args['p'].'0800')
	);
	
	if(!empty($args['g']))
		$dados['grupo'] = $args['g'];
	
	if($erro = jf_insert(PREFIXO.'admin', $dados))
		echo $erro;
	else
		echo 'O usuário <span class="color2">'.$args['u'].'</span> foi adicionado com sucesso';
}
?>
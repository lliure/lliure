<?php
/**
*
* lliure WAP
*
* @Vers�o 8.0
* @Pacote lliure
* @Entre em contato com o desenvolvedor <lliure@lliure.com.br> http://www.lliure.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if(empty($_GET['user'])){
	$botoes[] =	array('href' => $backReal, 'fa' => 'fa-chevron-left', 'title' => $backNome);
	$botoes[] =	array('href' => $_ll['opt']['onclient'].'&ac=new',  'fa' => 'fa-user-plus ', 'title' => 'Criar usu�rio', 'attr' => 'class="criar"');
} else {
	$botoes[] =	array('href' => (isset($_GET['minhaconta']) ? $_ll['url']['endereco'] : '?opt=user') ,  'fa' => 'fa-chevron-left', 'title' => 'Voltar');
}

echo app_bar('Painel de usu�rios', $botoes);


if(empty($_GET['user'])){
	$navegador = new navigi();	
	$navegador->tabela = PREFIXO.'lliure_admin';
	
	$navegador->query = 'select * from '.$navegador->tabela.' where login is null || login != "'.$_ll['user']['login'].'"'.(ll_tsecuryt() ? '' : ' and grupo != "dev"').' order by nome ASC';
	
	$navegador->delete = true;

	$navegador->config = array(
			'link' => $_ll['opt']['home'].'&user=',
			'fa' => 'fa-user'
			);
	$navegador->monta();
	?>
	<script type="text/javascript">
		$(document).ready(function(){			
			$(".criar").click(function(){
				ll_load($(this).attr('href'), function(){
					jfAlert('Novo usu�rio criado com sucesso!', 1);
					navigi_start();
				});
				return false;
			}); 
		});
	</script>
	<?php
} else {

	$consulta = 'select * from '.PREFIXO.'lliure_admin where id = "'.$_GET['user'].'" limit 1';
	
	$dados = mysql_fetch_assoc(mysql_query($consulta));
	
	extract($dados);
	?>

	<div class="boxCenter editUsuario">
		<form method="post" action="<?php echo $_ll['opt']['onserver'].'&ac=grava&id='.$_GET['user'].(isset($_GET['en']) && $_GET['en'] == 'minhaconta' ? '&en=minhaconta' : '' );?>"  enctype="multipart/form-data">
			<fieldset>
				<legend>Dados pessoais</legend>
				
				<div>
					<label>Nome <span>(obrigatorio)</span></label>
					<input type="text" value="<?php echo $nome?>" name="nome" />
				</div>
			
				<div>
					<label>E-mail</label>
					<input type="text" value="<?php echo $email?>" name="email" />
				</div>	
			
				<div>
					<label>Twitter</label>
					<input type="text" value="<?php echo $twitter?>" name="twitter" />
				</div>		
			
				<div class="user-fileup">
					<label>Foto</label>
					<?php
					$file = new fileup;
					$file->titulo = '';
					$file->rotulo = 'Selecionar imagem'; 
					$file->registro = $foto;
					$file->campo = 'foto'; 
					$file->extencao = 'png jpg';
					$file->form();
					?>
				</div>				
			</fieldset>
			
			<fieldset>
				<legend>Dados de acesso</legend>
				<div>
					<label>Login <span>(obrigatorio)</span></label>
					<input type="text" <?php echo !empty($login) ? 'value="'.$login.'" readonly class="inatv"' : ''; ?> name="login" />
					<span class="ex">N�o poder� ser alterado posteriormente.</span>
				</div>
				
				<div>
					<label>Senha</label>
					<input type="password" value="" name="senha" />
					<span class="ex">Deixe em branco para manter a senha atual.</span>
				</div>	
			
				<?php	

				if(ll_tsecuryt('admin') && $login != $_ll['user']['login']){
					?>
					<div>
						<label>Grupo de usu�rio</label>
						<select name="grupo">
							<?php
							$grupos = array('admin' => 'Administrador', 'user' => 'Usu�rio');
							ll_tsecuryt() ? $grupos['dev'] = 'Desenvolvedor' : '';
							
							
							if(isset($_ll['conf']->grupo)){
								//$grupos_add = jf_iconv("UTF-8", "ISO-8859-1", (array) $llconf->usua_grup);
								
								if(!empty($_ll['conf']->grupo)){
									$sub = null;									
									foreach($_ll['conf']->grupo as $ogrupo => $valor)
										if(isset($valor->nome))
											$sub .= '<option value="'.$ogrupo.'" '.($grupo == $ogrupo?'selected':'').'>'.$valor->nome.'</option>';
										
									if($sub != null)
										echo '<optgroup label="Sub-grupos">'.$sub.'</optgroup>';
								}
							}
							
							echo '<optgroup label="Grupos principais">';
							foreach($grupos as $indice => $valor)
								echo '<option value="'.$indice.'" '.($grupo == $indice?'selected':'').'>'.$valor.'</option>';					
							echo '</optgroup>';
							?>
						</select>
					</div>
					<?php
				}
				?>
			</fieldset>
			
			<span class="botao"><a href="<?php echo  $backReal;?>">Voltar</a></span>
			
			<span class="botao"><button type="submit" class="confirm">Gravar</button></span>
		</form>
	</div>
	<?php	
}
?>

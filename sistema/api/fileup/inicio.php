<?php/**** API Fileup - Plugin CMS** @vers�o 4.3.3* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/* @licen�a http://opensource.org/licenses/gpl-license.php GNU Public License**//*	no formulario use assim:	$file = new fileup; 					//inicia a classe	$file->titulo = 'Imagem'; 				//titulo da Label	$file->rotulo = 'Selecionar imagem'; 	// texto do bot�o	$file->registro = $dados['imagem'];	$file->campo = 'imagem'; 				//campo do banco de dados (no retorno no formulario ele ir� retornar um $_POST com essa chave, no caso do exemplo $_POST['imagem'])	$file->extencao = 'png jpg'; 			//exten��es permitidas para o upload, se deixar em branco ser� aceita todas	$file->form(); 				 			// executa a classe	No retorno no formulario use assim:	 	$file = new fileup; 											// incia a classe	$file->diretorio = '../../../uploads/porta_niquel/ofertas/';	// pasta para o upload (lembre-se que o caminho � apartir do arquivo onde estiver sedo execultado)	$file->up(); // executa a classe*/class fileup{	var $campo;	var $titulo;	var $registro;	var $extencao = null;	var $diretorio;	var $rotulo = 'Selecionar arquivo';		function form(){		?>				<label><?php echo $this->titulo; ?></label>		<a href="javascript: void(0);" class="fileup_botao"><?php echo $this->rotulo;?></a>		<input id="fileup_nome" value="<?php echo $this->registro?>" readonly />		<input type="file" class="fileup_file" name="fileup_file"  />		<input type="hidden" name="fileup_campo" value="<?php echo $this->campo;?>" />		<?php echo (isset($this->registro) ? '<input type="hidden" name="fileup_regant" value="'.$this->registro.'" />' : ''); ?>				<script>			$('.fileup_botao, input.arqUrl').click(function(){				$('.fileup_file').click();				});						$('.fileup_file').change(function(){				var extencao = $(this).val().split('.').pop();				var extencoes = '<?php echo $this->extencao;?>';				if(extencoes == '' || fileup_exten(extencao, extencoes.split(' '))){					$('#fileup_nome').val($(this).val());				} else {					jfAlert('Tipo de arquivo n�o permitido');					$('#fileup_nome').val();				}			});						function fileup_exten(needle, haystack) {				for (var chave in haystack)   					if (haystack[chave] == needle)					return chave;									return false;									}					</script>		<?php	}		function up(){		if(!empty($_FILES['fileup_file']['name'])){			$imagemNome = explode('.', $_FILES['fileup_file']['name']);			$extenc = array_pop($imagemNome);			$imagemNome = join(".", $imagemNome);			$imagemNome = jf_urlformat($imagemNome);			$imagemNome = $imagemNome.'_'.substr(md5(time()), rand(0, 20), 8).'.'.$extenc;							if(isset($_POST['fileup_regant']))				unlink($this->diretorio.$_POST['fileup_regant']);			move_uploaded_file($_FILES['fileup_file']['tmp_name'],  $this->diretorio.$imagemNome);			$_POST[$_POST['fileup_campo']] = $imagemNome;		}				unset($_POST['fileup_campo'], $_POST['fileup_regant']);	}}?>
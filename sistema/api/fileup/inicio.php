<?php/**** API Fileup - Plugin CMS** @Vers�o 4.10.4* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License**//*	no formulario use assim:	$file = new fileup; 					//inicia a classe	$file->titulo = 'Imagem'; 				//titulo da Label	$file->rotulo = 'Selecionar imagem'; 	// texto do bot�o	$file->registro = $dados['imagem'];	$file->campo = 'imagem'; 				//campo do banco de dados (no retorno no formulario ele ir� retornar um $_POST com essa chave, no caso do exemplo $_POST['imagem'])	$file->extencao = 'png jpg'; 			//exten��es permitidas para o upload, se deixar em branco ser� aceita todas	$file->form(); 				 			// executa a classe	No retorno no formulario use assim:	 	$file = new fileup; 											// incia a classe	$file->diretorio = '../../../uploads/porta_niquel/ofertas/';	// pasta para o upload (lembre-se que o caminho � apartir do arquivo onde estiver sedo execultado)	$file->up(); // executa a classe*/class fileup{	var $campo;	var $titulo = null;	var $registro;	var $extencao = null;	var $diretorio;	var $rotulo = 'Selecionar arquivo';		function form(){		if(!is_array($this->campo)){			$this->titulo = array($this->titulo);			$this->registro = array($this->registro);			$this->campo = array($this->campo);		}				$total_campos = count($this->campo);				if(!is_array($this->rotulo)){			$rotulo = $this->rotulo;			$this->rotulo = array();			for($i = 0; $i < $total_campos; $i++)				$this->rotulo[] = $rotulo;		}				if(!empty($this->extencao)){						if(!is_array($this->extencao)){				$extencao = $this->extencao;				$this->extencao = array();				for($i = 0; $i < $total_campos; $i++){					$this->extencao[] = $extencao;				}			}			$FileUpExt = null;			foreach($this->extencao as $chave => $valor)				$FileUpExt .= (!empty($FileUpExt) ? ',' : '' ).'"'.strtolower($valor).'"' ;		}						echo '<div class="fileUpBloco">';			foreach($this->campo as $chave => $campo){				echo '<div class="fileUpItem">'						.(!empty($this->titulo[$chave])? '<label>'.$this->titulo[$chave].'</label>' : '')						.'<a href="javascript: void(0);" class="fileup_botao">'.$this->rotulo[$chave].'</a>'						.'<input class="fileup_nome" value="'.$this->registro[$chave].'" readonly />'						.'<input type="file" class="fileup_file" rel="'.$chave.'" name="fileup_file['.$chave.']"  />'						.'<input type="hidden" name="fileup_campo['.$chave.']" value="'.$this->campo[$chave].'" />'						.(isset($this->registro[$chave]) ? '<input type="hidden" name="fileup_regant['.$chave.']" value="'.$this->registro[$chave].'" />' : '')							.'</div>';			}				echo '<input type="hidden" name="fileup_total" value="'.$total_campos.'" />'			.'</div>';		?>		<script type="text/javascript">					var FileUpExt = new Array(<?php echo $FileUpExt; ?>);						$('.fileup_botao').click(function(){				$(this).closest('div').find('.fileup_file').click();				});						$('.fileup_file').change(function(){				var base = $(this).closest('div');				var extencao = $(this).val().split('.').pop();				var extencoes = FileUpExt[$(this).attr('rel')];				if(extencoes == '' || fileup_exten(extencao.toLowerCase(), extencoes.split(' '))){					$(base).find('.fileup_nome').val($(this).val());				} else {					jfAlert('Tipo de arquivo n�o permitido');					$(base).find('.fileup_nome').val();				}			});						function fileup_exten(needle, haystack) {				for (var chave in haystack)   					if (haystack[chave] == needle)					return chave;									return false;									}					</script>		<?php	}		function up(){		if(!isset($_FILES['fileup_file']['name'])){			echo 'Arquivo n�o enviado. verifique se o formulario de origem est� setado como <strong>enctype="multipart/form-data"</strong> <br/>';			unset($_POST['fileup_campo'], $_POST['fileup_regant'], $_POST['fileup_file'], $_POST['fileup_total']);						return false;		}				for($chave = 0; $chave < $_POST['fileup_total']; $chave++){								if(!empty($_FILES['fileup_file']['name'][$chave])){										$imagemNome = explode('.', $_FILES['fileup_file']['name'][$chave]);				$extenc = array_pop($imagemNome);				$imagemNome = join(".", $imagemNome);				$imagemNome = jf_urlformat($imagemNome);				$imagemNome = $imagemNome.'_'.substr(md5(time()), rand(0, 20), 8).'.'.$extenc;													if(isset($_POST['fileup_regant'][$chave]))					@unlink($this->diretorio.$_POST['fileup_regant'][$chave]);				move_uploaded_file($_FILES['fileup_file']['tmp_name'][$chave],  $this->diretorio.$imagemNome);				$_POST[$_POST['fileup_campo'][$chave]] = $imagemNome;			}		}		unset($_POST['fileup_campo'], $_POST['fileup_regant'], $_POST['fileup_file'], $_POST['fileup_total']);	}}?>
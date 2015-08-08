/**
*
* inputText
*
* @Versão 1.0.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/


var jfinputval_array = new Array();
jQuery.fn.extend({ 
	jf_inputext: function (parametros, callback){
		
		$(this).each(function(){
			var idl = $(this).attr('name')+'_label';
			var oThis = $(this);
			
			if($(this).attr('rel') != undefined)	{
				$(this).before('<span class="label" id="'+idl+'">'+$(this).attr('rel')+'</span>');
				
				if($(this).val() != ''){
					$('#'+idl).css({'display': 'none'});
				}
				
				
				$('#'+idl).click(function(){
					$(oThis).focus();
				});
			}
		});

		$(this).focus(function(){
			if($(this).val() == ''){
				$('#'+$(this).attr('name')+'_label').stop(true, true).fadeOut('300');
			}
		});
		
		$(this).focusout(function(){
			if($(this).val() == ''){
				$('#'+$(this).attr('name')+'_label').stop(true, true).fadeIn('300');
			}
		});
	}
});
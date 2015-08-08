$().ready( function(){
$('body').append('<div id="jfboxMargin"><div id="jfboxLoad"></div></div>'
				+'<div id="jfboxFundo"></div><img src="imagens/jfbox/loading.gif" id="gifJfbox" alt="" style="display: none;">'
				+'<div id="jfAviso"></div>');
 });
 
 jQuery.fn.extend({
	jfbox: function (parametros, callback){
		//parametros default
		var sDefaults = {
			width: 920,
			height: 470,
			abreBox: true,
			carrega: false,
			campos: false,
			position: false
		}
		
		//função do jquery que substitui os parametros que não foram informados pelos defaults
		var options = jQuery.extend(sDefaults, parametros);
		
		
		$(this).bind({
			submit: function() {
				var carrega = $(this).attr('action');
				var campos =  $(this).serializeArray();

				loadJfbox(carrega, campos);

				return false;
			},
		
			click: function() {
				if(typeof $(this).attr('href') !== "undefined" && $(this).attr('href')){
					var carrega = $(this).attr('href');

					loadJfbox(carrega, null, this);

					if(options.abreBox == true)
						abreJfbox();

					return false;
				}
				
			}
		});	
		
		if(options.carrega){
			loadJfbox(options.carrega, options.campos); 
			
			if($('#jfboxMargin').css('display') == 'none' && options.abreBox == true)
				abreJfbox();
		}
		
		function loadJfbox(carrega, campos, nthis){
			nthis = nthis != 'undefined' ? nthis : null;
			gifJfbox();
						
			$('#jfboxLoad').load(carrega, campos, function(response, status, xhr) {
				if (status == "error")
					$("#jfboxLoad").html('Houve um erro ao carregar essa página:' + xhr.status + " " + xhr.statusText);
				
				$("#jfboxLoad  .jfbox").jfbox({abreBox: false});
				gifJfbox(true);
				
				
				if(typeof callback == 'function') //checa se o retorno é uma função
					callback.call(this, nthis); // executa
	
			});
			
			return true;
		}
	
		function abreJfbox(){
			var scrollX = $(window).scrollTop();
		
			$('#jfboxLoad').css({width: options.width, height: options.height})

			//Carrega o height e width da Janela
			var winH = $(window).height();
			var winW = $(window).width();
			
			if(options.position == false){
				$('#jfboxMargin').css('top',  (winH/2-($('#jfboxMargin').height()+20)/2)+scrollX);
				$('#jfboxMargin').css('left', winW/2-($('#jfboxMargin').width()+20)/2);
			} else {
				if(options.position[0] != 0)
					$('#jfboxMargin').css('top',  options.position[0]);
				
				if(options.position[1] != 0)
					$('#jfboxMargin').css('left',  options.position[1]);
			}
			$('#jfboxMargin').fadeIn(150);
			
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();

			$('#jfboxFundo').css({'width':maskWidth,'height':maskHeight});
			$('#jfboxFundo').fadeTo(300,0.7);			
			
			$('#jfboxFundo').click(function () {
				fechaJfbox();
				return false;
			});		
		}
		
		function gifJfbox(fechar){
			if(typeof fechar !== "undefined" && fechar){
				$('#gifJfbox').css({display: 'none'});
			} else {
				var scrollX = $(window).scrollTop();
				var winH = $(window).height();
				var winW = $(window).width();
				
				$('#gifJfbox').css('top',  (winH/2-32/2)+scrollX);
				$('#gifJfbox').css('left', winW/2-32/2);
				
				$('#gifJfbox').css({display: 'block'});
				
			}
		}
		
	},	
	
	jfaviso: function (texto, tempo){	/************************************************************	EXTENÃO DE AVISO	*/
		if(typeof tempo == "undefined" && !tempo)
			tempo = 2;
			
		tempo = tempo*1000;
		
		$("#jfAviso").html('<div class="msm">'+texto+'</div>');

		var scrollX = $(window).scrollTop();
		var winW = $(window).width();
		var winH = $(window).height();
		$('#jfAviso .msm').corner(10);			
		
		winW = winW/2-($('#jfAviso').width()+20)/2;
		winH = (winH/2-(($('#jfAviso').height()+40)/2))+scrollX;
		
		$('#jfAviso').css({top: winH, left: winW});
		
		$('#jfAviso').stop(true, true).fadeIn(300, function(){
			
			setTimeout(function(){
				$("#jfAviso").fadeOut(300, function(){
					$('#jfAviso').html('');
				});
			}, tempo);
			
		});				
				
	}
});
		
function fechaJfbox(){
	$('#jfboxMargin').fadeOut(150);
	$('#jfboxFundo').fadeOut(300);
	$('#jfboxLoad').html('');
	return false;
}

function carregaJfbox(load){
	$().jfbox({carrega: load}); 
	return false;
}
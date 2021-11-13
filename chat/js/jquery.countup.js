(function($){
	
	// Número de segundos en cada división de tiempo
	var days	= 24*60*60,
		hours	= 60*60,
		minutes	= 60;
	
	// Creando el plugin
	$.fn.countup = function(prop){
		
		var options = $.extend({
			callback	: function(){},
			start		: new Date()
		},prop);
		
		var passed = 0, d, h, m, s, 
			positions;

		// Inicilizando el plugin
		init(this, options);
		
		positions = this.find('.position');
		
		(function tick(){
			
			passed = Math.floor((new Date() - options.start) / 1000);
			
			//Número de días pasó
			d = Math.floor(passed / days);
			updateDuo(0, 1, d);
			passed -= d*days;
			
			//Número de horas dejó
			h = Math.floor(passed / hours);
			updateDuo(2, 3, h);
			passed -= h*hours;
			
			// Número de minutos para el final
			m = Math.floor(passed / minutes);
			updateDuo(4, 5, m);
			passed -= m*minutes;
			
			// Número de segundos dejó
			s = passed;
			updateDuo(6, 7, s);
			
			// Llamar a una devolución de llamada suministrada por el usuario opcional
			options.callback(d, h, m, s);
			
			//Programación de otra llamada de esta función en 1s
			setTimeout(tick, 1000);
		})();
		
		//Esta función actualiza dos posiciones de dígitos a la vez
		function updateDuo(minor,major,value){
			switchDigit(positions.eq(minor),Math.floor(value/10)%10);
			switchDigit(positions.eq(major),value%10);
		}
		
		return this;
	};


	function init(elem, options){
		elem.addClass('countdownHolder');

		// CREACIÓN el marcado dentro del contenedor
		$.each(['Days','Hours','Minutes','Seconds'],function(i){
			$('<span class="count'+this+'">').html(
				'<span class="position">\
					<span class="digit static">0</span>\
				</span>\
				<span class="position">\
					<span class="digit static">0</span>\
				</span>'
			).appendTo(elem);
			
			if(this!="Seconds"){
				elem.append('<span class="countDiv countDiv'+i+'"></span>');
			}
		});

	}

	// Crea una transición animada entre los dos números
	function switchDigit(position,number){
		
		var digit = position.find('.digit')
		
		if(digit.is(':animated')){
			return false;
		}
		
		if(position.data('digit') == number){
			// Nosotros ya estamos mostrando este número
			return false;
		}
		
		position.data('digit', number);
		
		var replacement = $('<span>',{
			'class':'digit',
			css:{
				top:'-2.1em',
				opacity:0
			},
			html:number
		});
		
		// Se añade la clase .static cuando la animación
		//completa . Esto hace que funcionen mejor.
		
		digit
			.before(replacement)
			.removeClass('static')
			.animate({top:'2.5em',opacity:0},'fast',function(){
				digit.remove();
			})

		replacement
			.delay(100)
			.animate({top:0,opacity:1},'fast',function(){
				replacement.addClass('static');
			});
	}
})(jQuery);
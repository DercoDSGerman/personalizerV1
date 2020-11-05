$(function(){

var form = $("#wizard").show();

	form.steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "fade",
		enableAllSteps: false, 
        labels: {
            finish: "Enviar",
            next: "Siguiente",
            previous: "Volver"
        },
		onStepChanging: function (event, currentIndex, newIndex)
		{
			
			
			// Allways allow previous action even if the current form is not valid!
			if (currentIndex > newIndex)
			{
				return true;
			}
			
			if (currentIndex < newIndex)
			{
				// To remove error styles
				form.find(".body:eq(" + newIndex + ") label.error").remove();
				form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
			}
		
			form.validate().settings.ignore = ":disabled,:hidden";
			console.log(form.valid());
			
			if(form.valid()){
				if(currentIndex == 0){
					$('#wizard-t-1').parent().addClass('checked');
				}else if(currentIndex == 1){
					$('#wizard-t-2').parent().addClass('checked');
				}	
			}
			
			return form.valid();
		},
		onStepChanged: function (event, currentIndex, priorIndex)
		{
			
			console.log("onStepChanged-"+currentIndex+" "+priorIndex);
			if(currentIndex == 0 && priorIndex == 1){
				$('#wizard-t-1').parent().removeClass('checked');
			}else if(currentIndex == 1 && priorIndex == 2){
				$('#wizard-t-2').parent().removeClass('checked');
			}else if(currentIndex == 0 && priorIndex == 2){
				$('#wizard-t-1').parent().removeClass('checked');
				$('#wizard-t-2').parent().removeClass('checked');
			}
			
			
		},
		onFinishing: function (event, currentIndex)
		{
			form.validate().settings.ignore = ":disabled";
			return form.valid();
		},
		onFinished: function (event, currentIndex)
		{
			$(".actions").html('<img src="img/original.gif" style="width: 55px;">');
			enviardata();
			
		}
		
    }).validate({
		errorClass: 'alert-warning',
		debug: true,
		errorPlacement: function errorPlacement(error, element) { element.before(error); },
		rules: {
			"rutx" : { 
                required:true,
				rut:true
            },
			"edad" : { 
                required:true,
				edades:true
            },
			"precio" : { 
                required:true,
				precioS:true
            },
			"segmento" : { 
                required:true
            }
		},
        messages: {
            "rutx" : { 
                required:''
            }, 
			"edad" : { 
                required:''
            },
			"cesX" : { 
                required:''
            },
			"comunaid" : { 
                required:''
            },
			"precio" : { 
                required:''
            }
			,
			"segmento" : { 
                required:''
            }
		}
	});;
    
	 /* $('.wizard > .steps li a').click(function(){
		 console.log(this);
    	$(this).parent().addClass('checked');
		$(this).parent().prevAll().addClass('checked');
		$(this).parent().nextAll().removeClass('checked');
    });  */
		 
    // Custome Jquery Step Button
    $('.Siguiente').click(function(){
    	$("#wizard").steps('next');
    })
    $('.Volver').click(function(){
        $("#wizard").steps('previous');
    })
	
	
    // Select Dropdown
    $('html').click(function() {
        $('.select .dropdown').hide(); 
    });
    $('.select').click(function(event){
        event.stopPropagation();
    });
    $('.select .select-control').click(function(){
        $(this).parent().next().toggle();
    })    
    $('.select .dropdown li').click(function(){
        $(this).parent().toggle();
        var text = $(this).attr('rel');
        $(this).parent().prev().find('div').text(text);
    })
});

function enviardata(){
	var generoX = $('input:radio[name=genero]:checked').val();
						
				$.ajax({
					type: "POST",
					url: "send.php",
					data: { 
						rut: $('#rutx').val(), 
						mant: $('#mant').val(),
						fin: $('#fin').val(),
						seg: $('#seg').val(),
						genero: generoX,
						edad: $('#edad').val(),
						autosmerca: $('#autosmerca').val(),
						precio: $('#precio').val(),
						segmento: $('#segmento').val(),
						pasa: $('#pasa').val(),
						comunaid: $('#comunaid').val(),
						ces: $('#cesX').val(),
						ces_name: $('#cesname').val(),
						ces_sucursal: $('#cessucursal').val()
						},
					success: function(data) {
						$('#wizard-result').html(data);
						$('#wizard').hide();
						$('#wizard-result').show();
						//alert(data);
					},
					error: function() {
						alert('error handling here');
					}
				});
		 }
		 
function enviaReward(valId){
			
	$.ajax({
		type: "POST",
		url: "reward.php",
		data: { 
			uid: valId
			},
		success: function(data) {
			$('#rewardBot').hide(data);
			alert("Muchas gracias por tu feedback!");
		},
		error: function() {
			alert('error handling here');
		}
	});
}
		 
 function backform(){
	$('#wizard').show();
	$('#wizard-result').hide();
	$('#wizard-result').html('');
 }		 

jQuery.validator.addMethod("rut", function(value, element) { 
        return this.optional(element) || validaRut(value); 
}, "");

jQuery.validator.addMethod("edades", function(value, element) { 
        return this.optional(element) || validaEdad(value); 
}, "");

jQuery.validator.addMethod("precioS", function(value, element) { 
        return this.optional(element) || validaPrecio(value); 
}, "");

function validaRut(rut){
        var Fn = {
            // Valida el rut con su cadena completa "XXXXXXXX-X"
            validaRut : function (rutCompleto) {
                rutCompleto = rutCompleto.replace("?","-");
                if (!/^[0-9]+[-|?]{1}[0-9kK]{1}$/.test( rutCompleto ))
                    return false;
                var tmp     = rutCompleto.split('-');
                var digv    = tmp[1]; 
                var rut     = tmp[0];
                if ( digv == 'K' ) digv = 'k' ;

                return (Fn.dv(rut) == digv );
            },
            dv : function(T){
                var M=0,S=1;
                for(;T;T=Math.floor(T/10))
                    S=(S+T%10*(9-M++%6))%11;
                return S?S-1:'k';
            }
        };


	return Fn.validaRut(rut);
}

function validaEdad(edad){
	if(parseInt(edad)>17){
		return true;
	}else{
		return false;
	}
}

function validaPrecio(prec){
	if(parseInt(prec)>3000000){
		return true;
	}else{
		return false;
	}
}

function filtraCes(comuna){
		
		if(comuna!=""){
				$.ajax({
					type: "POST",
					url: "filtraces.php",
					data: { 
						comuna: comuna
						},
					success: function(data) {
						$('#responseCES').html(data);
					},
					error: function() {
						alert('error handling here');
					}
				});
		}
}
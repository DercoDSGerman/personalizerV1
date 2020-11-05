<?php
	include("includes/connect.php");
	include("includes/functions.php");	
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex, nofollow">
<title>Formulario recomendador Derco</title>
<link data-n-head="ssr" rel="icon" type="image/x-icon" href="https://www.dercocenter.cl/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="colorlib.com">

<link rel="stylesheet" href="css/font.css">

<link rel="stylesheet" href="css/style.css">
</head>
<style>
.alert-warning{
	background-color:#f5c9c6;
}

.button {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 11px 30px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

</style>
<body>
<img src="/img/original.gif" style="display:none;">
<div class="wrapper">
<form action="" id="wizard">
<h2></h2> 
<section>
    <div class="inner">
        <div class="image-holder" >
            <img src="img/portada.jpg" style="display:block;margin-left: auto;margin-right: auto; margin-top:20px;">
        </div>
        <div class="form-content">
            <div class="form-header">
                <p style="height:100px;">Ingresa tus datos e intentaremos recomendarte un modelo a tu medida</p>
            </div>
            <p>Ingresa algunos datos personales</p>

            <div class="form-row">
                <div class="form-holder">
                    <label for="rut">RUT</label>
                    <input type="text" placeholder="99999999-X" class="form-control required" autocomplete="off" id="rutx" name="rutx" >
                </div>

                <div class="form-holder">
                    <label for="edad">Edad</label>
                    <input type="number" class="form-control required" id="edad" name="edad" placeholder="0">
                </div>
            </div>

            <div class="form-row">
                <div class="form-holder" style="align-self: flex-end; transform: translateY(4px);">
                    <label for="genero">Genero</label>
                    <div class="checkbox-tick">
                        <label class="masculino">
                            <input type="radio" name="genero" value="M" checked> Masculino<br>
                            <span class="checkmark"></span>
                        </label>
                        <label class="femenino">
                            <input type="radio" name="genero" value="F"> Femenino<br>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-holder">
                    <label for="comuna">Comuna</label>
                    <select id="comunaid" name="comunaid" class="form-control required" onchange="javascript: filtraCes(this.value);">
					<option value="">Seleccionar</option>
					<?php
					$comunas = getComuna();
					
						foreach($comunas as $c){
							?>
							<option value="<?php echo $c; ?>"><?php echo $c; ?></option>
							<?php
						}
					?>
					
					</select>
                </div>
            </div>

        </div>
    </div>
</section>

<h2></h2>
<section>
    <div class="inner">

        <div class="image-holder" >
            <img src="img/portada.jpg" style="display:block;margin-left: auto;margin-right: auto; margin-top:20px;">
        </div>

        <div class="form-content">
           <div class="form-header">
                <p style="height:100px;">Ingresa tus datos e intentaremos recomendarte un modelo a tu medida</p>
            </div>
            <p>Indicanos si te interesan algunos de nuestros servicios</p>

            <div class="form-row">
                <div class="form-holder">
                    <label for="mant">Mantención Dercocenter</label>
                    <select name="mant" id="mant"  class="form-control">
                        <option value="si">SI</option>
                        <option value="no">NO</option>
                    </select>
                </div>

                <div class="form-holder">
                    <label for="seg">Seguro Automotriz</label>
                    <select name="seg" id="seg"  class="form-control">
                        <option value="si">SI</option>
                        <option value="no">NO</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-holder">
                    <label for="fin">Financiamiento</label>
                    <select name="fin" id="fin"  class="form-control">
                        <option value="si">SI</option>
                        <option value="no">NO</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cesX">Sucursal</label>
                    <div id="responseCES">
					<select id="cesX" name="cesX" class="form-control required">
					<option value="">Seleccionar</option>
					</select>
					</div>
                </div>
            </div>
        </div>
    </div>
</section>

<h2></h2>
<section>
    <div class="inner">
        <div class="image-holder">
            <img src="img/portada.jpg" style="display:block;margin-left: auto;margin-right: auto; margin-top:20px;">
        </div>
        <div class="form-content">
            <div class="form-header">
                <p style="height:100px;">Ingresa tus datos e intentaremos recomendarte un modelo a tu medida</p>
            </div>
            <p>Ahora responde las siguientes preguntas</p>
			
            <div class="form-row">
                <div class="form-holder">
                    <label for="autosmerca">¿Cuantos autos has comprado antes?</label>
                    <input type="number" class="form-control" id="autosmerca" name="autosmerca" placeholder="0">
                </div>
            
                <div class="form-holder">
                    <label for="precio">¿Cual es tu presupuesto para un nuevo auto?</label>
                    <input type="number" class="form-control required" id="precio" name="precio" placeholder="4000000">
                </div>
                  
            </div>

            <div class="form-row">
				<div class="form-group">
                    <label for="pasa">¿Cuantos pasajeros quieres llevar?</label>
                    <select id="pasa" name="pasa" class="form-control required">
						<option value="1">1 pasajero</option>
						<option value="2">2 pasajeros</option>
						<option value="3">3 pasajeros</option>
						<option value="4">4 pasajeros</option>
						<option value="5">5 pasajeros</option>
						<option value="5">6 o más pasajeros</option>
					</select>
                </div>
                <div class="form-group">
                    <label for="segmento">¿Que categoría de vehículo buscas?</label>
                    <select id="segmento" name="segmento" class="form-control required">
						<option value="">Seleccionar</option>
						<option value="HATCHBACK">Hatchback</option>
						<option value="SEDAN">Sedán</option>
						<option value="SUV">SUV</option>
						<option value="STATION WAGON">Station Wagon</option>
						<option value="PICK UP">Camioneta Pick Up</option>
						<option value="SPORT">Deportivo</option>
						<option value="CARGO">Cargo</option>
						<option value="PASS VAN">Van Pasajeros</option>
						<option value="TRUCK">Camiones</option>
					</select>
                </div>
            </div>

        </div>
    </div>
</section>

</form>
<form action="" id="wizard-result" style="display:none;">
</form>


</div>

<script src="https://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.js" type="text/javascript"></script>
<script src="js/main.js?v=<?php echo uniqid(); ?>" type="text/javascript"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-174009573-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-174009573-1');
</script>

<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="773a004c48289b0c60559f78-|49" defer=""></script></body>
</html>

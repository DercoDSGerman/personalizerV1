<?php
ini_set('display_errors',true);
	include("includes/connect.php");
	include("includes/functions.php");	


 
 $clster[0] = 'JOVEN INFORMADO';
 $clster[9] = 'JOVEN INFORMADO';
 $clster[6] = 'INDEPENDIENTE ACTIVA';
 $clster[5] = 'OBLIGADA ACOMODADA';
 $clster[4] = 'PADRE DE FAMILIA';
 $clster[2] = 'MADRE DE FAMILIA';
 $clster[7] = 'MADRE DE FAMILIA';
 $clster[1] = 'HECTOR TRADICIONAL';
 $clster[3] = 'HECTOR TRADICIONAL';
 $clster[8] = 'TRABAJADOR ESFORZADO';
 $clster[10] = 'CAR LOVER';
 $clster[11] = 'PROVINCIA';
 


 
			$url = 'http://2e9a764c-1490-4996-9e6c-486e81da6f95.eastus.azurecontainer.io/score';
			
			$ch = curl_init($url);
			$mant  = $_POST['mant'];
			$fin  = $_POST['fin'];
			$seg  = $_POST['seg'];
			$segmento  = $_POST['segmento'];
			$pasajeros  = $_POST['pasa'];
			
			$idces  = $_POST['ces'];
			$dataCes = getCESEspecifico($idces);
			$ces_sucursal  = $dataCes['sucursal_nombre'];
			$ces = $dataCes['concesionario'];
			
			$genero  = $_POST['genero'];
			$comuna  = $_POST['comunaid'];
			$precio  = $_POST['precio'];
			
			$segmento = getSegmentoOkApi($segmento, $pasajeros);
		
			$rut_limpio = explode("-",$_POST['rut']);
			
			$data['data'][] = array(
				"p_numero_unico_x" => str_replace(".","",$rut_limpio[0]),
				"Asiste Mantencion" => $mant,
				"Cantidad Autos Mercado" => intval($_POST['autosmerca']),
				"Cliente Financiamiento" => $fin,
				"Cliente Seguros" => $seg,
				"comuna" => $comuna,
				"region" => intval($_POST['comunaid']),
				"SEGMENTO_SUB" => $segmento ,
				"Concesionario" => $ces,
				"sucursal" => $ces_sucursal,
				"auc_precio_venta" => intval($precio),
				"genero_final" => $genero,
				"EdadCalculo" => intval($_POST['edad'])
			);
			
			
			
			$payload = json_encode($data);
			
			curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

			$headers[] = "Content-Type:application/json";//;charset=UTF-8

			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$result = curl_exec($ch);
			$doc = json_decode($result, true);
			$obj = json_decode($doc)->{'result'};
			curl_close($ch);
		
		/////////////////////////////////////////////////////
		
			$gen=0;
				if($genero == 'M'){
					$gen = 1;
				}
				 
				
				if(intval($_POST['edad']) >= 9 && intval($_POST['edad']) <= 25){
					//z
					$generacion = 3;
				}else if(intval($_POST['edad']) >= 26 && intval($_POST['edad']) <= 38){
					//y
					$generacion = 2;
				}else if(intval($_POST['edad']) >= 39 && intval($_POST['edad']) <= 50){
					//x
					$generacion = 1;
				}else if(intval($_POST['edad']) >= 51 && intval($_POST['edad']) <= 70){
					//boomer
					$generacion = 0;
				}else if(intval($_POST['edad']) >= 71 && intval($_POST['edad']) <= 89){
					//silent
					$generacion = 4;
				}
			
			$lista_dc = getCars();	
			$x=0;			
			foreach($lista_dc as $car){
				
				$cars['actions'][$x]['id'] = $car['id'];
				if($car['precio']>0){
					$cars['actions'][$x]['features'][] = array('brand'=>$car['marca'],'model'=>$car['modelo'],'price'=>$car['precio']);
				}else{
					$cars['actions'][$x]['features'][] = array('brand'=>$car['marca'],'model'=>$car['modelo']);
				}
				
			
				
				$x++;
			}

			$cars['contextFeatures'][] = array("COMUNA_CLIENTE"=>strtoupper($comuna),"Distancia_km"=>2.0,"EDAD"=> intval($_POST['edad']),"GENERO"=> $gen,"Generacion"=>$generacion,"Label_12"=>$obj[0]);
			$cars['deferActivation'] = false;
			$cars['eventId'] = uniqid();//"b71f1e3c5ec3481b99577ce8db6e84b4";
			$cars['excludedActions'] = array();
			/* $cars['excludedActions'][0]['id'] = 'MAZDA-MAZDA CX-7';
			$cars['excludedActions'][0]['features'][] = array('brand'=>'MAZDA','model'=>'MAZDA CX-7');
	 */
			$respuest = callPro($cars);
			
		
		////////////////////////////////////////////////////


function callPro($data){
	
	$url = 'https://slpersonalizer.cognitiveservices.azure.com/personalizer/v1.0/rank';
	$ch = curl_init($url);
	$payload = json_encode($data);
	/* echo '<pre>';
			print_r($payload);
			echo '</pre>'; */

	
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

	$headers[] = "Content-Type:application/json";
	$headers[] = "Ocp-Apim-Subscription-Key: 2ba5d008ec10447081b89ffd435c66fc";
	

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	$doc = json_decode($result, true);
	curl_close($ch);
	
	return $doc; 
			
}								
		

//echo $respuest['ranking'][0]['id'];
$inforGraph = getImageModel($respuest['ranking'][0]['id']);
/* echo $inforGraph['image'];
echo $inforGraph['urlderco']; */

if(strlen($respuest['ranking'][0]['id'])>0){
	$consulta_lista = "INSERT INTO intentos (id, rut, edad, genero, comuna, region, mantencion, seguro, financia, autosmerca, presupuesto, pasajeros, categoria, cluster,  propuesta, id_peticion, megusta, created_at) VALUES 
	(NULL, '".str_replace(".","",$rut_limpio[0])."', '".intval($_POST['edad'])."', '".$genero."', '".$comuna."', '".intval($_POST['comunaid'])."', '".$mant."', '".$seg."', '".$fin."', '".intval($_POST['autosmerca'])."', '".intval($precio)."', '".$pasajeros."', '".$segmento."', '".$obj[0]."', '".$respuest['ranking'][0]['id']."', '".$cars['eventId']."', 'FALSE', current_timestamp());";
	//echo $consulta_lista;
	$stmt = $pdo->prepare($consulta_lista);
	$stmt->execute();
}
		
?>

<section><div class="inner">
<div class="image-holder"><img src="img/portada.jpg" style="display:block;margin-left: auto;margin-right: auto; margin-top:20px;"></div>
<div class="form-content"><div class="form-header">
<p style="height:60px;">¡Muchas gracias por usar nuestro recomendador!,</br>Te recomendamos: <b><?php echo str_replace("-"," ",$respuest['ranking'][0]['id']); ?></b></p>
</div>
<div class="form-row">
<table style="width: 100%;text-align:center;">
<tr>
<td><a href="<?php echo $inforGraph['urlderco']; ?>" target="_blank"><img src="<?php echo $inforGraph['image']; ?>" style="width: 300px;"></a></td>
</tr>
<tr>
<td>¿Te gusta nuestra propuesta? <button type="button" class="button" id="rewardBot" onclick="enviaReward('<?php echo $cars['eventId']; ?>')">Si Me encanta!</button></td>
</tr>
<tr>
<td></br></td>
</tr>
<tr>
<td>
<a href="/" style="margin-top:20px;">Me gustaría probar nuevamente</a>
</td>
</tr>
</table>
</div>
</div>
</div>
</section>



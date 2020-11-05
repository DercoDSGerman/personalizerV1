<?php


	function callReward($uid){
		$data['value'] = 1;
		$url = 'https://slpersonalizer.cognitiveservices.azure.com/personalizer/v1.0/events/'.$uid.'/reward';
		echo $url;
		$ch = curl_init($url);
		$payload = json_encode($data);
		echo '<pre>';
		print_r($payload);
		echo '</pre>';

		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

		$headers[] = "Content-Type:application/json";
		$headers[] = "Ocp-Apim-Subscription-Key: 2ba5d008ec10447081b89ffd435c66fc";
		

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);
		
		$response = false;
		
		if (!curl_errno($ch)) {
		  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		  echo $http_code.'***';
		  if($http_code == 204){
			  $response = true;
		  }
		}
		
		curl_close($ch);
		
		return $response; 
				
	}	

	function getComuna (){
		global $pdo;
		$arResp = array();
		$query = "SELECT comuna FROM `sucursales` GROUP by comuna order by comuna"; 
		$stmt0 = $pdo->query($query);
		while ($row = $stmt0->fetch()) {
			$arResp[$row['comuna']] = $row['comuna'];
		}
		return $arResp; 
	}
	
	function getCes ($comuna){
		global $pdo;
		$arResp = array();
		$query = "select * from`sucursales` where comuna like '".$comuna."' order by concesionario"; 
		$stmt0 = $pdo->query($query);
		while ($row = $stmt0->fetch()) {
			$arResp[$row['id']] = $row['concesionario'].' '.str_replace("Dercocenter ","",$row['sucursal_nombre']);
		}
		return $arResp; 
	}
	
	function getSegmento (){
		global $pdo;
		$arResp = array();
		$query = "select segmento_sub from personalizar_segmentos group by segmento_sub order by segmento_sub"; 
		$stmt0 = $pdo->query($query);
		while ($row = $stmt0->fetch()) {
			$arResp[] = '{"value": "'.$row['segmento_sub'].'","label": "'.$row['segmento_sub'].'","desc": "'.$row['segmento_sub'].'"}';
		}
		return $arResp; 
	}
	
	function getCESEspecifico($IdCes){
		global $pdo;
		$consulta = "select * from `sucursales` where id = ".$IdCes." limit 1";
		$stmt2 = $pdo->prepare($consulta);
		$stmt2->execute();
		$row = $stmt2->fetch();
		
		return $row; 
	}
	
	function getCars (){
		/* global $pdo;
		$arResp = array();
		$query = "select * from personalizar_cars where marca in ('Mazda','Renault','Suzuki') limit 45"; 
		$stmt0 = $pdo->query($query);
		while ($row = $stmt0->fetch()) {
			$arResp[$row['id']]['marca'] = $row['marca'];
			$arResp[$row['id']]['modelo'] = $row['modelo'].'-'.$row['version'];
			$arResp[$row['id']]['precio'] = $row['precio'];
		} */
		
		$var = array (
					  'actions' => 
					  array (
						0 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'RENAULT',
							  'model' => 'SYMBOL',
							  'price' => 8801111,
							),
						  ),
						  'id' => 'RENAULT-SYMBOL',
						),
						1 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'SUZUKI',
							  'model' => 'CIAZ',
							  'price' => 10865000,
							),
						  ),
						  'id' => 'SUZUKI-CIAZ',
						),
						2 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'SUZUKI',
							  'model' => 'SWIFT',
							  'price' => 12140000,
							),
						  ),
						  'id' => 'SUZUKI-SWIFT',
						),
						3 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'SUZUKI',
							  'model' => 'BALENO',
							  'price' => 10068571,
							),
						  ),
						  'id' => 'SUZUKI-BALENO',
						),
						4 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'JAC',
							  'model' => 'S3',
							  'price' => 10523333,
							),
						  ),
						  'id' => 'JAC-S3',
						),
						5 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'MAZDA',
							  'model' => 'MAZDA CX-5',
							  'price' => 21840000,
							),
						  ),
						  'id' => 'MAZDA-MAZDA CX-5',
						),
						6 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'MAZDA',
							  'model' => 'MAZDA CX-9',
							  'price' => 29975714,
							),
						  ),
						  'id' => 'MAZDA-MAZDA CX-9',
						),
						7 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'GREAT WALL',
							  'model' => 'FLORID',
							),
						  ),
						  'id' => 'GREAT WALL-FLORID',
						),
						8 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'SUZUKI',
							  'model' => 'ALTO',
							  'price' => 5956666,
							),
						  ),
						  'id' => 'SUZUKI-ALTO',
						),
						9 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'JAC',
							  'model' => 'T6',
							  'price' => 12407600,
							),
						  ),
						  'id' => 'JAC-T6',
						),
						10 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'JAC',
							  'model' => 'S5',
							),
						  ),
						  'id' => 'JAC-S5',
						),
						11 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'JAC',
							  'model' => 'J5',
							),
						  ),
						  'id' => 'JAC-J5',
						),
						12 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'JAC',
							  'model' => 'J6',
							),
						  ),
						  'id' => 'JAC-J6',
						),
						13 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'RENAULT',
							  'model' => 'OROCH',
							  'price' => 12935300,
							),
						  ),
						  'id' => 'RENAULT-OROCH',
						),
						14 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'MAZDA',
							  'model' => 'MAZDA CX-7',
							),
						  ),
						  'id' => 'MAZDA-MAZDA CX-7',
						),
						15 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'MAZDA',
							  'model' => 'MAZDA 2',
							),
						  ),
						  'id' => 'MAZDA-MAZDA 2',
						),
						16 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'GREAT WALL',
							  'model' => 'GREAT WALL 6',
							  'price' => 11890000,
							),
						  ),
						  'id' => 'GREAT WALL-GREAT WALL 6',
						),
						17 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'RENAULT',
							  'model' => 'KANGOO',
							),
						  ),
						  'id' => 'RENAULT-KANGOO',
						),
						18 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'RENAULT',
							  'model' => 'LAGUNA III',
							),
						  ),
						  'id' => 'RENAULT-LAGUNA III',
						),
						19 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'RENAULT',
							  'model' => 'MEGANE RS',
							  'price' => 28415000,
							),
						  ),
						  'id' => 'RENAULT-MEGANE RS',
						),
						20 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'SUZUKI',
							  'model' => 'APV FURGON',
							),
						  ),
						  'id' => 'SUZUKI-APV FURGON',
						),
						21 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'MAZDA',
							  'model' => 'MAZDA 3',
							),
						  ),
						  'id' => 'MAZDA-MAZDA 3',
						),
						22 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'SUZUKI',
							  'model' => 'APV PICK UP',
							),
						  ),
						  'id' => 'SUZUKI-APV PICK UP',
						),
						23 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'JAC',
							  'model' => 'REIN',
							),
						  ),
						  'id' => 'JAC-REIN',
						),
						24 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'RENAULT',
							  'model' => 'NEW MEGANE RS',
							),
						  ),
						  'id' => 'RENAULT-NEW MEGANE RS',
						),
						25 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'RENAULT',
							  'model' => 'DUSTER',
							  'price' => 11630000,
							),
						  ),
						  'id' => 'RENAULT-DUSTER',
						),
						26 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'MAZDA',
							  'model' => 'MAZDA 5',
							),
						  ),
						  'id' => 'MAZDA-MAZDA 5',
						),
						27 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'MAZDA',
							  'model' => 'MAZDA BT-50',
							  'price' => 22001600,
							),
						  ),
						  'id' => 'MAZDA-MAZDA BT-50',
						),
						28 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'JAC',
							  'model' => 'T8',
							  'price' => 16447225,
							),
						  ),
						  'id' => 'JAC-T8',
						),
						29 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'JAC',
							  'model' => 'SUNRAY',
							  'price' => 27707009,
							),
						  ),
						  'id' => 'JAC-SUNRAY',
						),
						30 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'SUZUKI',
							  'model' => 'ALTO 800',
							  'price' => 5456666,
							),
						  ),
						  'id' => 'SUZUKI-ALTO 800',
						),
						31 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'RENAULT',
							  'model' => 'FLUENCE',
							),
						  ),
						  'id' => 'RENAULT-FLUENCE',
						),
						32 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'RENAULT',
							  'model' => 'SANDERO',
							),
						  ),
						  'id' => 'RENAULT-SANDERO',
						),
						33 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'JAC',
							  'model' => 'S1',
							),
						  ),
						  'id' => 'JAC-S1',
						),
						34 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'SUZUKI',
							  'model' => 'CELERIO',
							  'price' => 7815000,
							),
						  ),
						  'id' => 'SUZUKI-CELERIO',
						),
						35 => 
						array (
						  'features' => 
						  array (
							0 => 
							array (
							  'brand' => 'RENAULT',
							  'model' => 'LATITUDE',
							),
						  ),
						  'id' => 'RENAULT-LATITUDE',
						),
					  ),
					);
	
					$xx=0;
					foreach($var['actions'] as $row){
							$arResp[$xx]['marca'] = $row['features'][0]['brand'];
							$arResp[$xx]['modelo'] = $row['features'][0]['model'];
							$arResp[$xx]['id'] = $row['id'];
							if(isset($row['features'][0]['price'])){
								$arResp[$xx]['precio'] = $row['features'][0]['price'];
							}else{
								$arResp[$xx]['precio'] = 0;
							}							
					$xx++;		
					}
		return $arResp; 
	}
	
	function getImageModel($index){
		
		$arrayImg['RENAULT-SYMBOL']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/8/2019/10/renault-symbol-destacado-color-1.jpg';
		$arrayImg['RENAULT-SYMBOL']['urlderco'] = 'https://www.dercocenter.cl/auto/renault/symbol';
		$arrayImg['SUZUKI-CIAZ']['image']  = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/7/2018/07/ciaz-id-69.jpg';
		$arrayImg['SUZUKI-CIAZ']['urlderco'] = 'https://www.dercocenter.cl/auto/suzuki/ciaz';
		$arrayImg['SUZUKI-SWIFT']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/7/2018/07/nuevo-swift-id-431.jpg';
		$arrayImg['SUZUKI-SWIFT']['urlderco'] = 'https://www.dercocenter.cl/auto/suzuki/nuevo-swift';
		$arrayImg['SUZUKI-BALENO']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/7/2020/01/BALENO-1.4-GLS-PLATA-PREMIUM.png';
		$arrayImg['SUZUKI-BALENO']['urlderco'] = 'https://www.dercocenter.cl/auto/suzuki/baleno';
		$arrayImg['JAC-S3']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/5/2018/07/New-S3-id-383.jpg.png';
		$arrayImg['JAC-S3']['urlderco'] = 'https://www.dercocenter.cl/auto/jac/new-s3';
		$arrayImg['MAZDA-MAZDA CX-5']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/9/2019/07/KN5GLAQ-1.jpg';
		$arrayImg['MAZDA-MAZDA CX-5']['urlderco'] = 'https://www.dercocenter.cl/auto/mazda/new-mazda-cx-5';
		$arrayImg['MAZDA-MAZDA CX-9']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/9/2019/07/TN55LBE-1.jpg';
		$arrayImg['MAZDA-MAZDA CX-9']['urlderco'] = 'https://www.dercocenter.cl/auto/mazda/new-mazda-cx-9';
		$arrayImg['GREAT WALL-FLORID']['image'] = '';
		$arrayImg['GREAT WALL-FLORID']['urlderco'] = '';
		$arrayImg['SUZUKI-ALTO']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/7/2019/09/GLX480x320px.jpg';
		$arrayImg['SUZUKI-ALTO']['urlderco'] = 'https://www.dercocenter.cl/auto/suzuki/nuevo-alto-800';
		$arrayImg['JAC-T6']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/5/2018/07/T6-Diesel-id-495.jpg.png';
		$arrayImg['JAC-T6']['urlderco'] = 'https://www.dercocenter.cl/auto/jac/t6-diesel';
		$arrayImg['RENAULT-OROCH']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/2019/10/renault-destacado-OROCH-ZEN-NAV-1-6-MT.png';
		$arrayImg['RENAULT-OROCH']['urlderco'] = 'https://www.dercocenter.cl/auto/renault/oroch';
		$arrayImg['MAZDA-MAZDA CX-7']['image'] = '';
		$arrayImg['MAZDA-MAZDA CX-7']['urlderco'] = '';
		$arrayImg['MAZDA-MAZDA 2']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/9/2020/06/Mazda2-Sport-Gris-ajustado-web.jpg';
		$arrayImg['MAZDA-MAZDA 2']['urlderco'] = 'https://www.dercocenter.cl/auto/mazda/mazda2-sport';
		$arrayImg['GREAT WALL-GREAT WALL 6']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/3/2018/07/Wingle-6-Bencina-id-202.jpg.png';
		$arrayImg['GREAT WALL-GREAT WALL 6']['urlderco'] = 'https://www.dercocenter.cl/auto/great-wall/wingle-6-gasolina-doble-cabina';
		$arrayImg['RENAULT-KANGOO']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/2020/07/destacado-kangoo-ze.jpg';
		$arrayImg['RENAULT-KANGOO']['urlderco'] = 'https://www.renault.cl/auto/kangoo-ze';
		$arrayImg['RENAULT-LAGUNA III']['image'] = '';
		$arrayImg['RENAULT-LAGUNA III']['urlderco'] = '';
		$arrayImg['RENAULT-MEGANE RS']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/2018/11/megane-rs-destacado-6.png'; //
		$arrayImg['RENAULT-MEGANE RS']['urlderco'] = 'https://www.dercocenter.cl/auto/renault/nuevo-megane-rs';
		$arrayImg['SUZUKI-APV FURGON']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/7/2017/07/apv-furgon-comercial.jpg';
		$arrayImg['SUZUKI-APV FURGON']['urlderco'] = 'https://www.dercocenter.cl/auto/suzuki/apv-1-6-furgon';
		$arrayImg['MAZDA-MAZDA 3']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/9/2019/07/BCSFLAB.jpg';
		$arrayImg['MAZDA-MAZDA 3']['urlderco'] = 'https://www.dercocenter.cl/auto/mazda/all-new-mazda3-sport';
		$arrayImg['SUZUKI-APV PICK UP']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/2020/04/nuevo-carry-destacado-version.png';//
		$arrayImg['SUZUKI-APV PICK UP']['urlderco'] = 'https://www.dercocenter.cl/auto/suzuki/nuevo-carry-pick-up';
		$arrayImg['RENAULT-NEW MEGANE RS']['image'] =  'https://s3.amazonaws.com/dercocenter.cl/uploads/2018/11/megane-rs-destacado-6.png';
		$arrayImg['RENAULT-NEW MEGANE RS']['urlderco'] = 'https://www.dercocenter.cl/auto/renault/nuevo-megane-rs';
		$arrayImg['RENAULT-DUSTER']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/2019/10/renault-destacado-DUSTER-LIFE-1-6-MT.png';
		$arrayImg['RENAULT-DUSTER']['urlderco'] = 'https://www.dercocenter.cl/auto/renault/duster';
		$arrayImg['MAZDA-MAZDA 5']['image'] = '';
		$arrayImg['MAZDA-MAZDA 5']['urlderco'] = '';
		$arrayImg['MAZDA-MAZDA BT-50']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/9/2019/07/UL7GLAD-1.jpg';
		$arrayImg['MAZDA-MAZDA BT-50']['urlderco'] = 'https://www.dercocenter.cl/auto/mazda/mazda-bt-50';
		$arrayImg['JAC-T8']['image']['urlderco'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/5/2019/08/jac-t8-destacado-4.jpg';
		$arrayImg['JAC-T8']['urlderco'] = 'https://www.dercocenter.cl/auto/jac/t8';
		$arrayImg['JAC-SUNRAY']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/5/2018/07/New-Sunray-id-514.jpg-1.png';
		$arrayImg['JAC-SUNRAY']['urlderco'] = 'https://www.dercocenter.cl/auto/jac/sunray-pasajeros';
		$arrayImg['SUZUKI-ALTO 800']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/7/2019/09/GLX480x320px.jpg';
		$arrayImg['SUZUKI-ALTO 800']['urlderco'] = 'https://www.dercocenter.cl/auto/suzuki/nuevo-alto-800';
		$arrayImg['RENAULT-FLUENCE']['image'] = '';
		$arrayImg['RENAULT-FLUENCE']['urlderco'] = '';
		$arrayImg['RENAULT-SANDERO']['image'] = '';
		$arrayImg['RENAULT-SANDERO']['urlderco'] = '';
		$arrayImg['SUZUKI-CELERIO']['image'] = 'https://s3.amazonaws.com/dercocenter.cl/uploads/sites/7/2018/07/celerio-id-60.jpg';
		$arrayImg['SUZUKI-CELERIO']['urlderco'] = 'https://www.dercocenter.cl/auto/suzuki/celerio';
		$arrayImg['RENAULT-LATITUDE']['image'] = '';
		$arrayImg['RENAULT-LATITUDE']['urlderco'] = '';
		
		return $arrayImg[$index];
		
	}


function getSegmentoOkApi($segmento, $pasajeros){
	if($segmento == "HATCHBACK"){
				switch ($pasajeros) {
					case 1:
						$segmento .= ' A';
						break;
					case 2:
						$segmento .= ' A';
						break;
					case 3:
						$segmento .= ' B';
						break;
					case 4:
						$segmento .= ' C';
						break;
					case 5:
						$segmento .= ' C';
						break;
					case 6:
						$segmento .= ' D';
						break;
				}				
			}else
			if($segmento == "SEDAN"){
				switch ($pasajeros) {
					case 1:
						$segmento .= ' B';
						break;
					case 2:
						$segmento .= ' B';
						break;
					case 3:
						$segmento .= ' C';
						break;
					case 4:
						$segmento .= ' D';
						break;
					case 5:
						$segmento .= ' D';
						break;
					case 6:
						$segmento .= ' D';
						break;
				}	
			}else
			if($segmento == "SUV"){
				switch ($pasajeros) {
					case 1:
						$segmento .= ' B';
						break;
					case 2:
						$segmento .= ' B';
						break;
					case 3:
						$segmento .= ' C';
						break;
					case 4:
						$segmento .= ' D';
						break;
					case 5:
						$segmento .= ' D';
						break;
					case 6:
						$segmento .= ' D';
						break;
				}	
			}else
			if($segmento =="STATION WAGON"){
				switch ($pasajeros) {
					case 1:
						$segmento .= ' A';
						break;
					case 2:
						$segmento .= ' A';
						break;
					case 3:
						$segmento .= ' B';
						break;
					case 4:
						$segmento .= ' B';
						break;
					case 5:
						$segmento .= ' D';
						break;
					case 6:
						$segmento .= ' D';
						break;
				}	
			}else
			if($segmento =="PICK UP"){
				switch ($pasajeros) {
					case 1:
						$segmento .= ' B';
						break;
					case 2:
						$segmento .= ' B';
						break;
					case 3:
						$segmento .= ' B';
						break;
					case 4:
						$segmento .= ' C';
						break;
					case 5:
						$segmento .= ' C';
						break;
					case 6:
						$segmento .= ' C';
						break;
				}	
			}else
			if($segmento =="SPORT"){
				switch ($pasajeros) {
					case 1:
						$segmento .= ' OTRO';
						break;
					case 2:
						$segmento .= ' C';
						break;
					case 3:
						$segmento .= ' C';
						break;
					case 4:
						$segmento .= ' C';
						break;
					case 5:
						$segmento .= ' C';
						break;
					case 6:
						$segmento .= ' C';
						break;
				}	
			}else
			if($segmento =="CARGO"){
				switch ($pasajeros) {
					case 1:
						$segmento .= ' A';
						break;
					case 2:
						$segmento .= ' A';
						break;
					case 3:
						$segmento .= ' B';
						break;
					case 4:
						$segmento .= ' D';
						break;
					case 5:
						$segmento .= ' D';
						break;
					case 6:
						$segmento .= ' D';
						break;
				}	
			}else
			if($segmento =="PASS VAN"){
				switch ($pasajeros) {
					case 1:
						$segmento .= ' A';
						break;
					case 2:
						$segmento .= ' A';
						break;
					case 3:
						$segmento .= ' A';
						break;
					case 4:
						$segmento .= ' A';
						break;
					case 5:
						$segmento .= ' C';
						break;
					case 6:
						$segmento .= ' D';
						break;
				}	
			}else
			if($segmento =="TRUCK"){
				switch ($pasajeros) {
					case 1:
						$segmento .= ' A';
						break;
					case 2:
						$segmento .= ' A';
						break;
					case 3:
						$segmento .= ' A';
						break;
					case 4:
						$segmento .= ' A';
						break;
					case 5:
						$segmento .= ' A';
						break;
					case 6:
						$segmento .= ' A';
						break;
				}	
			}
	return $segmento;
}
?>
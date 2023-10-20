<?php 


class GPXParser {

	/**
	 * @param string @gpx_file Path to GPX file
	 */
	public static function parse($gpx_path) {
		$gpx = file_get_contents($gpx_path); 

		// xml parser : 
		$xml = simplexml_load_string($gpx, "SimpleXMLElement", LIBXML_NOCDATA); 
		// Depuis un fichier on devrait pouvoir utiliser `simplexml_load_file()` 
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);

		$collection_of_points = $array['trk']['trkseg']['trkpt']; 

		// get distance : 
		$array_of_points = []; 
		foreach($collection_of_points as $point) {
			$array_of_points[] = [
				$point['@attributes']['lat'], 
				$point['@attributes']['lon']
			]; 
		}
		$distance = GPXParser::calculate_distance($array_of_points); 


		// get elevation : 
		$elevations_points = []; 
		foreach($collection_of_points as $point) {
			$elevations_points[] = $point['ele']; 
		}
		$denivele = GPXParser::calculate_elevation($elevations_points); 



		// get department of midpoint : ...TO DO
		$nb = count($array_of_points);
		$midpoint_index = (int)($nb/2); 
		echo $midpoint_index; 
		$list_depts[] = GPXParser::identifyDepartmentForCoord($array_of_points[$midpoint_index][0], $array_of_points[$midpoint_index][1]); 
		print_r($list_depts); 


		return [
			'distance' => [
				"value" => $distance, 
				"unit" => "km"
			],
			'elevation' => [
				"value" => $denivele, 
				"unit" => "m"
			]
		]; 
	}






	/**
	 * Calcule la distance en km entre deux coordonnées GPX
	 */
	private static function haversine($lat1, $lon1, $lat2, $lon2) {
		$lat1 = deg2rad($lat1);
		$lon1 = deg2rad($lon1);
		$lat2 = deg2rad($lat2);
		$lon2 = deg2rad($lon2);

		$dlat = $lat2 - $lat1;
		$dlon = $lon2 - $lon1;

		$a = sin($dlat/2)**2 + cos($lat1) * cos($lat2) * sin($dlon/2)**2;
		$c = 2 * atan2(sqrt($a), sqrt(1-$a));
		$R = 6371;  // Rayon moyen de la Terre en kilomètres

		$distance = $R * $c;
		return $distance;
	}


	/**
	 * Calcule la distance totale en km d'une collection de points GPS
	 * 
	 * @param coordonnates[] $array_of_coord Une collection de points au format [lat, lon]
	 */
	public static function calculate_distance($array_of_coord) {
		$total = 0; 
		$number_of_points = count($array_of_coord); 

		for ($i = 0; $i < $number_of_points-1; $i++) {
			$lat1 = $array_of_coord[$i][0];
			$lon1 = $array_of_coord[$i][1];
			$lat2 = $array_of_coord[$i+1][0];
			$lon2 = $array_of_coord[$i+1][1];

			$total += GPXParser::haversine($lat1, $lon1, $lat2, $lon2);
		}

		return number_format($total, 3); 
	}



	/**
	 * Calcule le dénivelé positif en m d'une collection d'altitudes
	 */
	public static function calculate_elevation($array_of_elevation) {
		$total = 0; 
		$number_of_points = count($array_of_elevation); 

		for ($i = 1; $i < $number_of_points; $i++) {
			$a = (int)$array_of_elevation[$i]; 
			$b = (int)$array_of_elevation[$i-1]; 
			if ($a > $b) {
				$total += $a - $b; 
			}
		}
		return $total; 
	}


	/**
	 * Permet de récupérer une liste des numéros de départements traversés par la trace
	 */
	public static function identifyDepartmentForCoord($lat, $lon) {
		$result = file_get_contents("https://wxs.ign.fr/essentiels/geoportail/geocodage/rest/0.1/search?q=1&lat=$lat&lon=$lon&limit=1"); 
		$array = json_decode($result, true); 
		// print_r($array); 

		$postcode = $array['features'][0]['properties']['postcode']; 
		return number_format($postcode/1000, 0); 


		// $curl = curl_init();
		// curl_setopt_array($curl, [
		// CURLOPT_URL => "https://wxs.ign.fr/essentiels/geoportail/geocodage/rest/0.1/search?q=1&lat=48.710308&lon=2.675025&limit=1",
		// CURLOPT_RETURNTRANSFER => true,
		// CURLOPT_ENCODING => "",
		// CURLOPT_MAXREDIRS => 10,
		// CURLOPT_TIMEOUT => 30,
		// CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		// CURLOPT_CUSTOMREQUEST => "GET"
		// ]);

		// $response = curl_exec($curl);
		// $err = curl_error($curl);

		// curl_close($curl);

		// if ($err) {
		// echo "cURL Error #:" . $err;
		// } else {
		// echo $response;
		// }

		// print_r($array); 
	}
}


<?php 


class GPXParser {
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

		return $total; 
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
}

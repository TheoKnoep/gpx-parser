<?php
require 'utils.php'; 

// mock up data : 
// $gpx = file_get_contents('gpx-files/sample.gpx'); 
$gpx = file_get_contents('gpx-files/les-25bosses.gpx'); 



// xml parser : 
$xml = simplexml_load_string($gpx, "SimpleXMLElement", LIBXML_NOCDATA); 
/** Depuis un fichier on devrait pouvoir utiliser `simplexml_load_file()` */
$json = json_encode($xml);
$array = json_decode($json,TRUE);

echo '<pre>'; 
// print_r($array['trk']['trkseg']['trkpt']); 

$collection_of_points = $array['trk']['trkseg']['trkpt']; 


$array_of_points = []; 
foreach($collection_of_points as $point) {
	$array_of_points[] = [
		$point['@attributes']['lat'], 
		$point['@attributes']['lon']
	]; 
}

// display distance : 
$distance = GPXParser::calculate_distance($array_of_points); 




$elevations = []; 
foreach($collection_of_points as $point) {
	$elevations[] = $point['ele']; 
}
// print_r($elevations); 
$denivele = GPXParser::calculate_elevation($elevations); 


echo "La distance est de $distance km et le dénivelé + est de $denivele m"; 

<?php
require 'gpx-parser.php'; 

// mock up data : 
echo '<pre>'; 

$paths = [
	'gpx-files/Petit-Ballon-et-Platzerwassel.gpx',
	'gpx-files/sample.gpx', 
	'gpx-files/carnelle.gpx', 
	'gpx-files/les-25bosses.gpx'
]; 

foreach($paths as $path) {
	$gpx_data = GPXParser::parse($path); 

	echo "$path : "; 
	print_r($gpx_data); 
}; 








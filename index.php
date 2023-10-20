<?php
require 'gpx-parser.php'; 

// mock up data : 
echo '<pre>'; 

// $path = 'gpx-files/sample.gpx'; 
$path = 'gpx-files/carnelle.gpx'; 

$gpx_data = GPXParser::parse($path); 

print_r($gpx_data); 

// GPXParser::identifyDepartmentForCoord("48.710308","2.675025"); 




<?php
require 'gpx-parser.php'; 

// mock up data : 
echo '<pre>'; 

$gpx_data = GPXParser::parse('gpx-files/sample.gpx'); 

print_r($gpx_data); 


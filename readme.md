# Description 

Projet de back-office pour analyser un fichier GPX et extraire des données diverses comme par exemple : 

- distance
- dénivelé
- score de difficulté
- adresse de départ 
- départements traversés [TO DO]
- boucle ou aller simple [TO DO]
- miniature d'aperçu (au format image) [TO DO]


## Utilisation


```
require 'path/to/gpx-parser.php'; 

$result = GPXParser::parse('path/to/file.gpx'); 

```


## Ressources 

Documentation des fichiers GPX : https://www.topografix.com/gpx.asp


> GPX (GPS eXchange Format) est un format de fichier permettant l'échange de coordonnées géographiques provenant du GPS. Ce format permet de décrire une collection de points utilisables sous forme de points de cheminement (waypoints), traces (tracks) ou itinéraires (routes). Ce format est ouvert. Sa version la plus utilisée est le format GPX v 1.1


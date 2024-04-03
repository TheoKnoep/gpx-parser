# Description 

Projet de back-office pour analyser un fichier GPX et extraire des données diverses comme par exemple : 

- distance
- dénivelé
- score de difficulté
- adresse de départ 
- boucle ou aller simple
- départements traversés [TO DO]
- miniature d'aperçu (au format image) [TO DO]


## Utilisation


```
composer require theoknoep/gpx-difficulty-score
```

```
<?php
require 'vendor/autoload.php'; 

$result_array = Theoknoep\GpxDifficultyScore\GpxDifficultyScore::parse('path/to/file.gpx');

// display difficulty score :
echo $result_array['score']['value']; 

```


## Ressources 

Documentation des fichiers GPX : https://www.topografix.com/gpx.asp


> GPX (GPS eXchange Format) est un format de fichier permettant l'échange de coordonnées géographiques provenant du GPS. Ce format permet de décrire une collection de points utilisables sous forme de points de cheminement (waypoints), traces (tracks) ou itinéraires (routes). Ce format est ouvert. Sa version la plus utilisée est le format GPX v 1.1


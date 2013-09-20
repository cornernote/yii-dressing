<?php
// create asset path
$assetPath = app()->theme->basePath . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$assetUrl = app()->getAssetManager()->publish($assetPath, false, -1, YII_DEBUG);

// bounce 1.0
//cs()->registerCSSFile($assetUrl . '/css/style.css', 'screen, projection', array('order' => 6));

// bounce 1.2
cs()->registerCSSFile('http://fonts.googleapis.com/css?family=Open+Sans:400,300', 'screen, projection', array('order' => 5));
cs()->registerCSSFile($assetUrl . '/css/base.css', 'screen, projection', array('order' => 6));
cs()->registerCSSFile($assetUrl . '/css/blue.css', 'screen, projection', array('order' => 7));

// app style
cs()->registerCSSFile($assetUrl . '/css/app.css', 'screen, projection', array('order' => 8));

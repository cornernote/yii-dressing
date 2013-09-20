<?php
$assetPath = app()->theme->basePath . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$assetUrl = app()->getAssetManager()->publish($assetPath, false, 1, YII_DEBUG);

// register css file
cs()->registerCSSFile($assetUrl . '/css/style.css', 'screen, projection', array('order' => 5));
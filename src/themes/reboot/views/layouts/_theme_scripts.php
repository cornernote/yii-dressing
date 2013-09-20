<?php
$assetPath = Yii::app()->theme->basePath . DS . 'assets' . DS;
$assetUrl = Yii::app()->getAssetManager()->publish($assetPath, false, 1, YII_DEBUG);

cs()->registerCSSFile('http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600', 'screen, projection', array('order' => 10));
cs()->registerCSSFile($assetUrl . '/css/reboot-landing.css', 'screen, projection', array('order' => 12));
cs()->registerCSSFile($assetUrl . '/css/reboot-landing-responsive.css', 'screen, projection', array('order' => 13));
cs()->registerCSSFile($assetUrl . '/css/theme.css', 'screen, projection', array('order' => 14));
cs()->registerCSSFile($assetUrl . '/css/app.css', 'screen, projection', array('order' => 15));
cs()->registerCSSFile($assetUrl . '/css/pages.css', 'screen, projection', array('order' => 16));

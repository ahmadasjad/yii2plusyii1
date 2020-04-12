<?php

define('ROOT_DIR', dirname(__DIR__));
defined('YII_DEBUG') or define('YII_DEBUG', false);

//Composer autoloader
require ROOT_DIR . '/vendor/autoload.php';

//require ROOT_DIR . '/vendor/yiisoft/yii2/Yii.php';
// include the customized Yii class described below
require ROOT_DIR . '/Yii2Yii1.php';
require ROOT_DIR . '/common/config/bootstrap.php';
require ROOT_DIR . '/site/protected/config/yii2/bootstrap.php';

// configuration for Yii 1 application
$yii1Config = require ROOT_DIR . '/site/protected/config/main.php';

// configuration for Yii 2 application
$yii2Config = yii\helpers\ArrayHelper::merge(
    require ROOT_DIR . '/common/config/main.php',
    require ROOT_DIR . '/common/config/main-local.php',
    require ROOT_DIR . '/site/protected/config/yii2/main.php',
    require ROOT_DIR . '/site/protected/config/yii2/main-local.php'
);

// Call run on the App which has the priority
$Yii1App = Yii::createWebApplication($yii1Config);
$Yii2App = new yii\web\Application($yii2Config);

$Yii2App->run();

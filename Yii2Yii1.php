<?php

$yii2path = __DIR__.'/vendor/yiisoft/yii2';
require $yii2path . '/BaseYii.php'; // Yii 2.x

$yii1path = __DIR__.'/vendor/yiisoft/yii/framework';
require $yii1path . '/YiiBase.php'; // Yii 1.x

use yii\log\Logger as BaseLogger;
//use CLogger;

class Yii extends \yii\BaseYii
{
    use \ahmadasjad\yii2PlusYii1\Yii1Compatibility;
}

spl_autoload_register(array('Yii','autoload'));


Yii::$classMap = include($yii2path . '/classes.php');
// register Yii 2 autoloader via Yii 1
Yii::registerAutoloader(['yii\BaseYii', 'autoload']);
// create the dependency injection container
Yii::$container = new yii\di\Container;
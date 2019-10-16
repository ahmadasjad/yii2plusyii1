<?php

namespace ahmadasjad\yii2PlusYii1;

use Yii;

class Controller extends \yii\web\Controller
{

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        Yii::app()->setController($this);
    }

    public function getModule()
    {
        return null;
    }

    public function recordCachingAction($context,$method,$params)
    {

    }

    public function createUrl($route,$params=array(),$ampersand='&')
    {
        return Yii::$app->getView()->createUrl($route,$params,$ampersand);
    }

}

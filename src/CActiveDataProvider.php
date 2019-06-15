<?php


namespace ahmadasjad\yii2PlusYii1;

use CActiveDataProvider as BaseDataProvider;
use ahmadasjad\yii2PlusYii1\CSort;
use ahmadasjad\yii2PlusYii1\CPagination;
use yii\helpers\ArrayHelper;

/**
 * Description of CActiveDataProvider
 *
 * @author Ahmad Asjad <ahmadcimage@gmail.com>
 */
class CActiveDataProvider extends BaseDataProvider {
    public function __construct($modelClass, $config = array()) {
        $config = ArrayHelper::merge($config, [
            'sort' => ['class' => CSort::class],
            'pagination' => ['class' => CPagination::class],
        ]);
        parent::__construct($modelClass, $config);
        
    }
}

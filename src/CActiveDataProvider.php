<?php


namespace application\components;

use CActiveDataProvider as BaseDataProvider;

/**
 * Description of CActiveDataProvider
 *
 * @author Ahmad Asjad <ahmadcimage@gmail.com>
 */
class CActiveDataProvider extends BaseDataProvider {
    public function __construct($modelClass, $config = array()) {
        $config = \yii\helpers\ArrayHelper::merge($config, [
            'sort' => ['class' => CustomSort::class],
            'pagination' => ['class' => CustomPagination::class],
        ]);
        parent::__construct($modelClass, $config);
        
    }
}

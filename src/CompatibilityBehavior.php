<?php


namespace ahmadasjad\yii2PlusYii1;


use yii\base\Behavior;

class CompatibilityBehavior extends Behavior
{
    public function getId(){
        if(isset($this->owner->id)){
            return $this->owner->id;
        }
    }
}
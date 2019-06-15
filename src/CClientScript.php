<?php


namespace ahmadasjad\yii2PlusYii1;

use CClientScript as BaseCClientScript;
use Yii;

/**
 * Description of CClientScript
 *
 * @author Ahmad Asjad <ahmadcimage@gmail.com>
 */
class CClientScript extends BaseCClientScript {
    public function registerScript($id,$script,$position=null,array $htmlOptions=array())
    {
        parent::registerScript($id, $script, $position, $htmlOptions);
        Yii::$app->getView()->registerJs($script);
    }

    public function registerScriptFile($url,$position=null,array $htmlOptions=array())
    {
        parent::registerScriptFile($url, $position, $htmlOptions);
        Yii::$app->getView()->registerJsFile($url);
    }
    
    public function registerCoreScript($name)
    {
        parent::registerCoreScript($name);

        if(!isset($this->coreScripts[$name]['js'])){
            return $this;
        }

        $baseUrl=$this->getPackageBaseUrl($name);
        foreach ($this->coreScripts[$name]['js'] as $js){
            $full_url = $baseUrl.'/'.$js;
            Yii::$app->getView()->registerJsFile($full_url);
        }

        return $this;
    }
}

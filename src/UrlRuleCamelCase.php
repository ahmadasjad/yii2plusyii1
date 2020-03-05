<?php


namespace ahmadasjad\yii2PlusYii1;


use yii\web\UrlRule;

class UrlRuleCamelCase extends UrlRule
{
    /**
     * @param array $matches
     * @return array
     */
    protected function substitutePlaceholderNames(array $matches)
    {
        $matches = parent::substitutePlaceholderNames($matches);
        foreach ($matches as $key=>$val){
            if ($key == 'rest'){
                continue;
            }
            $matches[$key] = $this->camel2dashed($val);
        }

        //Convert remaining URL part to GET & REQUEST
        if (isset($matches['rest'])){
            $rest = ltrim($matches['rest'], '/');
            $rest = explode('/', $rest);
            for($i=0;$i<count($rest);$i+=2){
                if(!isset($rest[$i+1])){
                    continue;
                }
                if(!isset($_GET[$rest[$i]])){
                    $_GET[$rest[$i]] = $rest[$i+1];
                }
                if(!isset($_REQUEST[$rest[$i]])){
                    $_REQUEST[$rest[$i]] = $rest[$i+1];
                }
            }
        }

        return $matches;
    }

    private function camel2dashed($className) {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $className));
    }
}

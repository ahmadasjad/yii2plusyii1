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
            $matches[$key] = $this->camel2dashed($val);
        }

        return $matches;
    }

    private function camel2dashed($className) {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $className));
    }
}

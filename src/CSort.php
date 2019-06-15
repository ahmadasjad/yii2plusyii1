<?php


namespace ahmadasjad\yii2PlusYii1;


use CController;
use Yii;
use yii\data\Sort;
use CSort as BaseCSort;

class CSort extends BaseCSort
{
    /**
     * Generates a hyperlink that can be clicked to cause sorting.
     * @param string $attribute the attribute name. This must be the actual attribute name, not alias.
     * If it is an attribute of a related AR object, the name should be prefixed with
     * the relation name (e.g. 'author.name', where 'author' is the relation name).
     * @param string $label the link label. If null, the label will be determined according
     * to the attribute (see {@link resolveLabel}).
     * @param array $htmlOptions additional HTML attributes for the hyperlink tag
     * @return string the generated hyperlink
     */
    public function link($attribute,$label=null,$htmlOptions=array())
    {
        if($label===null)
            $label=$this->resolveLabel($attribute);
        if(($definition=$this->resolveAttribute($attribute))===false)
            return $label;
        $directions=$this->getDirections();
        if(isset($directions[$attribute]))
        {
            $class=$directions[$attribute] ? 'desc' : 'asc';
            if(isset($htmlOptions['class']))
                $htmlOptions['class'].=' '.$class;
            else
                $htmlOptions['class']=$class;
            $descending=!$directions[$attribute];
            unset($directions[$attribute]);
        }
        elseif(is_array($definition) && isset($definition['default']))
            $descending=$definition['default']==='desc';
        else
            $descending=false;

        if($this->multiSort)
            $directions=array_merge(array($attribute=>$descending),$directions);
        else
            $directions=array($attribute=>$descending);

        $url=$this->createUrl(Yii::app()->getController(),$directions);

        return $this->createLink($attribute,$label,$url,$htmlOptions);
    }

    /**
     * Creates a URL that can lead to generating sorted data.
     * @param CController $controller the controller that will be used to create the URL.
     * @param array $directions the sort directions indexed by attribute names.
     * The sort direction can be either CSort::SORT_ASC for ascending order or
     * CSort::SORT_DESC for descending order.
     * @return string the URL for sorting
     */
    public function createUrl($controller,$directions)
    {
        $sorts=array();
        foreach($directions as $attribute=>$descending)
            $sorts[]=$descending ? $attribute.$this->separators[1].$this->descTag : $attribute;
        $params=$this->params===null ? $_GET : $this->params;
        $params[$this->sortVar]=implode($this->separators[0],$sorts);
//        return $controller->createUrl($this->route,$params);
        return Yii::$app->getView()->createUrl($this->route,$params);
    }
}
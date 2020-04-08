<?php


namespace ahmadasjad\yii2PlusYii1;


use CException;
use CInlineFilter;
use Yii;

class FilterChain extends \CFilterChain
{


    public static function create($controller,$action,$filters)
    {
        $chain=new static($controller,$action);

        $actionID=$action->getId();
//        $actionID=$action->id;
        foreach($filters as $filter)
        {
            if(is_string($filter))  // filterName [+|- action1 action2]
            {
                if(($pos=strpos($filter,'+'))!==false || ($pos=strpos($filter,'-'))!==false)
                {
                    $matched=preg_match("/\b{$actionID}\b/i",substr($filter,$pos+1))>0;
                    if(($filter[$pos]==='+')===$matched)
                        $filter=CInlineFilter::create($controller,trim(substr($filter,0,$pos)));
                }
                else
                    $filter=CInlineFilter::create($controller,$filter);
            }
            elseif(is_array($filter))  // array('path.to.class [+|- action1, action2]','param1'=>'value1',...)
            {
                if(!isset($filter[0]))
                    throw new CException(Yii::t('yii','The first element in a filter configuration must be the filter class.'));
                $filterClass=$filter[0];
                unset($filter[0]);
                if(($pos=strpos($filterClass,'+'))!==false || ($pos=strpos($filterClass,'-'))!==false)
                {
                    $matched=preg_match("/\b{$actionID}\b/i",substr($filterClass,$pos+1))>0;
                    if(($filterClass[$pos]==='+')===$matched)
                        $filterClass=trim(substr($filterClass,0,$pos));
                    else
                        continue;
                }
                $filter['class']=$filterClass;
                $filter=Yii::createComponent($filter);
            }

            if(is_object($filter))
            {
                $filter->init();
                $chain->add($filter);
            }
        }
        return $chain;
    }

    /**
     * @throws CException
     */
    public function run()
    {
        if($this->offsetExists($this->filterIndex))
        {
            $filter=$this->itemAt($this->filterIndex++);
            Yii::trace('Running filter '.($filter instanceof CInlineFilter ? get_class($this->controller).'.filter'.$filter->name.'()':get_class($filter).'.filter()'),'system.web.filters.CFilterChain');
            $filter->filter($this);
        }
//        else
//            $this->controller->runAction($this->action);
    }
}
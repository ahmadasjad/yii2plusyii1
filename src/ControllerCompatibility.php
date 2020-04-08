<?php


namespace ahmadasjad\yii2PlusYii1;


use CAccessControlFilter;
use CFilterChain;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;

trait ControllerCompatibility
{
//    public function getUniqueId()
//    {
//        return $this->module ? $this->module->getId().'/'.$this->id : $this->id;
//    }

    /**
     * @param $action
     * @return bool
     * @throws ForbiddenHttpException
     * @throws \CException
     */
    public function beforeAction($action)
    {
//        $user = $this->user;
//        $request = Yii::$app->getRequest();
//        /* @var $rule AccessRule */
//        foreach ($this->rules as $rule) {
//            if ($allow = $rule->allows($action, $user, $request)) {
//                return true;
//            } elseif ($allow === false) {
//                if (isset($rule->denyCallback)) {
//                    call_user_func($rule->denyCallback, $rule, $action);
//                } elseif ($this->denyCallback !== null) {
//                    call_user_func($this->denyCallback, $rule, $action);
//                } else {
//                    $this->denyAccess($user);
//                }
//
//                return false;
//            }
//        }
//        if ($this->denyCallback !== null) {
//            call_user_func($this->denyCallback, null, $action);
//        } else {
//            $this->denyAccess($user);
//        }
        if (empty($this->behaviors())) {
            $filters = [];
            if (method_exists($this, 'filters')) {
                $filters = $this->filters();
            }
            if (!empty($filters)) {
                $action->attachBehavior('Yii2Yii1Compatibility', new CompatibilityBehavior());
                FilterChain::create($this, $action, $filters)->run();
            }
        }
        return true;
    }

    /**
     * The filter method for 'postOnly' filter.
     * This filter throws an exception (CHttpException with code 400) if the applied action is receiving a non-POST request.
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     * @throws BadRequestHttpException
     */
    public function filterPostOnly($filterChain)
    {
        if (Yii::app()->getRequest()->getIsPostRequest())
            $filterChain->run();
        else {
            throw new BadRequestHttpException(Yii::t('yii', 'Your request is invalid.'));
        }
    }

    /**
     * The filter method for 'ajaxOnly' filter.
     * This filter throws an exception (CHttpException with code 400) if the applied action is receiving a non-AJAX request.
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     * @throws BadRequestHttpException
     */
    public function filterAjaxOnly($filterChain)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest())
            $filterChain->run();
        else {
            throw new BadRequestHttpException(Yii::t('yii', 'Your request is invalid.'));
        }
    }

    /**
     * The filter method for 'accessControl' filter.
     * This filter is a wrapper of {@link CAccessControlFilter}.
     * To use this filter, you must override {@link accessRules} method.
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     */
    public function filterAccessControl($filterChain)
    {
        $filter = new CAccessControlFilter;
//        $filter->deniedCallback = function (){
//            if(Yii::$app->user->getIsGuest())
//                Yii::$app->user->loginRequired();
//            else
//                throw new CHttpException(403,$filter->resolveErrorMessage($rule));
//        }
        $accessRules = $this->accessRules();
        foreach ($accessRules as &$accessRule) {
            if (!isset($accessRule['actions']))
                continue;
            foreach ($accessRule['actions'] as &$action) {
                $action = $this->camel2dashed($action);
            }
        }
        $filter->setRules($accessRules);
        $filter->filter($filterChain);
    }

    private function camel2dashed($string)
    {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $string));
    }

    /**
     * @return array
     */
    public function accessRules()
    {
        return [];
    }

    /**
     * This is useful when any controller have `$this->pageTitle = '';` according to Yii1 version
     * @param $title
     */
    public function setPageTitle($title)
    {
        Yii::$app->getView()->title = $title;
    }

    /**
     * To make old version code compatible with new version
     * For example: if somewhere it used like `echo $this->pageTitle`
     * @return mixed|string
     */
    public function getPageTitle()
    {
        return Yii::$app->getView()->title;
    }

    public function setTitle($title)
    {
        Yii::$app->getView()->title = $title;
    }

    public function getTitle()
    {
        return Yii::$app->getView()->title;
    }

}

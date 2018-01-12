<?php
namespace testproject\category\traits;

use testproject\category\Module;
/**
 * Trait ModuleTrait
 * @property-read Module $module
 * @package ddmytruk\project\traits
 */
trait ModuleTrait
{
    /**
     * @return Module|null the module instance, `null` if the module does not exist.
     */
    public function getModule()
    {
        return \Yii::$app->getModule('category');
    }

}
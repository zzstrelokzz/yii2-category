<?php
namespace testproject\category\components;

use testproject\category\DI;
use testproject\category\Finder;

/**
 * Class CommonController
 * @package testproject\category\components
 */
class CommonController extends \yii\web\Controller
{
    /**
     * @var DI
     */
    protected $di;

    /**
     * @var Finder
     */
    protected $finder;
    /**
     * @param string           $id
     * @param \yii\base\Module $module
     * @param DI               $di
     * @param Finder           $finder
     * @param array            $config
     */
    public function __construct($id, $module, Finder $finder, DI $di, $config = [])
    {
        $this->di = $di;
        $this->finder = $finder;

        foreach ($config as $name => $definition) {

            if((substr_count($name, 'before') && !substr_count($name, 'on before'))
                || substr_count($name, 'after') && !substr_count($name, 'on after')) {

                $config['on '.$name] = $config[$name];
                unset($config[$name]);
            }
        }

        parent::__construct($id, $module, $config);
    }
}
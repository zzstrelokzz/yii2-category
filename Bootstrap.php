<?php
namespace testproject\category;

use yii\i18n\PhpMessageSource;

class Bootstrap implements \yii\base\BootstrapInterface
{
    private $_modelMap = [
        'Category'       => 'testproject\category\models\orm\Category',
        'CategoryForm'   => 'testproject\category\models\form\CategoryForm',
        'CategorySearch' => 'testproject\category\models\search\CategorySearch'
    ];
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app->hasModule('category') && ($module = $app->getModule('category')) instanceof Module)
        {
            $this->_modelMap = array_merge($this->_modelMap, $module->modelMap);

            foreach ($this->_modelMap as $name => $definition)
            {
                $modelName = is_array($definition) ? $definition['class'] : $definition;

                $module->modelMap[$name] = $modelName;

                \Yii::$container->set($name, function () use ($modelName) {
                    return \Yii::createObject($modelName);
                });

                if (in_array($name, ['Category']))
                {
                    \Yii::$container->set($name . 'Query', function () use ($modelName) {
                        return $modelName::find();
                    });
                }
            }

            \Yii::$container->setSingleton(Finder::className(), [
                'categoryQuery'    => \Yii::$container->get('CategoryQuery'),
            ]);

            \Yii::$container->setSingleton(DI::className(), [
                'categoryForm'   => \Yii::$container->get('CategoryForm'),
                'searchCategory' => \Yii::$container->get('CategorySearch'),
            ]);

            if (!isset($app->get('i18n')->translations['category*'])) {
                $app->get('i18n')->translations['category*'] = [
                    'class' => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                    'sourceLanguage' => 'en-US'
                ];
            }
        }
    }
}
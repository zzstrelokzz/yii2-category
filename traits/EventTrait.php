<?php
namespace testproject\category\traits;

use yii\base\Model;
use testproject\category\events\FormEvent;

trait EventTrait
{
    /**
     * @param  Model     $form
     * @return object the created object (FormEvent or InvalidConfigException)
     * @throws \yii\base\InvalidConfigException
     */
    protected function getFormEvent(Model $form)
    {
        return \Yii::createObject(['class' => FormEvent::className(), 'form' => $form]);
    }
}
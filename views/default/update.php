<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model \testproject\category\models\form\CategoryForm
 */
?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false
]); ?>

<?= $form->field($model, 'name') ?>

<?= $form->field($model, 'depth') ?>

<?= $form->field($model, 'parent_id') ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('project', 'Save'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

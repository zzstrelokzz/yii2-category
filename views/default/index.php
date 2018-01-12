<?php



use yii\grid\GridView;
use yii\helpers\Html;
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */
?>
<p>
    <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'name',
        'depth',
        'parent_id',
        'created_at',
        'updated_at',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>

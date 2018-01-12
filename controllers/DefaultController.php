<?php
namespace testproject\category\controllers;

use testproject\category\components\CommonController;
use testproject\category\models\form\CategoryForm;
use testproject\category\traits\AjaxValidationTrait;
use testproject\category\traits\EventTrait;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Class DefaultController
 * @package testproject\category\controllers
 */
class DefaultController extends CommonController
{
    use AjaxValidationTrait;
    use EventTrait;

    const EVENT_BEFORE_INDEX   = 'beforeIndex';

    const EVENT_BEFORE_CREATE   = 'beforeCreate';
    const EVENT_AFTER_CREATE    = 'afterCreate';

    const EVENT_BEFORE_UPDATE   = 'beforeUpdate';
    const EVENT_AFTER_UPDATE    = 'afterUpdate';

    /**
     * @return string
     */
    public function actionIndex()
    {

        $searchModel  = $this->di->getSearchCategory();

        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        /** @var CategoryForm $model */
        $model = $this->di->getCategoryForm();

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(Url::previous('actions-redirect'));
        }

        return $this->render('create', [
            'model' => $model
        ]);

    }

    /**
     * @param $id integer
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $categoryModel = $this->findModel($id);

        if($categoryModel === null)
            throw new NotFoundHttpException();

        /** @var CategoryForm $model */

        $model = $this->di->getCategoryForm();

        $model->load($categoryModel->getAttributes(), '');

        $model->setModel($categoryModel);

        if ($model->load(\Yii::$app->request->post()) && $model->update()) {

            return $this->redirect(Url::previous('actions-redirect'));
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        echo "delete $id";
    }
    public function actionView($id)
    {
        $categoryModel = $this->findModel($id);

        if($categoryModel === null)
            throw new NotFoundHttpException();

        return $this->render('view', [
            'model' => $categoryModel
        ]);
    }

    /**
     * @param int $id
     *
     * @return ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {

        $category = $this->finder->findCategoryById($id);
        if ($category === null) {
            throw new NotFoundHttpException(\Yii::t('category', 'The requested page does not exist'));
        }
        return $category;
    }
}
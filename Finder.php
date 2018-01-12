<?php
namespace testproject\category;

use testproject\category\traits\ModuleTrait;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Finder extends \yii\base\Object
{
    use ModuleTrait;

    /**
     * @var ActiveQuery
     */
    public $categoryQuery;

    /**
     * @return ActiveQuery
     */
    public function getCategoryQuery()
    {
        return $this->categoryQuery;
    }

    /**
     * Finds a project by the given id.
     *
     * @param int $id Project id to be used on search.
     *
     * @return ActiveRecord|null
     */
    public function findCategoryById($id)
    {
        return $this->findCategory(['id' => $id])->one();
    }

    /**
     * Finds a project by the given condition.
     *
     * @param mixed $condition Condition to be used on search.
     *
     * @return \yii\db\ActiveQuery
     */
    public function findCategory($condition)
    {
        return $this->categoryQuery->where($condition);
    }
}
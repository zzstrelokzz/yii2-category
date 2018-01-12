<?php
namespace testproject\category;

use testproject\category\models\form\CategoryForm;
use testproject\category\models\orm\Category;
use testproject\category\models\search\CategorySearch;
use yii\base\Object;

class DI extends Object
{
    /**
     * @var CategoryForm
     */
    protected $categoryForm;

    /**
     * @var CategorySearch
     */
    protected $searchCategory;

    /**
     * @return CategoryForm
     */
    public function getCategoryForm()
    {
        return $this->categoryForm;
    }

    /**
     * @param CategoryForm $categoryForm
     */
    public function setCategoryForm(CategoryForm $categoryForm)
    {
        $this->categoryForm = $categoryForm;
    }

    /**
     * @return CategorySearch
     */

    public function getSearchCategory()
    {
        return $this->searchCategory;
    }

    /**
     * @param $searchCategory
     */
    public function setSearchCategory($searchCategory)
    {
        $this->searchCategory = $searchCategory;
    }
}
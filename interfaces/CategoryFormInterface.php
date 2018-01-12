<?php
namespace testproject\category\interfaces;

use testproject\category\models\orm\Category;

interface CategoryFormInterface
{
    public function create();

    public function update();

    public function setModel(Category $model);
}
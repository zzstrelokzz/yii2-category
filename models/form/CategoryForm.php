<?php
namespace testproject\category\models\form;

use testproject\category\interfaces\CategoryFormInterface;
use testproject\category\models\orm\Category;
use testproject\category\traits\ModuleTrait;
use yii\base\Model;
use testproject\category\Finder;
use yii\db\ActiveRecord;

/**
 * Class CategoryForm
 * @package testproject\category\models\form
 *
 * @property integer $id
 * @property string $name
 * @property string $depth
 * @property string $parent_id
 */

class CategoryForm extends Model implements CategoryFormInterface
{
    use ModuleTrait;

    public $id;
    public $name;
    public $depth;
    public $parent_id;

    /** @var  Category */
    protected $model;

    /**
     * @var Finder
     */
    protected $finder;

    /**
     * @param Finder $finder
     * @param array  $config
     */
    public function __construct(Finder $finder, $config = [])
    {
        $this->finder = $finder;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name rules
            'nameTrim'      => ['name', 'trim'],
            'nameRequired'  => ['name', 'required'],
            'nameLength'    => ['name', 'string', 'min' => 3, 'max' => 255],

            // depth rules
            'descriptionTrim'   => ['depth', 'trim'],
            'descriptionLength' => ['depth', 'string'],

            // status rules
            'statusLength'      => ['parent_id', 'integer', 'max' => 11],

            'fieldsSafe'        => [['id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('app', 'Name'),
            'depth' => \Yii::t('app', 'Depth'),
            /*'parent_id' => \Yii::t('products', 'Parent'),*/
        ];
    }

    /**
     * @return bool
     */
    public function create()
    {
        /** @var  $categoryModel ActiveRecord */
        $categoryModel = \Yii::createObject($this->getModule()->modelMap['Category']);

        $this->loadAttributes($categoryModel);
/*
        echo "<pre>";
        print_r($categoryModel->save());
        echo "</pre>";
        die;*/
        if($categoryModel->save())
            return true;

        return false;
    }

    /**
     * @return bool
     */
    public function update()
    {
        if($this->model)
        {
            $this->loadAttributes($this->model);

            if($this->model->update())
                return true;
        }
        return false;
    }

    /**
     * @param Category $model
     */
    public function setModel(Category $model)
    {
        $this->model = $model;
    }

    /**
     * @param ActiveRecord $category
     */
    protected function loadAttributes($category)
    {
        $category->setAttributes($this->attributes);
    }
}
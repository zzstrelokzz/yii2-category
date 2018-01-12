<?php
namespace testproject\category\models\search;

use yii\base\Model;
use testproject\category\Finder;
use yii\data\ActiveDataProvider;

/**
 * Class CategorySearch
 * @package testproject\category\\models\search
 * @property $name string
 * @property $depth string
 * @property $parent_id integer
 */
class CategorySearch extends Model
{
    public $name;
    public $depth;
    public $parent_id;

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
            'fieldsSafe' => [['name', 'depth', 'parent_id'], 'safe'],
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = $this->finder->getCategoryQuery();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $table_name = $query->modelClass::tableName();

        $query->andFilterWhere(['like', $table_name . '.name', $this->name]);
        $query->andFilterWhere(['like', $table_name . '.depth', $this->depth]);

        return $dataProvider;
    }
}
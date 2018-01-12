<?php
namespace testproject\category\models\orm;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Category extends ActiveRecord
{
	const BEFORE_CREATE   = 'beforeCreate';
    const AFTER_CREATE    = 'afterCreate';

    const BEFORE_UPDATE   = 'beforeUpdate';
    const AFTER_UPDATE    = 'afterUpdate';

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
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

        	//parent_id
            'parent_idLength'   => ['parent_id', 'integer', 'max' => 11],
            //
            'fieldsSafe'        => [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     * @throws \Exception
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $transaction = $this->getDb()->beginTransaction();
        try
        {
            $this->trigger(self::BEFORE_CREATE);

            if(!parent::save($runValidation, $attributeNames))
            {
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();

            $this->trigger(self::AFTER_CREATE);

            return true;
        }
        catch (\Exception $e)
        {

            $transaction->rollBack();
            \Yii::warning($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     * @throws \Exception
     */
    public function update($runValidation = true, $attributeNames = null)
    {
        $transaction = $this->getDb()->beginTransaction();

        try
        {
            $this->trigger(self::BEFORE_UPDATE);

            if(!parent::update($runValidation, $attributeNames))
            {
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();

            $this->trigger(self::AFTER_UPDATE);

            return true;
        }
        catch (\Exception $e)
        {
            $transaction->rollBack();
            \Yii::warning($e->getMessage());
            throw $e;
        }
    }
}


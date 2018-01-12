<?php
namespace ddmytruk\project\traits;

/**
 * Trait ProjectTraitQuery
 * @package ddmytruk\project\models\traits
 */
trait ProjectTraitQuery
{
    /** @return \yii\db\ActiveQuery */
    public function getAvatar()
    {
        return $this->hasOne(Picture::className(), ['id' => 'avatar_id']);
    }

    /** @return \yii\db\ActiveQuery */
    public function getIssues()
    {
        return $this->hasMany(Issue::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVersions()
    {
        return $this->hasMany(Version::className(), ['project_id' => 'id']);
    }
}
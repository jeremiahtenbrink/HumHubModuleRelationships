<?php

namespace humhub\modules\relationships\models;

use Yii;

/**
 *
 * @author CO_Nerd
 * This is the model class for table "relationship_category".
 *
 * @property int $id
 * @property string $category
 *
 * @property RelationshipType[] $relationshipTypes
 */
class RelationshipCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relationship_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationshipTypes()
    {
        return $this->hasMany(RelationshipType::className(), ['relationship_category' => 'id']);
    }
}

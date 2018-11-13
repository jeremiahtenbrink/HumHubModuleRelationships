<?php

namespace conerd\humhub\modules\relationships\models;

use Yii;

/**
 * @author CO_Nerd
 * This is the model class for table "relationship_type".
 *
 * @property int $id
 * @property int $relationship_category
 * @property string $type
 *
 * @property Relationship[] $relationships
 * @property RelationshipCategory $relationshipCategory
 */
class RelationshipType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relationship_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['relationship_category', 'type'], 'required'],
            [['relationship_category'], 'integer'],
            [['type'], 'string', 'max' => 255],
            [['relationship_category'], 'exist', 'skipOnError' => true, 'targetClass' => RelationshipCategory::className(), 'targetAttribute' => ['relationship_category' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'relationship_category' => 'Relationship Category',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationships()
    {
        return $this->hasMany(Relationship::className(), ['relationship_type' => 'id']);
    }

    /**
     * @return string
     */
    public function getRelationshipCategory()
    {
        $category = $this->hasOne(RelationshipCategory::class, ['id' => 'relationship_category'])->one();
        return $category->category;
    }
}

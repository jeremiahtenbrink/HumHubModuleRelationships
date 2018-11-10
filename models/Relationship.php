<?php

namespace conerd\humhub\modules\relationships\models;

use Yii;

/**
 * This is the model class for table "relationship".
 *
 * @property int $id
 * @property int $user_id
 * @property int $other_user_id
 * @property int $relationship_type
 * @property int $approved
 *
 * @property User $otherUser
 * @property RelationshipType $relationshipType
 * @property User $user
 */
class Relationship extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relationship';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'other_user_id', 'relationship_type'], 'required'],
            [['user_id', 'other_user_id', 'relationship_type', 'approved'], 'integer'],
            [['other_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['other_user_id' => 'id']],
            [['relationship_type'], 'exist', 'skipOnError' => true, 'targetClass' => RelationshipType::className(), 'targetAttribute' => ['relationship_type' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'other_user_id' => 'Other User ID',
            'relationship_type' => 'Relationship Type',
            'approved' => 'Approved',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOtherUser()
    {
        return $this->hasOne(User::className(), ['id' => 'other_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationshipType()
    {
        return $this->hasOne(RelationshipType::className(), ['id' => 'relationship_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

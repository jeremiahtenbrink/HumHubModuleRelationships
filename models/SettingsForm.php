<?php

namespace conerd\humhub\modules\relationships\models;

use Yii;

/**
 * @author CO_Nerd
 * This is the model class for the settings form.
 *
 */
class SettingsForm extends \yii\db\ActiveRecord
{

    public $showOnProfile;
    public $showChangesToRelationshipsOnWall;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['showOnProfile', 'showChangesToRelationshipsOnWall'], 'required'],
            [['showOnProfile', 'showChangesToRelationshipsOnWall'], 'boolean'],
          ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'showOnProfile' => 'Show Relationships on Profile',
            'showChangesToRelationshipsOnWall' => 'Post Relationship Changes on Wall',
        ];
    }

    /**
     * @param mixed $showOnProfile
     */
    public function setShowOnProfile($showOnProfile)
    {
        $this->showOnProfile = $showOnProfile;
    }

    /**
     * @param mixed $showChangesToRelationshipsOnWall
     */
    public function setShowChangesToRelationshipsOnWall($showChangesToRelationshipsOnWall)
    {
        $this->showChangesToRelationshipsOnWall = $showChangesToRelationshipsOnWall;
    }

}

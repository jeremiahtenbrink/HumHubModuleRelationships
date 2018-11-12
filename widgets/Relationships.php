<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/10/2018
 * Time: 8:44 PM
 */

namespace conerd\humhub\modules\relationships\widgets;

use conerd\humhub\modules\relationships\models\RelationshipType;
use humhub\components\Widget;
use conerd\humhub\modules\relationships\models\Relationship;
use humhub\modules\user\models\User;
use Yii;
use yii\helpers\Url;

class Relationships extends Widget
{

    /**
     * @var User
     */
    public $user;

    /**
     * @var boolean is owner of the current profile
     */
    protected $isProfileOwner = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        /**
         * Try to autodetect current user by controller
         */
        if ($this->user === null) {
            $this->user = $this->getController()->getUser();
        }

        if (!Yii::$app->user->isGuest && Yii::$app->user->id == $this->user->id) {
            $this->isProfileOwner = true;
        }

        parent::init();
    }

    public function run()
    {
        $relationships = Relationship::find()->where(['user_id' => $this->user->id])->all();

        $relationshipUsers = [];

        foreach ($relationships as $relationship)
        {
            /* @var $relationship Relationship */
            $user = User::find()->where(['id' => $relationship->other_user_id])->one();
            $relationshipUsers[$relationship->other_user_id] = $user;
        }

        $types = RelationshipType::find()->all();
        $relationshipTypes = [];
        foreach ($types as $type)
        {
            /* @var $type \conerd\humhub\modules\relationships\models\RelationshipType */
            $relationshipTypes[$type->id] = $type->type;
        }

        $url = Url::to(['/u/' . $this->user->username]);

        return $this->render('relationships',[
            'relationships' => $relationships,
            'relationshipTypes' => $relationshipTypes,
            'user' => $this->user,
            'relationshipUsers' => $relationshipUsers,
            'isProfileOwner' => $this->isProfileOwner,
            'url' => $url,
        ]);
    }
}
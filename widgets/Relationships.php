<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/10/2018
 * Time: 8:44 PM
 */

namespace humhub\modules\relationships\widgets;

use humhub\modules\relationships\models\RelationshipType;
use humhub\modules\relationships\Module;
use humhub\components\Widget;
use humhub\modules\relationships\models\Relationship;
use humhub\modules\user\models\User;
use Yii;
use yii\helpers\Url;

/**
 * @author CO_Nerd
 * Class Relationships
 * @package humhub\modules\relationships\widgets
 */
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

    /**
     * Return the Relationship panel for the users profile.
     * @return string
     */
    public function run()
    {

        $enabled = $this->user->moduleManager->isEnabled('relationships');
        /* @var $module Module */
        $module = Yii::$app->getModule('relationships');
        $settings = $module->settings->contentContainer($this->user)->get('relationshipSettings');

        if ($settings == null){
            $settings = $module->getDefaultUserSettings();
            $module->settings->contentContainer($this->user)->set('relationshipSettings', json_encode($settings));
        }else {
            $settings = \GuzzleHttp\json_decode($settings, true);
        }



        if ($settings['showOnProfile'] == 0){
            return;
        }

        if (!$enabled)
        {
            return;
        }

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
            /* @var $type \humhub\modules\relationships\models\RelationshipType */
            $relationshipTypes[$type->id] = $type->type;
        }

        $url = Url::to(['/u/' . $this->user->username]);

        return $this->render('relationships',[
            'relationships' => $relationships,
            'relationshipTypes' => $relationshipTypes,
            'user' => $this->user,
            'relationshipUsers' => $relationshipUsers,
            'isProfileOwner' => $this->isProfileOwner,
            'userUrl' => $url,
        ]);
    }
}
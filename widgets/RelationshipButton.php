<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/10/2018
 * Time: 8:44 PM
 */

namespace humhub\modules\relationships\widgets;

use humhub\components\Widget;
use humhub\modules\relationships\models\Relationship;
use humhub\modules\user\models\User;
use Yii;

/**
 * @author CO_Nerd
 * Class RelationshipButton
 * @package humhub\modules\relationships\widgets
 */
class RelationshipButton extends Widget
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     */
    public $url;

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
     * Returns the buttons for the users profile in the relationship panel.
     * @return string|void
     */
    public function run()
    {

        if ($this->isProfileOwner)
        {
            return $this->render('create-relationship.php');
        }

        $relationship = Relationship::find()->where(['user_id' => $this->user->id])
            ->andWhere(['other_user_id' => Yii::$app->user->id])->one();
        /* @var $relationship \humhub\modules\relationships\models\Relationship */
        if (!$relationship)
        {
            return;
        }


        if ($relationship->approved)
        {
            return $this->render('relationship-button', [
                'relationship' => $relationship,
                'userUrl' => $this->url,
            ]);
        }else {
            return $this->render('pending-relationship', [
                'relationship' => $relationship,
                'userUrl' => $this->url,
            ]);
        }

    }
}
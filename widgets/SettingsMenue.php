<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/15/2018
 * Time: 4:13 PM
 */

namespace humhub\modules\relationships\widgets;

use humhub\modules\relationships\models\Relationship;
use yii\helpers\Url;
use Yii;

/**
 * Account Settings Tab Menu
 */
class SettingsMenue extends \humhub\widgets\BaseMenu
{

    /**
     * @var \humhub\modules\user\models\User
     */
    public $user;

    /**
     * @inheritdoc
     */
    public $template = "@humhub/widgets/views/tabMenu";

    /**
     * @inheritdoc
     */
    public function init()
    {

        $this->addItem([
            'label' => "Settings",
            'url' => Url::toRoute(['/relationships/settings/manage']),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->id == 'settings' && Yii::$app->controller->action->id == 'manage'),
        ]);


        $this->addItem([
            'label' => 'Relationships',
            'url' => Url::toRoute(['/relationships/settings/show-relationships']),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->id == 'settings' && Yii::$app->controller->action->id == 'show-relationships'),
        ]);


        $this->addItem([
            'label' => 'Pending Requests',
            'url' => Url::toRoute(['/relationships/settings/pending-relationships']),
            'sortOrder' => 300,
            'isActive' => (Yii::$app->controller->id == 'settings' && Yii::$app->controller->action->id == 'pending-relationships'),
        ]);

        parent::init();
    }

    public function run()
    {
        return parent::run(); // TODO: Change the autogenerated stub
    }

}
<?php

namespace  conerd\humhub\modules\relationships;

use conerd\humhub\modules\relationships\models\Relationship;
use humhub\components\Event;
use Yii;
use yii\helpers\Url;

/**
 * @author CO_Nerd
 * Class Events
 * @package conerd\humhub\modules\relationships
 */
class Events
{

    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem([
            'label' => 'Relationships',
            'url' => Url::to(['/relationships/admin']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-heartbeat"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'relationships' && Yii::$app->controller->id == 'admin'),
            'sortOrder' => 99999,
        ]);
    }

    public static function onUserDelete(Event $event)
    {
        $user = $event->sender;
        Relationship::deleteAll(['user_id' => $user->id]);

    }

    /**
     * Add relationship navigation entry to account menu
     *
     * @param \yii\base\Event $event
     */
    public static function onAccountMenuInit($event)
    {
        if (Yii::$app->getModule('relationships')->getIsEnabled()) {
            $event->sender->addItem([
                'label' => "Relationships",
                'url' => Url::to(['/relationships/settings/manage']),
                'icon' => '<i class="fa fa-heartbeat"></i>',
                'group' => 'account',
                'sortOrder' => 150,
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'relationships'),
            ]);
        }
    }


}

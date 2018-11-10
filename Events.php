<?php

namespace  conerd\humhub\modules\relationships;

use Yii;
use yii\helpers\Url;

class Events
{
    /**
     * Defines what to do when the top menu is initialized.
     *
     * @param $event
     */
    public static function onTopMenuInit($event)
    {
        /*$event->sender->addItem([
            'label' => 'Relationships',
            'icon' => '<i class="fa fa-heartbeat"></i>',
            'url' => Url::to(['/relationships/index']),
            'sortOrder' => 99999,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'relationships' && Yii::$app->controller->id == 'index'),
        ]);*/
    }

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
}

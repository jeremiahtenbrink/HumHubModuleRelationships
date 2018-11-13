<?php

namespace  conerd\humhub\modules\relationships;

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
}

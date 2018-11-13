<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace conerd\humhub\modules\relationships\notifications;

use humhub\modules\user\models\User;
use Yii;
use humhub\modules\notification\components\NotificationCategory;
use humhub\modules\notification\targets\BaseTarget;
use humhub\modules\notification\targets\MailTarget;
use humhub\modules\notification\targets\WebTarget;
use humhub\modules\notification\targets\MobileTarget;

/**
 * @author CO_Nerd
 * Relationship Notification Category
 *
 * @author buddha
 */
class RelationshipNotificationCategory extends NotificationCategory
{

    /**
     * Category Id
     * @var string
     */
    public $id = 'relationships';

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return 'Relationships';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'Receive Notifications for Relationship Request and Approval events.';
    }

    /**
     * @inheritdoc
     */
    public function getDefaultSetting(BaseTarget $target)
    {
        if ($target->id === MailTarget::getId()) {
            return true;
        } elseif ($target->id === WebTarget::getId()) {
            return true;
        } elseif ($target->id === MobileTarget::getId()) {
            return true;
        }

        return $target->defaultSetting;
    }

    /**
     * @inheritdoc
     */
    public function isVisible(User $user = null)
    {
        return true;
    }

}

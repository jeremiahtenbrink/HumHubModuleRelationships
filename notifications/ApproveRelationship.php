<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/12/2018
 * Time: 7:06 AM
 */

namespace humhub\modules\relationships\notifications;

use Yii;
use yii\bootstrap\Html;
use humhub\modules\notification\components\BaseNotification;

/**
 * @author CO_Nerd
 * Approve Relationship Request Notification
 *
 * @since 1.1
 */
class ApproveRelationship extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = "relationships";

    /**
     * @inheritdoc
     */
    public $viewName = 'approveRelationship';

    /**
     * @inheritdoc
     */
    public $markAsSeenOnClick = true;

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return $this->originator->getUrl();
    }

    /**
     * @inheritdoc
     */
    public function category()
    {
        return new RelationshipNotificationCategory();
    }

    /**
     * @inheritdoc
     */
    public function getMailSubject()
    {
        return strip_tags($this->html());
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        return Html::tag('strong', Html::encode($this->originator->displayName)) . ' has approved your relationship.';
    }

}

?>

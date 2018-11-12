<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/12/2018
 * Time: 7:08 AM
 */

namespace conerd\humhub\modules\relationships\notifications;

use Yii;
use yii\bootstrap\Html;
use humhub\modules\notification\components\BaseNotification;

/**
 * Friends Request
 *
 * @since 1.1
 */
class DenyRelationship extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = "relationships";

    /**
     * @inheritdoc
     */
    public $viewName = 'denyRelationship';

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
        return Html::tag('strong', Html::encode($this->originator->displayName)) . ' has denied your relationship.';
    }

}

?>

<?php

namespace conerd\humhub\modules\relationships;

use conerd\humhub\modules\relationships\migration\Enable;
use conerd\humhub\modules\relationships\migration\Uninstall;
use Yii;
use yii\helpers\Url;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\user\models\User;

/**
 * @author CO_Nerd
 * Class Module
 *
 * @package conerd\humhub\modules\relationships
 */
class Module extends \humhub\modules\content\components\ContentContainerModule
{
    /**
    * @inheritdoc
    */
    public function getContentContainerTypes()
    {
        return [
            User::class
        ];
    }

    /**
    * @inheritdoc
    */
    public function getConfigUrl()
    {
        return Url::to(['/relationships/admin']);
    }

    /**
     * Called when the module is enabled.
     * @return bool
     */
    public function enable()
    {
        // call the enable file inside of the migration folder to create the db objects.
        $enable = new Enable();
        $enable->safeUp();
        return parent::enable();
    }

    /**
     * Called when the module is disabled.
    * @inheritdoc
    */
    public function disable()
    {
        // Calls the uninstall script in the migration folder to remove all database objects.
        $disable = new Uninstall();
        $disable->up();
        // Cleanup all module data, don't remove the parent::disable()!!!
        parent::disable();
    }

    /**
    * @inheritdoc
    */
    public function disableContentContainer(ContentContainerActiveRecord $container)
    {
        // Clean up space related data, don't remove the parent::disable()!!!
        parent::disable();
    }

    /**
    * @inheritdoc
    */
    public function getContentContainerName(ContentContainerActiveRecord $container)
    {
        return 'Relationships';
    }

    /**
    * @inheritdoc
    */
    public function getContentContainerDescription(ContentContainerActiveRecord $container)
    {
        return "Create Relatinoships between users.";
    }

    public function getPath(){
        return "protected/modules/relationships";
    }

    /**
     * Returns if the friendship system is enabled
     *
     * @return boolean is enabled
     */
    public function getIsEnabled()
    {
        if (Yii::$app->getModule('relationships')->settings->get('enable')) {
            return true;
        }

        return false;
    }

    /**
     * Returns module name
     * @return string
     */
    public function getName()
    {
        return "Relationships";
    }

    /**
     * @inheritdoc
     */
    public function getNotifications()
    {
        return [
            'conerd\humhub\modules\relationships\notifications\CreateRelationship',
            'conerd\humhub\modules\relationships\notifications\ApproveRelationship',
            'conerd\humhub\modules\relationships\notifications\DenyRelationship',
            'conerd\humhub\modules\relationships\notifications\RemoveRelationship',
        ];
    }
}

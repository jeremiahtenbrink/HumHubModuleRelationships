<?php

namespace conerd\humhub\modules\relationships;

use conerd\humhub\modules\relationships\migration\Enable;
use conerd\humhub\modules\relationships\migration\Uninstall;
use conerd\humhub\modules\relationships\models\Relationship;
use humhub\modules\content\models\ContentContainer;
use humhub\modules\content\models\ContentContainerModuleState;
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
        $this->settings->set('enable', true);
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
        $this->settings->set('enable', false);
        foreach (Relationship::find()->all() as $relationship)
        {
            $relationship->delete();
        }

        // Calls the uninstall script in the migration folder to remove all database objects.
        $disable = new Uninstall();
        $disable->up();
        // Cleanup all module data, don't remove the parent::disable()!!!
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
        $enabled = $this->settings->get('enable');
        if ($this->settings->get('enable')) {
            return true;
        }

        $enabled = Yii::$app->hasModule('relationships');
        if ($enabled)
        {
            $this->settings->set('enable', true);
            return true;
        }

        return false;
    }

    public function disableContentContainer(ContentContainerActiveRecord $container)
    {

        parent::disableContentContainer($container);
    }

    /**
     * Returns module name
     * @return string
     */
    public function getName()
    {
        return "Relationships";
    }

    public function getDefaultUserSettings(){

        $settings = [];

        $settings['showOnProfile'] = 1;
        $settings['showChangesToRelationshipsOnWall'] = 1;

        return \GuzzleHttp\json_encode($settings);

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

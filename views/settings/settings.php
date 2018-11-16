<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/15/2018
 * Time: 3:54 PM
 */

/* @var $settingsForm \conerd\humhub\modules\relationships\models\SettingsForm */

use humhub\modules\ui\form\widgets\ActiveForm;
use yii\helpers\Url;

\conerd\humhub\modules\relationships\assets\Assets::register($this);

?>
<?php $form = ActiveForm::begin(['action' => ['manage'],'options' => ['method' => 'post']]); ?>

<?= $form->field($settingsForm, 'showOnProfile')->checkbox(['onChange' => 'humhub.modules.relationships.settingsChanged(this)', 'data-url' => Url::to(['/relationships/settings/settings-changed'])]) ?>

<?= $form->field($settingsForm, 'showChangesToRelationshipsOnWall')->checkbox()?>

<?php ActiveForm::end() ?>



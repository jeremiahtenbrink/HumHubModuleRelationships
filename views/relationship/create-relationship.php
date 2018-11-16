<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/10/2018
 * Time: 9:40 PM
 */

/* @var $this \yii\web\View */
/* @var $relationship \conerd\humhub\modules\relationships\models\Relationship */
/* @var $relationshipCategory \conerd\humhub\modules\relationships\models\RelationshipCategory */
/* @var $friends array[$user->id => user ] */

use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use humhub\libs\Html;
use yii\helpers\Url;

conerd\humhub\modules\relationships\assets\Assets::register($this);

?>

<div class="create-releationship modal-dialog modal-dialog-normal animated fadeIn">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Create Relationship</h4>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['action' => ['create-relationship'],'options' => ['method' => 'post']]); ?>

            <?= $form->field($relationshipCategory, 'category')->dropDownList(
                ArrayHelper::map(\conerd\humhub\modules\relationships\models\RelationshipCategory::find()->all(), 'id', 'category'),
                [
                    'prompt' => "Select Relationship Category",
                    'url' => Url::to(['get-types']),
                    'onchange' => "humhub.modules.relationships.getRelationshipTypes(this)"
                ]
            ) ?>

            <?= $form->field($relationship, 'relationship_type')->dropDownList(
                ArrayHelper::map(\conerd\humhub\modules\relationships\models\RelationshipType::find()->all(), 'id', 'type'),
                [
                    'prompt' => "Select Relationship Type",
                ]
            ) ?>

            <?= $form->field($relationship, 'other_user_id')->dropDownList(
                $friends,
                [
                    'prompt' => "Select user.",
                ]
            ) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/10/2018
 * Time: 7:49 PM
 */

/* @var $this yii\web\View */
/* @var $type \humhub\modules\relationships\models\RelationshipType */

use yii\widgets\ActiveForm;
use humhub\libs\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

?>
<div class="row">
    <div class="col-md-12 col-lg-6 modal-dialog modal-dialog-normal animated fadeIn">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php
                if ($type->id != null)
                {
                    echo "<h4>Update Relationship Type</h4>";
                }else
                    {
                        echo "<h4>Create Relationship Type</h4>";
                    }
                ?>

            </div>
            <div class="panel-body">

                <div class="relationship-category-form">

                    <?php
                        $url = Url::to(['admin/create-type']);
                        if ($type->id != null)
                        {
                            $url = Url::to(['admin/update-type', 'id' => $type->id]);
                        }
                    ?>


                    <?php $form = ActiveForm::begin(['action' => $url,'options' => ['method' => 'post']]); ?>

                    <?= $form->field($type, 'relationship_category')->dropDownList(
                        ArrayHelper::map(\humhub\modules\relationships\models\RelationshipCategory::find()->all(), 'id', 'category'),
                        ['prompt' => "Select Relationship Category"]

                    ) ?>

                    <?= $form->field($type, 'type')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>


                </div>
            </div>
        </div>
    </div>
</div>
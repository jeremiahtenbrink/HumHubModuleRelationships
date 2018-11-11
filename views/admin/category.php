<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/10/2018
 * Time: 7:18 PM
 */

/* @var $this yii\web\View */
/* @var $category conerd\humhub\modules\relationships\models\RelationshipCategory */

use yii\widgets\ActiveForm;
use humhub\libs\Html;
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-md-12 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php
                if ($category->id != null)
                {
                    echo "<h4>Update Category</h4>";
                }else
                    {
                        echo "<h4>Create Category</h4>";
                    }
                ?>

            </div>
            <div class="panel-body">

                <div class="relationship-category-form">

                    <?php
                        $url = Url::to(['admin/create-category']);
                        if ($category->id != null)
                        {
                            $url = Url::to(['admin/update-category', 'id' => $category->id]);
                        }
                    ?>


                    <?php $form = ActiveForm::begin(['action' => $url,'options' => ['method' => 'post']]); ?>

                    <?= $form->field($category, 'category')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
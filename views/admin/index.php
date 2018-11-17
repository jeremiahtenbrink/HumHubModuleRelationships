<?php

/* @var $this \yii\web\View */
/* @var $relationshipCategory \yii\data\ActiveDataProvider */
/* @var $relationshipType \yii\data\ActiveDataProvider */
/* @var $typeSearch \humhub\modules\relationships\models\RelationshipTypeSearch */
/* @var $categorySearch \humhub\modules\relationships\models\RelationshipCategorySearch */

use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;

?>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Relationships</strong> <?= "Configuration" ?></div>

        <div class="panel-body">
            <p><?= 'Below you will be able to add relationship categories and types.' ?></p>

        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Categories</h5>
                </div>
                <div class="panel-body">
                    <?php echo $this->render('relationship-category', [
                            'relationshipCategory' => $relationshipCategory,
                            'categorySearch' => $categorySearch,
                        ]); ?>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h5>Relationship Types</h5>
                </div>

                <div class="panel-body">
                    <?php echo $this->render('relationship-type', [
                        'relationshipType' => $relationshipType,
                        'typeSearch' => $typeSearch,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
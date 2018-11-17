<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/9/2018
 * Time: 9:13 PM
 */

/* @var $view \yii\web\View */
/* @var $relationshipType \yii\data\ActiveDataProvider */
/* @var $typeSearch \humhub\modules\relationships\models\RelationshipTypeSearch */

use yii\widgets\Pjax;
use humhub\widgets\GridView;
use yii\helpers\Url;
use humhub\libs\Html;
$categories = \yii\helpers\ArrayHelper::map(\humhub\modules\relationships\models\RelationshipCategory::find()->all(), 'id', 'category')
?>


<?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= \humhub\libs\Html::a('Create Relationship Type', ['create-type'], ['class' => 'btn btn-success', 'data-target' => '#globalModal']) ?>
    </p>

<?= GridView::widget([
    'dataProvider' => $relationshipType,
    'filterModel' => $typeSearch,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        //'id',
        [
            'attribute' => 'relationship_category',
            'label' => 'Relationship Category',
            'format' => 'text',
            'value' => function($model)
            {
              return \humhub\modules\relationships\models\RelationshipCategory::find()
                  ->where(['id' => $model->relationship_category])->one()->category;
            },

            'filter' => \kartik\widgets\Select2::widget([
                    'attribute' => 'relationship_category',
                'model' => $typeSearch,
                'value' => $typeSearch->relationship_category,
                'data' => $categories,
                'size' => \kartik\select2\Select2::MEDIUM,
                'options' => [
                    'placeholder' => 'Select Category',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]),
        ],
        'type',

        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'headerOptions' => ['style' => 'color:#337ab7'],
            'template' => '{update}{delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                        'title' => Yii::t('app', 'lead-update'),
                        'data-target' => '#globalModal'
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title' => Yii::t('app', 'lead-delete'),

                    ]);
                }

            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'update') {
                    $url = Url::to(['/relationships/admin/update-type', 'id' => $model->id]);
                    return $url;
                }
                if ($action === 'delete') {
                    $url = Url::to(['/relationships/admin/delete-type', 'id' => $model->id]);
                    return $url;
                }

            }
        ],
    ],
]); ?>
<?php Pjax::end(); ?>
<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/9/2018
 * Time: 9:12 PM
 */

/* @var $view \yii\web\View */
/* @var $relationshipCategory \yii\data\ActiveDataProvider */
/* @var $categorySearch \conerd\humhub\modules\relationships\models\RelationshipCategorySearch */

use yii\widgets\Pjax;
use humhub\widgets\GridView;
use humhub\libs\Html;
use yii\helpers\Url;

?>


<?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= \humhub\libs\Html::a('Create Relationship Category', ['create-category'], ['class' => 'btn btn-success']) ?>
    </p>

<?= GridView::widget([
    'dataProvider' => $relationshipCategory,
    'filterModel' => $categorySearch,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        //'id',
        'category',

        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'headerOptions' => ['style' => 'color:#337ab7'],
            'template' => '{update}{delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                        'title' => Yii::t('app', 'lead-update'),
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
                    $url = Url::to(['/relationships/admin/update-category', 'id' => $model->id]);
                    return $url;
                }
                if ($action === 'delete') {
                    $url = Url::to(['/relationships/admin/delete-category', 'id' => $model->id]);
                    return $url;
                }

            }
        ],
    ],
]); ?>
<?php Pjax::end(); ?>
<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/15/2018
 * Time: 3:54 PM
 */

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $action string */

use humhub\widgets\GridView;
use humhub\libs\Html;

\humhub\modules\relationships\assets\Assets::register($this);


?>

<div class="panel-body">
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [


            'send_user_username',
            'type',
            'recv_user_username',
            [
                'header' => Yii::t('FriendshipModule.base', 'Actions'),
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function () {
                        return;
                    },
                    'view' => function () {
                        return;
                    },
                    'delete' => function($url, $model, $action) {
                        return Html::a('Remove Relationship', ['/relationships/settings/delete', 'id' => $model['id'], 'approved' => $model['approved'] ],
                            ['class' => 'btn btn-danger btn-sm', 'data-method' => 'POST']);
                    }

                ],
            ]],
    ]);
    ?>

</div>

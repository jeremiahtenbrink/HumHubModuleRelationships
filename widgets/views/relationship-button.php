<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/11/2018
 * Time: 9:46 AM
 */

/* @var $relationship \humhub\modules\relationships\models\Relationship */
/* @var $userUrl string */

use humhub\libs\Html;
use yii\helpers\Url;


?>

<div class="btn-group pull-right">
    <?php $buttonUrl = Url::to(['/relationships/relationship/remove-relationships', 'id' => $relationship->id, 'url' => $userUrl]) ?>
    <?= Html::a('Remove Relationship/s', $buttonUrl, ['class' => 'btn btn-danger']) ?>
</div>
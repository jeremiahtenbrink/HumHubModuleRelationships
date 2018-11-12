<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/11/2018
 * Time: 9:46 AM
 */

/* @var $relationship \conerd\humhub\modules\relationships\models\Relationship */
/* @var $url string */

use humhub\libs\Html;
use yii\helpers\Url;
?>

<div class="btn-group pull-right">
    <?php $buttonUrl = Url::to(['/relationships/relationship/remove-relationship', 'id' => $relationship->id, 'url' => $url]) ?>
    <?= Html::a('Remove Relationship', $buttonUrl, ['class' => 'btn btn-danger']) ?>
</div>
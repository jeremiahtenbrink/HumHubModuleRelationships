<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/11/2018
 * Time: 9:46 AM
 */

/* @var $this \yii\web\View */
/* @var $relationship \humhub\modules\relationships\models\Relationship */
/* @var $userUrl string */

use humhub\libs\Html;
use yii\helpers\Url;


?>
<div class="btn-group pull-right">
   <?= Html::a('Approve Relationship/s', Url::to(['/relationships/relationship/approve-relationships', 'id' => $relationship->id, 'url'=> $userUrl]), ['class' => 'btn btn-success', 'style' => 'margin-right:10px']) ?>
   <?= Html::a('Deny Relationship/s', Url::to(['/relationships/relationship/deny-relationships', 'id' => $relationship->id, 'url' => $userUrl]), ['class' => 'btn btn-danger', 'style' => 'margin-right:10px']) ?>
</div>


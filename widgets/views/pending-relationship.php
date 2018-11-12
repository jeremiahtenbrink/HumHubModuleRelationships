<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/11/2018
 * Time: 9:46 AM
 */

/* @var $this \yii\web\View */
/* @var $relationship \conerd\humhub\modules\relationships\models\Relationship */
/* @var $url string */

use humhub\libs\Html;
use yii\helpers\Url;


?>
<div class="btn-group pull-right">
   <?= Html::a('Approve Relationship', Url::to(['/relationships/relationship/approve-relationship', 'id' => $relationship->id, 'url'=> $url]), ['class' => 'btn btn-success', 'style' => 'margin-right:10px']) ?>
   <?= Html::a('Deny Relationship', Url::to(['/relationships/relationship/deny-relationship', 'id' => $relationship->id, 'url' => $url]), ['class' => 'btn btn-danger', 'style' => 'margin-right:10px']) ?>
</div>


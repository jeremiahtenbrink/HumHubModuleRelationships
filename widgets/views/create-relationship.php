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

\conerd\humhub\modules\relationships\assets\Assets::register($this);
?>

<div class="btn-group pull-right">
    <?php $buttonUrl = Url::to(['/relationships/relationship/create-relationship']) ?>
    <?= Html::a('Create Relationship', $buttonUrl, ['class' => 'btn btn-default', 'data-target' => '#globalModal']) ?>
</div>


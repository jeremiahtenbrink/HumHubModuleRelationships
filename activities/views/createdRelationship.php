<?php

/* @var $this \humhub\modules\ui\view\components\View */
/* @var $contentContainer \humhub\modules\user\models\User */
/* @var $originator \humhub\modules\user\models\User */
/* @var $record \humhub\modules\activity\models\Activity */
/* @var $source \humhub\modules\relationships\models\Relationship */

use yii\helpers\Html;

echo $source->user->username . " created a new relationship with " . $source->otherUser->username;

?>

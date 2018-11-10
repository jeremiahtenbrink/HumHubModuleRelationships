<?php

use humhub\widgets\Button;

// Register our module assets, this could also be done within the controller
\conerd\humhub\modules\relationships\assets\Assets::register($this);

$displayName = (Yii::$app->user->isGuest) ? Yii::t('RelationshipsModule.base', 'Guest') : Yii::$app->user->getIdentity()->displayName;

// Add some configuration to our js module
$this->registerJsConfig("relationships", [
    'username' => (Yii::$app->user->isGuest) ? $displayName : Yii::$app->user->getIdentity()->username,
    'text' => [
        'hello' => Yii::t('RelationshipsModule.base', 'Hi there {name}!', ["name" => $displayName])
    ]
])

?>

<div class="panel-heading"><strong>Relationships</strong> <?= Yii::t('RelationshipsModule.base', 'overview') ?></div>

<div class="panel-body">
    <p><?= Yii::t('RelationshipsModule.base', 'Hello World!') ?></p>

    <?=  Button::primary(Yii::t('RelationshipsModule.base', 'Say Hello!'))->action("relationships.hello")->loader(false); ?></div>

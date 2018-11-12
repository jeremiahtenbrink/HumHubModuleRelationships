<?php

use humhub\widgets\Button;

// Register our module assets, this could also be done within the controller
\conerd\humhub\modules\relationships\assets\Assets::register($this);

$displayName = (Yii::$app->user->isGuest) ? 'Guest' : Yii::$app->user->getIdentity()->displayName;

// Add some configuration to our js module
$this->registerJsConfig("relationships", [
    'username' => (Yii::$app->user->isGuest) ? $displayName : Yii::$app->user->getIdentity()->username,
    'text' => [
        'hello' => 'Hi there {name}!', ["name" => $displayName]
    ]
])

?>

<div class="panel-heading"><strong>Relationships</strong> overview</div>

<div class="panel-body">
    <p><?= 'Hello World!' ?></p>

    <?=  Button::primary('Say Hello!')->action("relationships.hello")->loader(false); ?></div>

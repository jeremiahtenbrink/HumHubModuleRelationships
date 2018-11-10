<?php

use conerd\humhub\modules\relationships\Events;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\widgets\TopMenu;

return [
	'id' => 'relationships',
	'class' => 'conerd\humhub\modules\relationships\Module',
	'namespace' => 'conerd\humhub\modules\relationships',
	'events' => [
		[
			'class' => TopMenu::class,
			'event' => TopMenu::EVENT_INIT,
			'callback' => [Events::class, 'onTopMenuInit'],
		],
		[
			'class' => AdminMenu::class,
			'event' => AdminMenu::EVENT_INIT,
			'callback' => [Events::class, 'onAdminMenuInit']
		],
	],
];

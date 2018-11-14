<?php

use conerd\humhub\modules\relationships\Events;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\modules\user\models\User;

return [
	'id' => 'relationships',
	'class' => 'conerd\humhub\modules\relationships\Module',
	'namespace' => 'conerd\humhub\modules\relationships',
	'events' => [
		[
			'class' => AdminMenu::class,
			'event' => AdminMenu::EVENT_INIT,
			'callback' => [Events::class, 'onAdminMenuInit']
		],
        [User::class, User::EVENT_BEFORE_SOFT_DELETE, [Events::class, 'onUserSoftDelete']],
        [User::class, User::EVENT_BEFORE_DELETE, [Events::class, 'onUserDelete']],
	],
];

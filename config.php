<?php

use humhub\modules\relationships\Events;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\modules\user\models\User;
use humhub\modules\user\widgets\AccountMenu;

return [
	'id' => 'relationships',
	'class' => 'humhub\modules\relationships\Module',
	'namespace' => 'humhub\modules\relationships',
	'events' => [
		[
			'class' => AdminMenu::class,
			'event' => AdminMenu::EVENT_INIT,
			'callback' => [Events::class, 'onAdminMenuInit']
		],
        [User::class, User::EVENT_BEFORE_SOFT_DELETE, [Events::class, 'onUserSoftDelete']],
        [User::class, User::EVENT_BEFORE_DELETE, [Events::class, 'onUserDelete']],
        ['class' => AccountMenu::class, 'event' => AccountMenu::EVENT_INIT, 'callback' => [Events::class, 'onAccountMenuInit']],
	],
];

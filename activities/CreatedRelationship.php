<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace conerd\humhub\modules\relationships\activities;

use humhub\modules\activity\components\BaseActivity;
use humhub\modules\content\models\Content;

/**
 * Activity when one user accepts the relationship a user was trying to create.
 *
 * @author CO_Nerd revised code from
 * @author luke
 */
class CreatedRelationship extends BaseActivity
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'relationships';

    /**
     * @inheritdoc
     */
    public $viewName = "createdRelationship";

    /**
     * @inheritdoc
     */
    public $visibility = Content::VISIBILITY_PUBLIC;


}

<?php

use humhub\widgets\FooterMenu;

?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?php
            echo \humhub\modules\user\widgets\AccountMenu::widget(); ?>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>User Relationships</h4>

                    </div>
                    <div class="panel-body">
                        <?php echo \humhub\modules\relationships\widgets\SettingsMenue::widget()?>
                    </div>
                </div>


                <?php echo $content; ?>
            </div>
            <?= FooterMenu::widget(['location' => FooterMenu::LOCATION_FULL_PAGE]); ?>
        </div>
    </div>
</div>

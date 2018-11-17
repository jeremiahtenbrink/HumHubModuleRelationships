<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/10/2018
 * Time: 8:55 PM
 */

/* @var $relationships \humhub\modules\relationships\models\Relationship[] */
/* @var $relationshipTypes array[id => string] */
/* @var $user \humhub\modules\user\models\User */
/* @var $isProfileOwner bool */
/* @var $relationshipUsers array[other_user_id => User] */
/* @var $userUrl string */

use yii\helpers\Url;
use humhub\libs\Html;


?>

<div class="relationship-widget">
    <div class="panel panel-default">

        <div class="panel-heading">
            <h4>User Relationships <?= \humhub\modules\relationships\widgets\RelationshipButton::widget(['user' => $user, 'url' => $userUrl]) ?> </h4>

        </div>

        <div class="panel-body">
            <?php

                echo "<table class='table'>";
                echo "<tbody>";

                foreach ($relationships as $relationship)
                {
                    echo "<tr>";

                    if ($relationship->approved){
                        //Approved relationships get shown to everyone.
                        $otherUser = $relationshipUsers[$relationship->other_user_id];
                        /* @var $otherUser \humhub\modules\user\models\User */

                        echo "<td>" . $relationshipTypes[$relationship->relationship_type] . "</td><td> " . Html::a($otherUser->displayName, ['/u/' . $otherUser->username]) . "</td>";
                        if ($relationship->other_user_id == Yii::$app->user->id || $isProfileOwner)
                        {
                            echo "<td></td>";
                            $otherUrl = Url::to(['/relationships/relationship/remove-relationship', 'id' => $relationship->id, 'url' => $userUrl]);
                            echo "<td>" . Html::a('<span class="glyphicon glyphicon-trash"></span>', $otherUrl) . "</td>";
                        }
                    }else if ($relationship->other_user_id == Yii::$app->user->id || $isProfileOwner)
                    {
                        // profile owner and other person in the relationship can see none approved relationships
                        $otherUser = $relationshipUsers[$relationship->other_user_id];
                        /* @var $relationshipType \humhub\modules\relationships\models\RelationshipType */
                        $relationshipType = \humhub\modules\relationships\models\RelationshipType::find()
                            ->where(['id' => $relationship->relationship_type])->one();

                        echo "<td>" . $relationshipType->type . "</td><td> " . $otherUser->displayName . "</td><td> Pending...</td>";


                        $url = Url::to(['/relationships/relationship/remove-relationship', 'id' => $relationship->id, 'url' => $userUrl]);
                        echo "<td>" . Html::a('<span class="glyphicon glyphicon-trash"></span>', $url) . "</td>";


                        if (!$isProfileOwner)
                        {
                            $url = Url::to(['/relationships/relationship/approve-relationship', 'id' => $relationship->id, 'url' => $userUrl]);
                            echo "<td>" . Html::a('<span class="glyphicon glyphicon-thumbs-up"></span>', $url, ['style' => 'word-spacing:10px']) . "</td>";
                        }



                    }

                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            ?>
        </div>

    </div>
</div>



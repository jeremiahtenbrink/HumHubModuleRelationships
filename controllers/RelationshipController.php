<?php

namespace conerd\humhub\modules\relationships\controllers;

use conerd\humhub\modules\relationships\models\Relationship;
use conerd\humhub\modules\relationships\models\RelationshipCategory;
use conerd\humhub\modules\relationships\models\RelationshipType;
use humhub\modules\user\models\User;
use humhub\components\Controller;
use humhub\modules\friendship\models\Friendship;
use humhub\modules\user\controllers\ProfileController;
use Yii;

class RelationshipController extends Controller
{

    public $subLayout = "@relationships/views/layouts/default";

    /**
     * Renders the index view for the module
     *
     * @return string
     */

    public function actionCreateRelationship()
    {
        $relationship = new Relationship();
        $relationshipCategory = new RelationshipCategory();
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();

        if ($relationship->load(Yii::$app->request->post())){

            $relationship->user_id = Yii::$app->user->id;

            if ($relationship->save()){

                /* @var $user User */
                return $this->redirect(['/u/' . $user->username . '/user/profile/home']);
            }
        }

        $friendships = Friendship::find()->where(['user_id' => Yii::$app->user->id])->all();
        $friends = [];

        foreach ($friendships as $friend)
        {
            /* @var $friend Friendship */
            /* @var $user User */
            $user = User::find()->where(['id' => $friend->friend_user_id])->one();
            $friends[$friend->friend_user_id] = $user->getDisplayName();
        }

        return $this->render('create-relationship', [
            'relationship' => $relationship,
            'relationshipCategory' => $relationshipCategory,
            'friends' => $friends,
        ]);
    }

    public function actionGetTypes($category)
    {
        $relationshipTypes = RelationshipType::find()->where(['relationship_category' => $category])->all();

        if ($relationshipTypes)
        {

            foreach ($relationshipTypes as $type)
            {
                /* @var $type \conerd\humhub\modules\relationships\models\RelationshipType */
                echo "<option value='" . $type->id . "'>" . $type->type . "</option>";
            }
        }else {
            echo "<option>-</option>";
        }


    }

    public function actionDenyRelationship($id, $url)
    {
        $relationship = Relationship::find()->where(['id' => $id])->one();
        if ($relationship)
        {
            $relationship->afterDeny();
            $relationship->delete();

        }

        return $this->redirect($url);
    }

    public function actionRemoveRelationship($id, $url)
    {
        $relationship = Relationship::find()->where(['id' => $id])->one();
        if ($relationship)
        {
            /* @var $relationship Relationship */
            if(Yii::$app->user->id == $relationship->user_id)
            {
                $relationship->userRemovedRelationship();
            }else
            {
                $relationship->otherUserRemovedRelationship();
            }

            $relationship->delete();
        }

        return $this->redirect($url);
    }

    public function actionApproveRelationship($id, $url)
    {
        $relationship = Relationship::find()->where(['id' => $id])->one();
        /* @var $relationship \conerd\humhub\modules\relationships\models\Relationship */
        $relationship->approved = 1;
        if ($relationship->save())
        {
            return $this->redirect($url);
        }

        return $this->redirect($url);

    }

}


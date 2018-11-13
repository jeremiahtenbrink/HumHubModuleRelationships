<?php

namespace conerd\humhub\modules\relationships\controllers;

use conerd\humhub\modules\relationships\models\Relationship;
use conerd\humhub\modules\relationships\models\RelationshipCategory;
use conerd\humhub\modules\relationships\models\RelationshipType;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\models\Content;
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

        if (Yii::$app->request->isAjax)
        {
            return $this->renderAjax('create-relationship', [
                'relationship' => $relationship,
                'relationshipCategory' => $relationshipCategory,
                'friends' => $friends,
            ]);
        }

        $this->layout = "default";

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
        $relatinoship = Relationship::find()->where(['id' => $id])->one();
        $relatinoship->delete();
        $relatinoship->afterDelete();
        return $this->redirect($url);

    }


    public function actionDenyRelationships($id, $url)
    {
        $relationship = Relationship::find()->where(['id' => $id])->one();
        /* @var $relationship Relationship */

        $relationships = Relationship::find()->where(['user_id' => $relationship->user_id])->andWhere(['other_user_id' => $relationship->other_user_id])->all();

        foreach($relationships as $relationship)
        {
            $relationship->delete();
            $relationship->afterDelete();
        }

        return $this->redirect($url);
    }

    public function actionRemoveRelationship($id, $url)
    {
        $relationship = Relationship::find()->where(['id' => $id])->one();
        if ($relationship) {
            /* @var $relationship Relationship */
            if (Yii::$app->user->id == $relationship->user_id) {
                $relationship->userRemovedRelationship();
            } else {
                $relationship->otherUserRemovedRelationship();
            }

            $relationship->delete();
        }

        return $this->redirect($url);
    }

    public function actionRemoveRelationships($id, $url)
    {
        /* @var $relationship Relationship */
        $relationship = Relationship::find()->where(['id' => $id])->one();

        $relationships = Relationship::find()->where(['user_id' => $relationship->user_id])
            ->andWhere(['other_user_id' => $relationship->other_user_id])->all();

        foreach ($relationships as $relationship) {
            /* @var $relationship Relationship */
            if (Yii::$app->user->id == $relationship->user_id) {
                $relationship->userRemovedRelationship();
            } else {
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
        $relationship->content->visibility = Content::VISIBILITY_PUBLIC;
        $relationship->content->container = User::find()->where(['id' => $relationship->user_id])->one();


        if ($relationship->save())
        {
            return $this->redirect($url);
        }

        return $this->redirect($url);

    }

    public function actionApproveRelationships($id, $url)
    {
        $relationship = Relationship::find()->where(['id' => $id])->one();

        /* @var $relationship \conerd\humhub\modules\relationships\models\Relationship */
        $relationships = Relationship::find()->where(['user_id' => $relationship->user_id])
            ->andWhere(['other_user_id' => $relationship->other_user_id])->all();

        foreach ($relationships as $relationship)
        {
            $relationship->approved = 1;
            $relationship->content->visibility = Content::VISIBILITY_PUBLIC;
            $relationship->content->container = User::find()->where(['id' => $relationship->user_id])->one();
            $relationship->save();
        }

        return $this->redirect($url);
    }

}


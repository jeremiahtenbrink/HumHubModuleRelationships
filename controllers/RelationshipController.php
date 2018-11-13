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

/**
 * @author CO_Nerd
 * Class RelationshipController
 * @package conerd\humhub\modules\relationships\controllers
 */
class RelationshipController extends Controller
{

    public $subLayout = "@relationships/views/layouts/default";


    /**
     * Renders the create relationship form for the user to create a relationship.
     * @return RelationshipController|string|\yii\console\Response|\yii\web\Response
     */
    public function actionCreateRelationship()
    {

        $relationship = new Relationship();

        $relationshipCategory = new RelationshipCategory();

        $user = User::find()->where(['id' => Yii::$app->user->id])->one();

        // load relationship modal if located in post
        if ($relationship->load(Yii::$app->request->post())){

            // assign the creator of the relationship to the current user
            $relationship->user_id = Yii::$app->user->id;

            if ($relationship->save()){

                // if the relationship has saved correctly send the user back to his profile.
                /* @var $user User */
                return $this->redirect(['/u/' . $user->username . '/user/profile/home']);
            }
        }

        // find all the users friends for the relationship drop down.
        // todo: Change the drop down in the view to a search drop down.
        $friendships = Friendship::find()->where(['user_id' => Yii::$app->user->id])->all();
        $friends = [];

        foreach ($friendships as $friend)
        {
            // create a array of the friends id assigned to the friends username for the user to pick
            // the friend to create the relationship with.
            /* @var $friend Friendship */
            /* @var $user User */
            $user = User::find()->where(['id' => $friend->friend_user_id])->one();
            $friends[$friend->friend_user_id] = $user->getDisplayName();
        }

        // if ajax then render ajax.
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

    /**
     * Generates the list of available relationship types based on the user selected drop down of relationship category.
     * Used for ajax call from jquery.
     * Returns the available options in html code.
     * @param $category
     */
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

    /**
     * This function denies the creation of the relationship and deletes the relationship from
     * the database.
     * @param $id
     * @param $url
     * @return RelationshipController|\yii\console\Response|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDenyRelationship($id, $url)
    {
        $relatinoship = Relationship::find()->where(['id' => $id])->one();
        $relatinoship->delete();
        $relatinoship->afterDelete();
        return $this->redirect($url);

    }


    /**
     * Same as denyRelationship except it searches for all relationships between the two users and removes all of them.
     * @param $id
     * @param $url
     * @return RelationshipController|\yii\console\Response|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
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

    /**
     * Removes relationship from the database. This method is called when the person who created the relationship
     * is the one that removes the relationship.
     * @param $id
     * @param $url
     * @return RelationshipController|\yii\console\Response|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
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

    /**
     * Removes all relationships.
     * @param $id
     * @param $url
     * @return RelationshipController|\yii\console\Response|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
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

    /**
     * Approves of the relationship from the other user, not from the originator.
     * Once the relationship is approved. The modal will then create the activity.
     * @param $id
     * @param $url
     * @return RelationshipController|\yii\console\Response|\yii\web\Response
     */
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

    /**
     * Approves of all the relationships like approve relationship.
     * @param $id
     * @param $url
     * @return RelationshipController|\yii\console\Response|\yii\web\Response
     */
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


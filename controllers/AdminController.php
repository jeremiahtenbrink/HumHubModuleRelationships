<?php

namespace humhub\modules\relationships\controllers;

use humhub\modules\relationships\migration\Enable;
use humhub\modules\relationships\models\RelationshipCategory;
use humhub\modules\relationships\models\RelationshipCategorySearch;
use humhub\modules\relationships\models\RelationshipType;
use humhub\modules\relationships\models\RelationshipTypeSearch;
use humhub\modules\admin\components\Controller;
use Yii;
use yii\helpers\Url;

/**
 * @author CO_Nerd
 * Class AdminController
 * @package humhub\modules\relationships\controllers
 */

class AdminController extends Controller
{

    /**
     * Render admin only page
     *
     * @return string
     */
    public function actionIndex()
    {
        $typeSearch = new RelationshipTypeSearch();
        $relationshipType = $typeSearch->search(Yii::$app->request->queryParams);

        $categorySearch = new RelationshipCategorySearch();
        $relationshipCategory = $categorySearch->search(Yii::$app->request->queryParams);

        return $this->render('index', [
           'relationshipType' => $relationshipType,
            'typeSearch' => $typeSearch,
            'relationshipCategory' => $relationshipCategory,
            'categorySearch' => $categorySearch
        ]);

    }

    /**
     * This function will locate the Relationship Category in the database
     * and then delete the category. It locates the Category by the category id.
     * Then it reloads the index page again with the deleted record gone.
     *
     * @param $id
     * @return AdminController|\yii\console\Response|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteCategory($id)
    {
        $category = RelationshipCategory::find()->where(['id' => $id])->one();
        $category->delete();
        return $this->redirect(['index']);
    }

    /**
     * This function will delete the Relationship Type from the database. It locates
     * the relationship type by the relationship type id. Then it reloads the index page
     * with the relationship type removed.
     *
     * @param $id
     * @return AdminController|\yii\console\Response|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteType($id)
    {
        $type = RelationshipType::find()->where(['id' => $id])->one();
        $type->delete();
        return $this->redirect(['index']);
    }

    /**
     * Updates the Relationship category in the db from the category id.
     * @param $id
     * @return AdminController|string|\yii\console\Response|\yii\web\Response
     */
    public function actionUpdateCategory($id)
    {
        $category = RelationshipCategory::find()->where(['id' => $id])->one();

        if ($category->load(Yii::$app->request->post()) && $category->save())
        {
            return $this->redirect(['index']);
        }

        if (Yii::$app->request->isAjax)
        {
            return $this->renderAjax('category', [
                'category' => $category,
            ]);
        }

        return $this->render('category',[
            'category' => $category,
        ]);

    }

    /**
     * Creates a new relationship Category in the db.
     * @return AdminController|string|\yii\console\Response|\yii\web\Response
     */
    public function actionCreateCategory()
    {
        $category = new RelationshipCategory();

        if ($category->load(Yii::$app->request->post()) && $category->save())
        {
            return $this->redirect(['index']);
        }

        if (Yii::$app->request->isAjax)
        {
            return $this->renderAjax('category', [
                'category' => $category,
            ]);
        }

        return $this->render('category', [
            'category' => $category,
        ]);
    }

    /**
     * Creates a new relationship type in the db.
     * @return AdminController|string|\yii\console\Response|\yii\web\Response
     */
    public function actionCreateType()
    {
        $type = new RelationshipType();

        if ($type->load(Yii::$app->request->post()) && $type->save())
        {
            return $this->redirect(['index']);
        }

        if (Yii::$app->request->isAjax)
        {
            return $this->render('type', [
                'type' => $type,
            ]);
        }

        return $this->render('type', [
            'type' => $type,
        ]);
    }

    /**
     * Updates a relationship Type in the database from the already created relationship type.
     * @param $id
     * @return AdminController|string|\yii\console\Response|\yii\web\Response
     */
    public function actionUpdateType($id)
    {
        $type = RelationshipType::find()->where(['id' => $id])->one();

        if ($type->load(Yii::$app->request->post()) && $type->save())
        {
            return $this->redirect('index');
        }

        if (Yii::$app->request->isAjax)
        {
            return $this->render('type', [
                'type' => $type,
            ]);
        }

        return $this->render('type',[
            'type' => $type,
        ]);

    }

    public function actionEnable()
    {
        $enable = new Enable();
        $enable->up();
        return true;
    }

}


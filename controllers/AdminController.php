<?php

namespace conerd\humhub\modules\relationships\controllers;

use conerd\humhub\modules\relationships\models\RelationshipCategory;
use conerd\humhub\modules\relationships\models\RelationshipCategorySearch;
use conerd\humhub\modules\relationships\models\RelationshipType;
use conerd\humhub\modules\relationships\models\RelationshipTypeSearch;
use humhub\modules\admin\components\Controller;
use Yii;

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
        return $this->redirect('index');
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
        return $this->redirect('index');
    }

    public function actionUpdateCategory($id)
    {
        $category = RelationshipCategory::find()->where(['id' => $id])->one();

        if ($category->load(Yii::$app->request->post()) && $category->save())
        {
            return $this->redirect('index');
        }

        return $this->render('category',[
            'category' => $category,
        ]);

    }

    public function actionCreateCategory()
    {
        $category = new RelationshipCategory();

        if ($category->load(Yii::$app->request->post()) && $category->save())
        {
            return $this->redirect('index');
        }

        return $this->render('category', [
            'category' => $category,
        ]);
    }

    public function actionCreateType()
    {
        $type = new RelationshipType();

        if ($type->load(Yii::$app->request->post()) && $type->save())
        {
            return $this->redirect('index');
        }

        return $this->render('type', [
            'type' => $type,
        ]);
    }

    public function actionUpdateType($id)
    {
        $type = RelationshipType::find()->where(['id' => $id])->one();

        if ($type->load(Yii::$app->request->post()) && $type->save())
        {
            return $this->redirect('index');
        }

        return $this->render('type',[
            'type' => $type,
        ]);

    }

}


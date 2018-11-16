<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/15/2018
 * Time: 5:48 PM
 */

namespace conerd\humhub\modules\relationships\controllers;

use conerd\humhub\modules\relationships\models\SettingsForm;
use conerd\humhub\modules\relationships\models\User;
use humhub\components\Controller;
use conerd\humhub\modules\relationships\models\Relationship;
use humhub\modules\content\models\ContentContainer;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * @author CO_Nerd
 * Class SettingsController
 * @package conerd\humhub\modules\relationships\controllers
 */
class SettingsController extends Controller
{

    public function actionManage(){

        $this->subLayout = '_layout';
        $settingsForm = new SettingsForm();

        $user = User::find()->where(['id' => Yii::$app->user->id])->one();

        $settings = $this->module->settings->contentContainer($user)->get('relationshipSettings');

        if ($settings == null){
            $settings = $this->module->getDefaultUserSettings();
            $this->module->settings->contentContainer($user)->set('relationshipSettings', $settings);
        }

        $settings = \GuzzleHttp\json_decode($settings);

        foreach ($settings as $key => $value){
            if ($settingsForm->hasProperty($key))
            {
                $settingsForm[$key] = $value;
            }


        }

        return $this->render('settings', [
            'settingsForm' => $settingsForm,
        ]);
    }

    public function actionSettingsChanged(){

        $formValue = Yii::$app->request->get('value');
        $dataTarget = Yii::$app->request->get('dataTarget');

        $start = strpos($dataTarget, '[');
        $end = strpos($dataTarget, ']');
        $length = $end - $start -1;
        $dataTarget = substr($dataTarget, $start +1, $length );

        $user = User::find()->where(['id' => Yii::$app->user->id])->one();

        $settings = $this->module->settings->contentContainer($user)->get('relationshipSettings');

        $settings = \GuzzleHttp\json_decode($settings, true);

        foreach ($settings as $key => $value){
            if ($key == $dataTarget){
                $settings[$key] = $formValue;
            }
        }

        $settings = \GuzzleHttp\json_encode($settings);

        $this->module->settings->contentContainer($user)->set('relationshipSettings', $settings);

    }

    public function actionShowRelationships()
    {
        $this->subLayout = "_layout";
        $query = Relationship::getAllRelationships();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('show-relationships', [
           'dataProvider' => $dataProvider,
            'action' => 'show-relationships'
        ]);

    }

    public function actionPendingRelationships(){
        $this->subLayout = "_layout";
        $query = Relationship::getAllPendingRelationshipsQuery();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('show-relationships', [
            'dataProvider' => $dataProvider,
            'action' => 'pending-relationships'
        ]);
    }

    public function actionDelete()
    {

        $id = Yii::$app->request->get('id');
        $approved = Yii::$app->request->get('approved');

        $relationship = Relationship::find()->where(['id' => $id])->one();
        $relationship->delete();

        if ($approved){
            return $this->redirect('show-relationships');
        }
        return $this->redirect('pending-relationships');
    }

}
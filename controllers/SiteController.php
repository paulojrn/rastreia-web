<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\LoginForm;
use yii\data\ActiveDataProvider;
use app\models\Webcontent;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->actionUrls();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }
    
    /**
     * Urls action.
     *
     * @return Response
     */
    public function actionUrls(){
        $dataProvider = new ActiveDataProvider([
            'query' => Webcontent::find()->where('user_id='.Yii::$app->user->id),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        return $this->render('urls', ['dataProvider' => $dataProvider]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    /**
     * Save url
     * @return Json
     */
    public function actionSaveUrl(){
        $post = Yii::$app->request->post();        
        $model = new Webcontent;
        $msg = ['save' => true];
        
        $model->setAttribute('url', $post['url']);
        $model->setAttribute('progress_status', $post['progress_status']);
        $model->setAttribute('user_id', $post['user_id']);

        if(!$model->save()){
            $msg = ['save' => false];
        }

        echo json_encode($msg);
    }
}

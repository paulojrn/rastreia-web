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
     * Get HTML response
     * @param integer $id Webcontent id
     * @return Response
     */
    public function actionResponse($id){
        $model = Webcontent::find()->where('id = '.$id)->one();
        $html = base64_decode($model->getAttribute('response'));
        
        return $this->render('response', ['html' => $html]);
    }
    
    /**
     * Save url
     * @return Json
     */
    public function actionSaveUrl(){    
        $post = Yii::$app->request->post();        
        $model = new Webcontent;
        $msg = ['save' => true];
        
        $pageData = $this->getPageData($post['url']);
        
        $model->setAttribute('url', $post['url']);
        $model->setAttribute('progress_status', $post['progress_status']);
        $model->setAttribute('user_id', $post['user_id']);
        $model->setAttribute('http_status', $pageData['status']);
        $model->setAttribute('response', base64_encode($pageData['html']));

        if(!$model->save()){
            $msg = ['save' => false];
        }

        echo json_encode($msg);
    }
    
    /**
     * Get page data
     * @param string $url
     * @return array
     */
    private function getPageData($url){
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

        $html = curl_exec($c);

        if (curl_error($c))
            die(curl_error($c));

        $status = curl_getinfo($c, CURLINFO_HTTP_CODE);

        curl_close($c);
        
        return ['status' => $status, 'html' => $html];
    }
}

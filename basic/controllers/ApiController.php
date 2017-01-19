<?php
namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\auth\HttpBasicAuth;

use app\models\ApacheLog;
use app\models\ApacheLogSearch;

class ApiController extends ActiveController
{
    public $modelClass = 'app\models\ApacheLog';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];

        return $behaviors;
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        # 'хардкодим' json как формат ответа, что бы
        # фильтр ContentNegotiator нам не установил в качестве
        # формата ответа
        $response = Yii::$app->getResponse();
        $response->acceptMimeType = 'application/json';
        $response->format = Response::FORMAT_JSON;

        return true;
    }
    
    public function prepareApacheLogDataProvider()
    {
        $searchModel = new ApacheLogSearch();

        $get = Yii::$app->request->get();
        return $searchModel->search($get);
    }

    public function actions()
    {
        $actions = parent::actions();
        $indexAction = $actions['index'];
        $indexAction['prepareDataProvider'] = [$this, 'prepareApacheLogDataProvider'];

        return ['index' => $indexAction];
    }
}

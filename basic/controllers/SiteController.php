<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ApacheLog;
use app\models\ApacheLogSearch;

class SiteController extends Controller
{
    public $defaultAction = 'main';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'allow' => true,
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Главная страница
     *
     * @return string
     */
    public function actionMain()
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->refresh();
            }

            return $this->render('login', ['model' => $model]);
        }

        $searchModel = new ApacheLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('main', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}

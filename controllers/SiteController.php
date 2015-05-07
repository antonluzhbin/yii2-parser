<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Catalog;
use app\models\CatalogSearch;
use app\models\CatalogSearchSection;

class SiteController extends Controller
{
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
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionIndex()
    {
        return $this->actionCatalog();
    }

    public function actionCatalog()
    {        
        $searchModel = new CatalogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
    
        return $this->render('catalog', array(
            'dataProvider' => $dataProvider,
            'model' => $searchModel
        ));
    }
    
    public function actionParser()
    {
        $catalog = new Catalog;
        $data = $catalog->parse();
    
        return $this->render('parser', array(
            'data' => $data
        ));
    }
    
    public function actionReport()
    {
        $searchModel = new CatalogSearchSection();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
    
        return $this->render('report', array(
            'dataProvider' => $dataProvider,
            'model' => $searchModel
        ));
    }
}

<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Image;
use yii\data\ActiveDataProvider;
use app\models\ImagesSelect;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * Показать в виде галереи.
     *
     * @return string
     */
    public function actionIndex()
    {
        $selectModel = new ImagesSelect;
        if (Yii::$app->user->isGuest) {
            $query = Image::find()->where('free = 1');
        } else {
            if ($selectModel->load(Yii::$app->request->get()) && $selectModel->validate()) {
                $query = Image::findFilters($selectModel);
            } else {
                $query = Image::find();
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'selectModel' => $selectModel,

        ]);
    }

}

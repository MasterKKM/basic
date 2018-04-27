<?php

namespace app\controllers;

use Yii;
use app\models\Image;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * ImageController implements the CRUD actions for Image model.
 */
class ImageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'delete', 'update', 'load'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'delete', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['load'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Image models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Image::find()->where('user_id = :id', [':id' => Yii::$app->user->getId()]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Image model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException Если попытка доступа к чужой картинке.
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id == Yii::$app->user->getId()) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
        throw new ForbiddenHttpException('Это не Ваша галерея.');
    }

    /**
     * Finds the Image model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Image the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Image::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Creates a new Image model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Image();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file !== NULL) {
                $model->user_id = Yii::$app->user->getId();
                $model->file_name = $model->file->baseName . '.' . $model->file->extension;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Image model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException Если попытка доступа к чужой картинке.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->user_id == Yii::$app->user->getId()) {
            if ($model->load(Yii::$app->request->post())) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->file !== NULL) {
                    $model->user_id = Yii::$app->user->getId();
                    $model->file_name = $model->file->baseName . '.' . $model->file->extension;
                }
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        throw new ForbiddenHttpException('Это не Ваша галерея.');
    }

    /**
     * Deletes an existing Image model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id == Yii::$app->user->getId()) {
            $model->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Выдача картинки загрузженной в галерею.
     * @param $name string Имя изображения.
     * @throws NotFoundHttpException Если картинка не неайдена.
     */
    public function actionLoad($name)
    {
        if (Yii::$app->user->isGuest) {
            $tab = Image::nameToId($name);
            $id = $tab['id'];
            $model = Image::findOne($id);
            if (empty($model) || !$model->free) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
        $fileName = (new Image())->getThumb($name);
        if ($fileName === NULL) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        header('Content-Type: image/png');
        header("Content-Transfer-Encoding: binary ");

        readfile($fileName);
    }
}

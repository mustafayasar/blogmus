<?php
namespace backend\controllers;

use backend\models\CategoryForm;
use backend\models\CategorySearch;
use backend\models\PostForm;
use backend\models\PostSearch;
use backend\models\TagForm;
use backend\models\TagSearch;
use common\models\Category;
use common\models\Post;
use common\models\Tag;
use Yii;
use yii\base\BaseObject;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;


/**
 * Tag controller
 */
class TagController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions'   => ['index', 'view', 'create', 'update', 'delete'],
                        'allow'     => true,
                        'roles'     => ['@'],
                    ],
                ],
            ],
            'verbs'     => [
                'class' => VerbFilter::class,
                'actions'   => [
                    'create'    => ['get', 'post'],
                    'update'    => ['get', 'post'],
                    'delete'    => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel   = new TagSearch();

        return $this->render('index', [
            'dataProvider'  => $searchModel->search(Yii::$app->request->queryParams),
            'filterModel'   => $searchModel
        ]);
    }

    /**
     * Displays a single Tag model.
     *
     * @param integer $id
     *
     * @return string
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        $model  = $this->findModel($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * @return string|yii\web\Response
     */
    public function actionCreate()
    {
        $model  = new TagForm();

        if ($model->load(Yii::$app->request->post()) && $response = $model->save())
        {
            if ($response) {
                Yii::$app->session->addFlash('success', 'Etiket oluşturuldu.');

                return $this->redirect(['view', 'id' => $model->_item->id]);
            }
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * @param integer $id
     *
     * @return Response|string
     *
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = new TagForm();

        $model->findItem($id);

        if ($model->load(Yii::$app->request->post()) && $response = $model->save())
        {
            if ($response) {
                Yii::$app->session->addFlash('success', 'Etiket başarıyla güncellendi.');

                return $this->redirect(['view', 'id' => $model->_item->id]);
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * @param integer $id
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        $model          = $this->findModel($id);
        $model->status  = Tag::STATUS_DELETED;

        if ($response = $model->save())
        {
            if ($response) {
                Yii::$app->session->addFlash('success', 'Etiket başarıyla silindi.');
            } else {
                Yii::$app->session->addFlash('error', 'Etiket silinemedi.');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Tag the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Tag
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Etiket Bulunamadı.');
    }
}

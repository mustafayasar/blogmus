<?php
namespace backend\controllers;

use backend\models\PostForm;
use backend\models\PostSearch;
use common\models\Post;
use common\models\Student;
use common\models\Teacher;
use Yii;
use yii\base\BaseObject;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;


/**
 * Page controller
 */
class PageController extends Controller
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
                        'actions'   => ['index', 'view','create', 'update', 'delete'],
                        'allow'     => true,
                        'roles'     => ['@'],
                    ],
                ],
            ],
            'verbs'     => [
                'class' => VerbFilter::class,
                'actions'   => [
                    'logout'    => ['post'],
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
        $searchModel   = new PostSearch();

        return $this->render('index', [
            'dataProvider'  => $searchModel->search(Yii::$app->request->queryParams, Post::POST_TYPE_PAGE),
            'filterModel'   => $searchModel
        ]);
    }

    /**
     * Displays a single Post model.
     *
     * @param integer $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @throws BadRequestHttpException
     */
    public function actionView(int $id)
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
        $model          = new PostForm();
        $model->type    = Post::POST_TYPE_PAGE;

        if ($model->load(Yii::$app->request->post()) && $response = $model->save())
        {
            if ($response) {
                Yii::$app->session->addFlash('success', 'İçerik oluşturuldu.');

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
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = new PostForm();

        $model->findItem($id);

        if ($model->load(Yii::$app->request->post()) && $response = $model->save())
        {
            if ($response) {
                Yii::$app->session->addFlash('success', 'İçerik başarıyla güncellendi.');

                return $this->redirect(['view', 'id' => $model->_item->id]);
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }



    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Post the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Post
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Kullanıcı Bulunamadı.');
    }
}

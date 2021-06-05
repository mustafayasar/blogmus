<?php
namespace backend\controllers;

use backend\models\CategoryForm;
use backend\models\CategorySearch;
use backend\models\PostForm;
use backend\models\PostSearch;
use common\models\Category;
use common\models\Post;
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
 * Category controller
 */
class CategoryController extends Controller
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
        $searchModel   = new CategorySearch();

        return $this->render('index', [
            'dataProvider'  => $searchModel->search(Yii::$app->request->queryParams),
            'filterModel'   => $searchModel,
            'categories'    => Category::getArray()
        ]);
    }

    /**
     * Displays a single Category model.
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
        $model  = new CategoryForm();

        if ($model->load(Yii::$app->request->post()) && $response = $model->save())
        {
            if ($response) {
                Yii::$app->session->addFlash('success', 'Kategori oluşturuldu.');

                return $this->redirect(['view', 'id' => $model->_item->id]);
            }
        }

        return $this->render('create', [
            'model'         => $model,
            'categories'    => Category::getArray()
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
        $model = new CategoryForm();

        $model->findItem($id);

        if ($model->load(Yii::$app->request->post()) && $response = $model->save())
        {
            if ($response) {
                Yii::$app->session->addFlash('success', 'Kategori başarıyla güncellendi.');

                return $this->redirect(['view', 'id' => $model->_item->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categories'    => Category::getArray($id)
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
        $model->status  = Category::STATUS_DELETED;

        if ($response = $model->save())
        {
            Category::updateAll(['status' => Category::STATUS_DELETED],  ['parent_id' => $id]);

            if ($response) {
                Yii::$app->session->addFlash('success', 'Kategori başarıyla silindi.');
            } else {
                Yii::$app->session->addFlash('error', 'Kategori silinemedi.');
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
     * @return Category the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Category
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Kategori Bulunamadı.');
    }
}

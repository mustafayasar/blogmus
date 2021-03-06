<?php
namespace backend\controllers;

use backend\models\PostForm;
use backend\models\PostSearch;
use common\models\Category;
use common\models\Post;
use common\models\PostCategory;
use common\models\PostTag;
use common\models\Tag;
use Yii;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;


/**
 * Post controller
 */
class PostController extends Controller
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
        $searchModel   = new PostSearch();

        return $this->render('index', [
            'dataProvider'  => $searchModel->search(Yii::$app->request->queryParams, Post::POST_TYPE_POST),
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
        $model->type    = Post::POST_TYPE_POST;

        if ($model->load(Yii::$app->request->post()) && $response = $model->save())
        {
            if ($response) {
                Yii::$app->session->addFlash('success', '????erik olu??turuldu.');

                return $this->redirect(['view', 'id' => $model->_item->id]);
            }
        }

        return $this->render('create', [
            'model'         => $model,
            'categories'    => Category::getArray(),
            'tags'          => Tag::getArray(),
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
                Yii::$app->session->addFlash('success', '????erik ba??ar??yla g??ncellendi.');

                return $this->redirect(['view', 'id' => $model->_item->id]);
            }
        }

        $post_categories    = PostCategory::find()->where(['post_id' => $id])->all();
        $post_categories    = ArrayHelper::getColumn($post_categories, 'category_id');
        $model->categories  = $post_categories;

        $post_tags          = PostTag::find()->where(['post_id' => $id])->all();
        $post_tags          = ArrayHelper::getColumn($post_tags, 'tag_id');
        $model->tags        = $post_tags;

        return $this->render('update', [
            'model'         => $model,
            'categories'    => Category::getArray(),
            'tags'          => Tag::getArray(),
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

        throw new NotFoundHttpException('????erik Bulunamad??.');
    }
}

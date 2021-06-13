<?php
namespace backend\controllers;

use backend\models\CommentSearch;
use backend\models\PostForm;
use backend\models\PostSearch;
use common\models\Category;
use common\models\Comment;
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
 * Comment controller
 */
class CommentController extends Controller
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
                        'actions'   => ['index', 'view', 'confirm', 'reject', 'delete'],
                        'allow'     => true,
                        'roles'     => ['@'],
                    ],
                ],
            ],
            'verbs'     => [
                'class' => VerbFilter::class,
                'actions'   => [
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
        $searchModel   = new CommentSearch();

        return $this->render('index', [
            'dataProvider'  => $searchModel->search(Yii::$app->request->queryParams),
            'filterModel'   => $searchModel
        ]);
    }

    /**
     * Displays a single Comment model.
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
     * Confirm Comment.
     *
     * @param integer $id
     *
     * @return Response
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionConfirm(int $id): Response
    {
        $model  = $this->findModel($id);

        $model->status  = Comment::STATUS_ACTIVE;

        if ($model->save()) {
            Yii::$app->session->addFlash('success', 'Yorum onaylandı.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Reject Comment.
     *
     * @param integer $id
     *
     * @return Response
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionReject(int $id): Response
    {
        $model  = $this->findModel($id);

        $model->status  = Comment::STATUS_PASSIVE;

        if ($model->save()) {
            Yii::$app->session->addFlash('success', 'Yorum pasifleştirildi.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Delete Comment.
     *
     * @param integer $id
     *
     * @return Response
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id): Response
    {
        $model  = $this->findModel($id);

        $model->status  = Comment::STATUS_DELETED;

        if ($model->save()) {
            Yii::$app->session->addFlash('success', 'Yorum silindi.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Comment the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Comment
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Yorum Bulunamadı.');
    }
}

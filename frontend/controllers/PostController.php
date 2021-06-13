<?php
namespace frontend\controllers;

use common\models\Category;
use common\models\Comment;
use common\models\Post;
use common\models\Tag;
use frontend\models\CommentForm;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;

/**
 * Post controller
 */
class PostController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error'     => [
                'class'         => 'yii\web\ErrorAction'
            ],
            'captcha'   => [
                'class'             => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode'   => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * New Posts.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $new_posts  = Post::getItems(0, 0, 'new', 21);

        return $this->render('index', [
            'posts'         => $new_posts,
            'title'         => 'Yeni Yazılar',
            'description'   => 'Blogmus yeni yayınlanan yazıları bu sayfada görebilir, okuyabilirsiniz.'
        ]);
    }

    /**
     * Posts with category slug.
     *
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCategory($slug): string
    {
        $category   = Category::find()->where(['slug' => $slug, 'status' => Category::STATUS_ACTIVE])->one();

        if (!$category) {
            throw new NotFoundHttpException('Sayfa Bulunamadı.');
        }

        $new_posts  = Post::getItems($category->id, 0, 'new', 21);

        return $this->render('index', [
            'posts'         => $new_posts,
            'title'         => $category->name,
            'description'   => $category->description
        ]);
    }

    /**
     * Posts with tag slug.
     *
     * @param $slug
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionTag($slug): string
    {
        $tag    = Tag::find()->where(['slug' => $slug, 'status' => Tag::STATUS_ACTIVE])->one();

        if (!$tag) {
            throw new NotFoundHttpException('Sayfa Bulunamadı.');
        }

        $new_posts  = Post::getItems(0, $tag->id, 'new', 21);

        return $this->render('index', [
            'posts'         => $new_posts,
            'title'         => $tag->name,
            'description'   => $tag->description
        ]);
    }


    /**
     * view post
     *
     * @param $slug
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug): string
    {
        $post   = Post::getItem(0, $slug);

        if (!$post) {
            throw new NotFoundHttpException('Sayfa Bulunamadı.');
        }

        $comments       = false;

        if ($post->comment_status == Post::COMMENT_STATUS_ACTIVE) {
            $comments   = Comment::getItems($post->id, 'new');
        }

        return $this->render('view', [
                'post'          => $post,
                'commentForm'   => new CommentForm(),
                'comments'      => $comments
            ]
        );
    }

    public function actionSaveComment(): \yii\web\Response
    {
        $model  = new CommentForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->addFlash('success', 'Yorumunuz kontrol edilmek üzere kaydedildi. Katkınız için teşekkürler.');
            } else {
                Yii::$app->session->addFlash('error', 'HATA! Yorumunuz kaydedilemedi.');
            }
        } else {
            Yii::$app->session->addFlash('error', 'HATA! Yorumunuz kaydedilemedi.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}

<?php
namespace backend\models;

use common\models\Category;
use common\models\PostCategory;
use common\models\PostTag;
use common\models\Tag;
use common\my\Helper;
use Yii;
use yii\base\Model;
use common\models\Post;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\imagine\Image;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


/**
 * Class PostForm
 *
 * @package backend\models
 *
 * @property Post $_item
 */
class PostForm extends Model
{
    public $_item;

    public $type;
    public $slug;
    public $title;
    public $image;
    public $description;
    public $content;
    public $comment_status;
    public $post_date;
    public $post_status;

    public $categories;
    public $tags;

    public function __construct($config = [])
    {
        $this->_item   = new Post();

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return  array_merge(
            $this->_item->rules(),
            [
                [['slug', 'title', 'description', 'content'], 'string'],
                [['type', 'comment_status', 'post_status'], 'integer'],
                [['title', 'content'], 'required'],

                [['categories', 'tags'], 'safe'],

                ['image', 'safe'],
                ['image', 'file', 'skipOnEmpty' => true],

                ['type', 'in', 'range' => [Post::POST_TYPE_PAGE, Post::POST_TYPE_POST]],
                ['comment_status', 'in', 'range' => array_keys(Post::$comment_statuses)],
                ['post_status', 'in', 'range' => array_keys(Post::$post_statuses)],
            ]
        );
    }


    public function attributeLabels(): array
    {
        return Post::$labels;
    }

    /**
     * Varolan bir kayıt değiştirilmek isteniyorsa bunu çalıştırmak lazım.
     *
     * @param $id
     * @throws NotFoundHttpException
     */
    public function findItem($id)
    {
        $this->_item    = Post::findOne($id);

        if (!$this->_item) {
            throw new NotFoundHttpException('İçerik Bulunamadı.');
        }

        $this->setAttributes($this->_item->getAttributes());
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @return bool
     */
    public function save(bool $runValidation = true, $attributeNames = null): bool
    {
        if ($this->validate())
        {
            $this->_item->type              = $this->type;
            $this->_item->slug              = empty($this->slug) ? Helper::slugify($this->title) : Helper::slugify($this->slug);
            $this->_item->title             = $this->title;
            $this->_item->description       = $this->description;
            $this->_item->content           = $this->content;
            $this->_item->comment_status    = $this->comment_status;
            $this->_item->post_date         = $this->post_date;
            $this->_item->post_status       = $this->post_status;

            $file       = UploadedFile::getInstances($this, 'image');

            if (isset($file[0]->name)) {
                $file_name = $this->_item->slug.'.'.$file[0]->extension;

                if ($file[0]->saveAs(Yii::$app->params['postImageDirectory'] . 'org_' . $file_name)) {
                    Image::thumbnail(Yii::$app->params['postImageDirectory'] . 'org_' . $file_name, 250, 250)
                        ->save(Yii::$app->params['postImageDirectory'] . $file_name, ['quality' => 74]);

                    $this->_item->image = $file_name;
                }
            }

            if ($this->_item->save($runValidation, $attributeNames)) {

                if (is_array($this->categories) && count($this->categories) > 0) {
                    $get_categories = Category::find()->select('id')->where(['id' => $this->categories])->all();

                    foreach ($get_categories as $get_category) {
                        PostCategory::add($this->_item->id, $get_category->id);
                    }
                }

                if (is_array($this->tags) && count($this->tags) > 0) {
                    $get_tags   = Tag::find()->select('id')->where(['id' => $this->tags])->all();
                    $get_tags   = ArrayHelper::index($get_tags, 'id');

                    foreach ($get_tags as $get_tag) {
                        PostTag::add($this->_item->id, $get_tag->id);
                    }

                    foreach ($this->tags as $tag) {
                        if (!(intval($tag) > 0 && isset($get_tags[$tag])) && strlen($tag) > 1){
                            $new_tag    = Tag::add($tag);

                            if ($new_tag > 0) {
                                PostTag::add($this->_item->id, $new_tag);
                            }
                        }
                    }
                }

                return true;
            }
        }

        return false;
    }


}